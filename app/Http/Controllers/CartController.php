<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index', $this->cartViewData());
    }

    public function add(Request $request, Product $product)
    {
        abort_unless($product->is_active && $product->published_at, 404);

        $data = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);
        $cart[$product->id] = min(($cart[$product->id] ?? 0) + ($data['quantity'] ?? 1), max($product->stock, 1));
        session(['cart' => $cart]);

        return back()->with('status', 'Товар добавлен в корзину.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'items' => ['required', 'array'],
            'items.*' => ['integer', 'min:1', 'max:99'],
        ]);

        session(['cart' => $data['items']]);

        return back()->with('status', 'Корзина обновлена.');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('status', 'Товар удалён из корзины.');
    }

    public function applyPromo(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $code = mb_strtoupper(trim($data['code']));
        $promoCode = PromoCode::query()->available()->where('code', $code)->first();

        if (! $promoCode) {
            return back()->withErrors(['code' => 'Промокод не найден или больше не действует.']);
        }

        session(['promo_code' => $promoCode->code]);

        return back()->with('status', 'Промокод применён.');
    }

    public function checkout(Request $request)
    {
        $cartData = $this->cartViewData();

        if ($cartData['items']->isEmpty()) {
            return redirect()->route('cart.index')->withErrors(['cart' => 'Корзина пуста.']);
        }

        $data = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:50'],
            'delivery_address' => ['required', 'string', 'max:1000'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        $order = DB::transaction(function () use ($data, $cartData) {
            $order = Order::query()->create([
                ...$data,
                'user_id' => auth()->id(),
                'number' => 'TB-'.now()->format('Ymd').'-'.random_int(1000, 9999),
                'subtotal' => $cartData['subtotal'],
                'delivery_cost' => $cartData['deliveryCost'],
                'discount_amount' => $cartData['discount'],
                'total' => $cartData['total'],
                'promo_code' => session('promo_code'),
            ]);

            foreach ($cartData['items'] as $item) {
                $order->items()->create([
                    'product_id' => $item['product']->id,
                    'product_name' => $item['product']->name,
                    'sku' => $item['product']->sku,
                    'price' => $item['product']->price,
                    'quantity' => $item['quantity'],
                    'total' => $item['lineTotal'],
                ]);

                $item['product']->decrement('stock', min($item['quantity'], $item['product']->stock));
            }

            if ($cartData['promoCode']) {
                $cartData['promoCode']->increment('used_count');
            }

            return $order;
        });

        session()->forget(['cart', 'promo_code']);

        return redirect()->route('account.index')->with('status', 'Заказ '.$order->number.' оформлен.');
    }

    private function cartViewData(): array
    {
        $cart = session('cart', []);
        $products = Product::query()->whereKey(array_keys($cart))->get()->keyBy('id');

        $items = collect($cart)->map(function (int $quantity, int|string $productId) use ($products) {
            $product = $products->get((int) $productId);

            if (! $product) {
                return null;
            }

            return [
                'product' => $product,
                'quantity' => $quantity,
                'lineTotal' => (float) $product->price * $quantity,
            ];
        })->filter()->values();

        $subtotal = $items->sum('lineTotal');
        $deliveryCost = $subtotal >= 5000 || $subtotal === 0 ? 0 : 350;
        $promoCode = session('promo_code')
            ? PromoCode::query()->available()->where('code', session('promo_code'))->first()
            : null;
        $discount = $promoCode?->discountFor($subtotal) ?? 0;

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'deliveryCost' => $deliveryCost,
            'promoCode' => $promoCode,
            'discount' => $discount,
            'total' => max($subtotal + $deliveryCost - $discount, 0),
        ];
    }
}
