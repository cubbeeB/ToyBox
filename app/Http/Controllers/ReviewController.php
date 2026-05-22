<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, ?Product $product = null)
    {
        $data = $request->validate([
            'author_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'body' => ['required', 'string', 'max:2000'],
        ]);

        Review::query()->create([
            ...$data,
            'user_id' => auth()->id(),
            'product_id' => $product?->id,
            'status' => 'pending',
        ]);

        return back()->with('status', 'Отзыв отправлен на модерацию.');
    }
}
