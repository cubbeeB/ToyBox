<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
            ->with(['category', 'brand'])
            ->published()
            ->when($request->filled('q'), fn ($query) => $query->where('name', 'like', '%'.$request->string('q')->toString().'%'))
            ->when($request->filled('category'), fn ($query) => $query->whereHas('category', fn ($query) => $query->where('slug', $request->string('category'))))
            ->when($request->filled('brand'), fn ($query) => $query->whereHas('brand', fn ($query) => $query->where('slug', $request->string('brand'))))
            ->when($request->filled('age'), fn ($query) => $query->where('age_group', $request->string('age')))
            ->when($request->filled('gender'), fn ($query) => $query->where('gender', $request->string('gender')))
            ->when($request->filled('price_from'), fn ($query) => $query->where('price', '>=', (float) $request->input('price_from')))
            ->when($request->filled('price_to'), fn ($query) => $query->where('price', '<=', (float) $request->input('price_to')));

        match ($request->input('sort', 'popular')) {
            'new' => $products->latest('published_at'),
            'price_asc' => $products->orderBy('price'),
            'price_desc' => $products->orderByDesc('price'),
            'rating' => $products->orderByDesc('rating'),
            default => $products->orderByDesc('popularity'),
        };

        return view('catalog.index', [
            'products' => $products->paginate(12)->withQueryString(),
            'categories' => Category::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'brands' => Brand::query()->where('is_active', true)->orderBy('name')->get(),
            'ageGroups' => Product::AGE_GROUPS,
            'genders' => Product::GENDERS,
        ]);
    }

    public function search(Request $request)
    {
        $term = $request->string('q')->toString();

        return Product::query()
            ->published()
            ->where('name', 'like', '%'.$term.'%')
            ->orderByDesc('popularity')
            ->take(8)
            ->get(['name', 'slug', 'price']);
    }
}
