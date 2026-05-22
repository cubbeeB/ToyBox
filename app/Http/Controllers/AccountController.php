<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load([
            'orders.items',
            'addresses',
            'favorites.category',
            'favorites.brand',
        ]);

        return view('account.index', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'birthday' => ['nullable', 'date'],
        ]);

        $request->user()->update($data);

        return back()->with('status', 'Личные данные обновлены.');
    }

    public function storeAddress(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:100'],
            'apartment' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:30'],
            'is_default' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_default')) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        UserAddress::query()->create([
            ...$data,
            'user_id' => $request->user()->id,
            'is_default' => $request->boolean('is_default'),
        ]);

        return back()->with('status', 'Адрес доставки добавлен.');
    }

    public function toggleFavorite(Product $product)
    {
        auth()->user()->favorites()->toggle($product->id);

        return back()->with('status', 'Избранное обновлено.');
    }
}
