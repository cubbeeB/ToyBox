<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\StoreSetting;

class ContentController extends Controller
{
    public function about()
    {
        return view('pages.about', [
            'mission' => StoreSetting::value('mission'),
        ]);
    }

    public function articles()
    {
        return view('content.articles', [
            'articles' => Article::query()->published()->latest('published_at')->paginate(9),
        ]);
    }

    public function article(Article $article)
    {
        abort_unless($article->is_published, 404);

        return view('content.article', ['article' => $article]);
    }

    public function promotions()
    {
        return view('content.promotions', [
            'promotions' => Promotion::query()->current()->latest()->paginate(9),
        ]);
    }

    public function reviews()
    {
        return view('content.reviews', [
            'reviews' => Review::query()->with('product')->approved()->latest()->paginate(10),
        ]);
    }
}
