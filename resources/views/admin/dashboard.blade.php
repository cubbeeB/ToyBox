@extends('layouts.app')

@section('title', 'Админ-панель ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black text-slate-950">Административная панель</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-4">
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-amber-100"><div class="text-sm text-slate-500">Заказы</div><div class="text-3xl font-black">{{ $ordersCount }}</div></div>
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-amber-100"><div class="text-sm text-slate-500">Продажи</div><div class="text-3xl font-black">{{ number_format((float) $salesTotal, 0, ',', ' ') }} ₽</div></div>
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-amber-100"><div class="text-sm text-slate-500">Товары</div><div class="text-3xl font-black">{{ $productsCount }}</div></div>
            <div class="rounded-3xl bg-white p-5 shadow-sm ring-1 ring-amber-100"><div class="text-sm text-slate-500">Пользователи</div><div class="text-3xl font-black">{{ $usersCount }}</div></div>
        </div>
        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('admin.products.index') }}" class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Товары</a>
            <a href="{{ route('admin.orders.index') }}" class="rounded-full bg-amber-300 px-5 py-3 font-bold text-slate-900">Заказы</a>
            <a href="{{ route('admin.content.index') }}" class="rounded-full bg-rose-500 px-5 py-3 font-bold text-white">Контент и отзывы</a>
            <a href="{{ route('admin.settings.edit') }}" class="rounded-full bg-slate-900 px-5 py-3 font-bold text-white">Настройки</a>
        </div>
        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">Популярные товары</h2>
                <div class="mt-4 space-y-3">
                    @foreach($popularProducts as $product)
                        <div class="flex justify-between rounded-2xl bg-amber-50 p-3"><span>{{ $product->name }}</span><b>{{ $product->popularity }}</b></div>
                    @endforeach
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">Отзывы на модерации</h2>
                <div class="mt-4 space-y-3">
                    @forelse($pendingReviews as $review)
                        <div class="rounded-2xl bg-rose-50 p-3">{{ $review->author_name }}: {{ $review->body }}</div>
                    @empty
                        <p class="text-slate-600">Нет ожидающих отзывов.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
