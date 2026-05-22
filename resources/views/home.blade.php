@extends('layouts.app')

@section('title', 'ToyBox - интернет-магазин игрушек')
@section('meta_description', 'ToyBox: каталог игрушек с фильтрами по возрасту, брендам, цене и категориям. Новинки, хиты продаж, акции и полезные статьи.')

@section('content')
    <section class="mx-auto grid max-w-7xl items-center gap-8 px-4 py-12 lg:grid-cols-[1.2fr_.8fr]">
        <div class="space-y-6">
            <span class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-sm font-bold text-emerald-800">Безопасные игрушки для счастливого детства</span>
            <h1 class="text-4xl font-black leading-tight text-slate-950 md:text-6xl">ToyBox помогает выбрать игрушку по возрасту, интересам и пользе для развития.</h1>
            <p class="max-w-2xl text-lg text-slate-600">Собрали мягкие игрушки, конструкторы, настольные игры и развивающие наборы с понятными фильтрами, отзывами и быстрой корзиной.</p>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('catalog.index') }}" class="rounded-full bg-emerald-600 px-6 py-3 font-bold text-white">Перейти в каталог</a>
                <a href="{{ route('promotions.index') }}" class="rounded-full bg-amber-300 px-6 py-3 font-bold text-slate-900">Смотреть акции</a>
            </div>
        </div>
        <div class="rounded-[2rem] bg-gradient-to-br from-amber-200 via-rose-100 to-emerald-100 p-8 shadow-sm">
            <div class="rounded-[1.5rem] bg-white p-6">
                <div class="text-sm font-bold uppercase tracking-wide text-rose-500">Новое поступление</div>
                <div class="mt-4 text-3xl font-black">Игры для семейных вечеров</div>
                <p class="mt-3 text-slate-600">Подборки по возрасту, рейтингу и интересам ребёнка.</p>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <p class="font-bold text-emerald-700">Новинки</p>
                <h2 class="text-3xl font-black text-slate-950">Недавно поступили</h2>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'new']) }}" class="font-bold text-emerald-700">Все новинки</a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($newProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-8">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <p class="font-bold text-rose-500">Хиты продаж</p>
                <h2 class="text-3xl font-black text-slate-950">Выбор родителей</h2>
            </div>
            <a href="{{ route('catalog.index', ['sort' => 'popular']) }}" class="font-bold text-emerald-700">Все хиты</a>
        </div>
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($hitProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>

    <section class="mx-auto grid max-w-7xl gap-6 px-4 py-8 lg:grid-cols-3">
        @foreach($promotions as $promotion)
            <article class="rounded-3xl bg-rose-500 p-6 text-white shadow-sm">
                <div class="text-sm font-bold uppercase">{{ $promotion->discount_label }}</div>
                <h3 class="mt-3 text-2xl font-black">{{ $promotion->title }}</h3>
                <p class="mt-2 text-rose-50">{{ $promotion->description }}</p>
            </article>
        @endforeach
    </section>

    <section class="mx-auto grid max-w-7xl gap-6 px-4 py-8 lg:grid-cols-2">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <h2 class="text-2xl font-black">Полезные статьи</h2>
            <div class="mt-4 space-y-4">
                @foreach($articles as $article)
                    <a href="{{ route('articles.show', $article) }}" class="block rounded-2xl bg-amber-50 p-4 hover:bg-amber-100">
                        <div class="font-bold">{{ $article->title }}</div>
                        <p class="text-sm text-slate-600">{{ $article->excerpt }}</p>
                    </a>
                @endforeach
            </div>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <h2 class="text-2xl font-black">Отзывы покупателей</h2>
            <div class="mt-4 space-y-4">
                @foreach($reviews as $review)
                    <blockquote class="rounded-2xl bg-emerald-50 p-4">
                        <div class="font-bold">{{ $review->author_name }} · ★ {{ $review->rating }}</div>
                        <p class="text-sm text-slate-600">{{ $review->body }}</p>
                    </blockquote>
                @endforeach
            </div>
        </div>
    </section>
@endsection
