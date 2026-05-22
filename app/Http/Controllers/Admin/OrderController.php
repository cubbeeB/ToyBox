<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        return view('admin.orders.index', [
            'orders' => Order::query()->with('items')->latest()->paginate(20),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        abort(404);
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', [
            'order' => $order->load('items'),
            'statuses' => Order::STATUSES,
        ]);
    }

    public function edit(Order $order)
    {
        return $this->show($order);
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Order::STATUSES))],
        ]);

        $order->update($data);

        return back()->with('status', 'Статус заказа обновлён.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('status', 'Заказ удалён.');
    }
}
