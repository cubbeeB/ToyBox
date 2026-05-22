<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\PromoCode;
use App\Models\Promotion;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.content.index', [
            'articles' => Article::query()->latest()->get(),
            'promotions' => Promotion::query()->latest()->get(),
            'promoCodes' => PromoCode::query()->latest()->get(),
            'reviews' => Review::query()->with('product')->latest()->get(),
        ]);
    }

    public function storeArticle(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'excerpt' => ['required', 'string', 'max:500'],
            'body' => ['required', 'string'],
            'tags' => ['nullable', 'string', 'max:500'],
        ]);

        Article::query()->create([
            ...$data,
            'slug' => Str::slug($data['title']).'-'.Str::random(5),
            'tags' => collect(explode(',', $data['tags'] ?? ''))->map(fn ($tag) => trim($tag))->filter()->values()->all(),
            'is_published' => true,
            'published_at' => now(),
        ]);

        return back()->with('status', 'Статья опубликована.');
    }

    public function storePromotion(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'discount_label' => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
        ]);

        Promotion::query()->create([
            ...$data,
            'slug' => Str::slug($data['title']).'-'.Str::random(5),
            'is_active' => true,
            'starts_at' => now(),
            'ends_at' => now()->addMonth(),
        ]);

        return back()->with('status', 'Акция создана.');
    }

    public function storePromoCode(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:50', 'unique:promo_codes,code'],
            'type' => ['required', 'in:percent,fixed'],
            'value' => ['required', 'numeric', 'min:0'],
            'min_order_amount' => ['nullable', 'numeric', 'min:0'],
            'expires_at' => ['nullable', 'date'],
        ]);

        PromoCode::query()->create([
            ...$data,
            'code' => mb_strtoupper($data['code']),
            'is_active' => true,
        ]);

        return back()->with('status', 'Промокод создан.');
    }

    public function approveReview(Review $review)
    {
        $review->update([
            'status' => 'approved',
            'approved_at' => now(),
        ]);

        return back()->with('status', 'Отзыв опубликован.');
    }

    public function destroyReview(Review $review)
    {
        $review->delete();

        return back()->with('status', 'Отзыв удалён.');
    }
}
