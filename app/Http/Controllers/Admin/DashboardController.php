<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class DashboardController extends Controller
{
    public function __invoke()
    {
        return view('admin.dashboard', [
            'ordersCount' => Order::query()->count(),
            'salesTotal' => Order::query()->whereIn('status', ['processing', 'shipped', 'completed'])->sum('total'),
            'productsCount' => Product::query()->count(),
            'usersCount' => User::query()->count(),
            'pendingReviews' => Review::query()->where('status', 'pending')->latest()->get(),
            'popularProducts' => Product::query()->orderByDesc('popularity')->take(5)->get(),
            'recentOrders' => Order::query()->latest()->take(5)->get(),
        ]);
    }
}
