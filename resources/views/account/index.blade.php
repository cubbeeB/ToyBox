@extends('layouts.app')

@section('title', 'Личный кабинет - ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-4xl font-black text-slate-950">Личный кабинет</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-full bg-slate-900 px-5 py-3 font-bold text-white">Выйти</button>
            </form>
        </div>
        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <form method="POST" action="{{ route('account.update') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @csrf
                @method('PATCH')
                <h2 class="text-2xl font-black">Личные данные</h2>
                <div class="mt-4 grid gap-3">
                    <input name="name" value="{{ old('name', $user->name) }}" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input value="{{ $user->email }}" disabled class="rounded-2xl border border-amber-200 bg-slate-50 px-4 py-2">
                    <input name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Телефон" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="birthday" type="date" value="{{ old('birthday', optional($user->birthday)->format('Y-m-d')) }}" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Сохранить</button>
                </div>
            </form>
            <form method="POST" action="{{ route('account.addresses.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @csrf
                <h2 class="text-2xl font-black">Адрес доставки</h2>
                <div class="mt-4 grid gap-3">
                    <input name="title" placeholder="Название адреса" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="city" placeholder="Город" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="street" placeholder="Улица" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <div class="grid grid-cols-2 gap-3">
                        <input name="building" placeholder="Дом" class="rounded-2xl border border-amber-200 px-4 py-2">
                        <input name="apartment" placeholder="Квартира" class="rounded-2xl border border-amber-200 px-4 py-2">
                    </div>
                    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="is_default" value="1"> Основной адрес</label>
                    <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Добавить</button>
                </div>
            </form>
        </div>

        <div class="mt-8 grid gap-8 lg:grid-cols-2">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">История заказов</h2>
                <div class="mt-4 space-y-3">
                    @forelse($user->orders as $order)
                        <div class="rounded-2xl bg-amber-50 p-4">
                            <div class="font-bold">{{ $order->number }} · {{ \App\Models\Order::STATUSES[$order->status] ?? $order->status }}</div>
                            <div class="text-sm text-slate-600">{{ number_format((float) $order->total, 0, ',', ' ') }} ₽ · {{ $order->created_at->format('d.m.Y') }}</div>
                        </div>
                    @empty
                        <p class="text-slate-600">Заказов пока нет.</p>
                    @endforelse
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">Избранное</h2>
                <div class="mt-4 grid gap-3">
                    @forelse($user->favorites as $product)
                        <a href="{{ route('products.show', $product) }}" class="rounded-2xl bg-emerald-50 p-4 font-bold text-emerald-800">{{ $product->name }}</a>
                    @empty
                        <p class="text-slate-600">Добавляйте товары в избранное из каталога.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
@endsection
