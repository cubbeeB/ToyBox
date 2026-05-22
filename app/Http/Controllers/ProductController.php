<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        abort_unless($product->is_active && $product->published_at, 404);

        $product->load(['category', 'brand', 'reviews' => fn ($query) => $query->approved()->latest()]);

        return view('catalog.show', [
            'product' => $product,
            'relatedProducts' => Product::query()
                ->with(['category', 'brand'])
                ->published()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->orderByDesc('popularity')
                ->take(4)
                ->get(),
        ]);
    }
}
