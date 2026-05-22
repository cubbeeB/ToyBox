<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Review;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('home', [
            'newProducts' => Product::query()->with(['category', 'brand'])->published()->where('is_new', true)->latest()->take(4)->get(),
            'hitProducts' => Product::query()->with(['category', 'brand'])->published()->where('is_hit', true)->orderByDesc('popularity')->take(4)->get(),
            'promotions' => Promotion::query()->current()->latest()->take(3)->get(),
            'articles' => Article::query()->published()->latest('published_at')->take(3)->get(),
            'reviews' => Review::query()->approved()->latest()->take(3)->get(),
        ]);
    }
}
