@extends('layouts.app')

@section('title', 'Каталог игрушек - ToyBox')
@section('meta_description', 'Каталог ToyBox с фильтрацией по категориям, возрасту, полу, брендам, цене и сортировкой по популярности, новизне, цене и рейтингу.')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <div class="mb-8">
            <p class="font-bold text-emerald-700">Каталог</p>
            <h1 class="text-4xl font-black text-slate-950">Игрушки для любого возраста</h1>
        </div>

        <div class="grid gap-8 lg:grid-cols-[280px_1fr]">
            <aside class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-amber-100">
                <form class="space-y-4">
                    <input name="q" value="{{ request('q') }}" placeholder="Название товара" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                    <select name="category" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <option value="">Все категории</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <select name="age" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <option value="">Любой возраст</option>
                        @foreach($ageGroups as $age)
                            <option value="{{ $age }}" @selected(request('age') === $age)>{{ $age }} лет</option>
                        @endforeach
                    </select>
                    <select name="gender" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <option value="">Для всех</option>
                        <option value="boys" @selected(request('gender') === 'boys')>Для мальчиков</option>
                        <option value="girls" @selected(request('gender') === 'girls')>Для девочек</option>
                        <option value="unisex" @selected(request('gender') === 'unisex')>Универсальные</option>
                    </select>
                    <select name="brand" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <option value="">Все бренды</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->slug }}" @selected(request('brand') === $brand->slug)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                    <div class="grid grid-cols-2 gap-2">
                        <input name="price_from" value="{{ request('price_from') }}" placeholder="Цена от" class="rounded-2xl border border-amber-200 px-4 py-2">
                        <input name="price_to" value="{{ request('price_to') }}" placeholder="до" class="rounded-2xl border border-amber-200 px-4 py-2">
                    </div>
                    <select name="sort" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <option value="popular" @selected(request('sort') === 'popular')>По популярности</option>
                        <option value="new" @selected(request('sort') === 'new')>По новизне</option>
                        <option value="price_asc" @selected(request('sort') === 'price_asc')>Цена по возрастанию</option>
                        <option value="price_desc" @selected(request('sort') === 'price_desc')>Цена по убыванию</option>
                        <option value="rating" @selected(request('sort') === 'rating')>По рейтингу</option>
                    </select>
                    <button class="w-full rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Применить фильтры</button>
                </form>
            </aside>

            <div>
                <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="rounded-3xl bg-white p-8 text-slate-600">По выбранным фильтрам товары не найдены.</div>
                    @endforelse
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            </div>
        </div>
    </section>
@endsection
