@extends('layouts.app')

@section('title', $product->name.' - ToyBox')
@section('meta_description', str($product->description)->limit(150))

@push('schema')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@type": "Product",
            "name": @json($product->name),
            "description": @json($product->description),
            "sku": @json($product->sku),
            "brand": {"@type": "Brand", "name": @json($product->brand?->name)},
            "aggregateRating": {"@type": "AggregateRating", "ratingValue": "{{ $product->rating }}", "reviewCount": "{{ $product->reviews_count }}"},
            "offers": {"@type": "Offer", "priceCurrency": "RUB", "price": "{{ $product->price }}", "availability": "https://schema.org/InStock"}
        }
    </script>
@endpush

@php
    $customImageUrl = $product->image_url;
    $hasReliableCustomImage = filled($customImageUrl) && ! str($customImageUrl)->contains('images.unsplash.com');
    $themedImageUrl = match ($product->category?->slug) {
        'soft-toys' => asset('images/products/soft-toys.svg'),
        'constructors' => asset('images/products/constructors.svg'),
        'board-games' => asset('images/products/board-games.svg'),
        'educational-toys' => asset('images/products/educational-toys.svg'),
        default => asset('images/products/default-toys.svg'),
    };
    $imageUrl = $hasReliableCustomImage ? $customImageUrl : $themedImageUrl;
@endphp

@section('content')
    <section class="mx-auto grid max-w-7xl gap-10 px-4 py-10 lg:grid-cols-2">
        <div class="overflow-hidden rounded-[2rem] bg-white shadow-sm ring-1 ring-amber-100">
            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-full min-h-[420px] w-full object-cover">
        </div>
        <div class="space-y-6">
            <div>
                <p class="font-bold text-emerald-700">{{ $product->category?->name }} · {{ $product->brand?->name }}</p>
                <h1 class="mt-2 text-4xl font-black text-slate-950">{{ $product->name }}</h1>
                <p class="mt-4 text-lg text-slate-600">{{ $product->description }}</p>
            </div>
            <div class="flex flex-wrap gap-2 text-sm font-bold">
                <span class="rounded-full bg-amber-100 px-3 py-1">Возраст {{ $product->age_group }} лет</span>
                <span class="rounded-full bg-emerald-100 px-3 py-1">Рейтинг ★ {{ $product->rating }}</span>
                <span class="rounded-full bg-rose-100 px-3 py-1">Остаток {{ $product->stock }}</span>
            </div>
            <ul class="grid gap-2 text-slate-700">
                @foreach($product->features ?? [] as $feature)
                    <li class="rounded-2xl bg-white px-4 py-3 shadow-sm ring-1 ring-amber-100">{{ $feature }}</li>
                @endforeach
            </ul>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <div class="text-3xl font-black text-emerald-700">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</div>
                @if($product->hasDiscount())
                    <div class="text-slate-400 line-through">{{ number_format((float) $product->old_price, 0, ',', ' ') }} ₽</div>
                @endif
                <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-4 flex gap-3">
                    @csrf
                    <input type="number" name="quantity" value="1" min="1" max="99" class="w-24 rounded-2xl border border-amber-200 px-4 py-2">
                    <button class="rounded-full bg-rose-500 px-6 py-3 font-bold text-white">В корзину</button>
                </form>
            </div>
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-8 px-4 py-8 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <h2 class="text-2xl font-black">Отзывы</h2>
            <div class="mt-4 space-y-4">
                @forelse($product->reviews as $review)
                    <blockquote class="rounded-2xl bg-emerald-50 p-4">
                        <div class="font-bold">{{ $review->author_name }} · ★ {{ $review->rating }}</div>
                        <p class="text-sm text-slate-600">{{ $review->body }}</p>
                    </blockquote>
                @empty
                    <p class="text-slate-600">Пока нет опубликованных отзывов.</p>
                @endforelse
            </div>
        </div>
        <form method="POST" action="{{ route('reviews.store', $product) }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            <h2 class="text-2xl font-black">Добавить отзыв</h2>
            <div class="mt-4 grid gap-3">
                <input name="author_name" value="{{ old('author_name', auth()->user()?->name) }}" placeholder="Ваше имя" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="email" value="{{ old('email', auth()->user()?->email) }}" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                <select name="rating" class="rounded-2xl border border-amber-200 px-4 py-2">
                    @for($rating = 5; $rating >= 1; $rating--)
                        <option value="{{ $rating }}">{{ $rating }}</option>
                    @endfor
                </select>
                <textarea name="body" rows="4" placeholder="Ваш отзыв" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('body') }}</textarea>
                <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Отправить на модерацию</button>
            </div>
        </form>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8">
        <h2 class="mb-6 text-3xl font-black">Сопутствующие товары</h2>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($relatedProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
@endsection
