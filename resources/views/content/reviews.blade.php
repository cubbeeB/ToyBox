@extends('layouts.app')

@section('title', 'Отзывы - ToyBox')

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-10">
        <h1 class="text-4xl font-black text-slate-950">Отзывы о магазине и товарах</h1>
        <div class="mt-8 space-y-4">
            @foreach($reviews as $review)
                <blockquote class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                    <div class="font-bold">{{ $review->author_name }} · ★ {{ $review->rating }}</div>
                    @if($review->product)
                        <a href="{{ route('products.show', $review->product) }}" class="text-sm font-semibold text-emerald-700">{{ $review->product->name }}</a>
                    @endif
                    <p class="mt-3 text-slate-600">{{ $review->body }}</p>
                </blockquote>
            @endforeach
        </div>
        <div class="mt-8">{{ $reviews->links() }}</div>

        <form method="POST" action="{{ route('reviews.store') }}" class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            <h2 class="text-2xl font-black">Оставить отзыв о магазине</h2>
            <div class="mt-4 grid gap-3">
                <input name="author_name" value="{{ old('author_name', auth()->user()?->name) }}" placeholder="Ваше имя" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                <select name="rating" class="rounded-2xl border border-amber-200 px-4 py-2">
                    @for($rating = 5; $rating >= 1; $rating--)
                        <option value="{{ $rating }}">{{ $rating }}</option>
                    @endfor
                </select>
                <textarea name="body" rows="4" placeholder="Ваш отзыв" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('body') }}</textarea>
                <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Отправить</button>
            </div>
        </form>
    </section>
@endsection
