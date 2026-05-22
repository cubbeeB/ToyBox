@extends('layouts.app')

@section('title', 'Корзина - ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black text-slate-950">Корзина</h1>
        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_380px]">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @if($items->isEmpty())
                    <p class="text-slate-600">Корзина пуста. Загляните в каталог и выберите игрушки.</p>
                    <a href="{{ route('catalog.index') }}" class="mt-4 inline-flex rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">В каталог</a>
                @else
                    <form method="POST" action="{{ route('cart.update') }}" class="space-y-4">
                        @csrf
                        @method('PATCH')
                        @foreach($items as $item)
                            <div class="grid gap-4 rounded-2xl bg-amber-50 p-4 md:grid-cols-[1fr_120px_120px_auto] md:items-center">
                                <div>
                                    <div class="font-bold">{{ $item['product']->name }}</div>
                                    <div class="text-sm text-slate-600">{{ number_format((float) $item['product']->price, 0, ',', ' ') }} ₽ за шт.</div>
                                </div>
                                <input type="number" name="items[{{ $item['product']->id }}]" value="{{ $item['quantity'] }}" min="1" max="99" class="rounded-2xl border border-amber-200 px-4 py-2">
                                <div class="font-black">{{ number_format($item['lineTotal'], 0, ',', ' ') }} ₽</div>
                                <button form="remove-{{ $item['product']->id }}" class="text-sm font-bold text-rose-600">Удалить</button>
                            </div>
                        @endforeach
                        <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Обновить количество</button>
                    </form>
                    @foreach($items as $item)
                        <form id="remove-{{ $item['product']->id }}" method="POST" action="{{ route('cart.remove', $item['product']) }}">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endforeach
                @endif
            </div>

            <aside class="space-y-4">
                <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                    <h2 class="text-2xl font-black">Итого</h2>
                    <dl class="mt-4 space-y-3 text-sm">
                        <div class="flex justify-between"><dt>Товары</dt><dd>{{ number_format($subtotal, 0, ',', ' ') }} ₽</dd></div>
                        <div class="flex justify-between"><dt>Доставка</dt><dd>{{ number_format($deliveryCost, 0, ',', ' ') }} ₽</dd></div>
                        <div class="flex justify-between"><dt>Скидка</dt><dd>-{{ number_format($discount, 0, ',', ' ') }} ₽</dd></div>
                        <div class="flex justify-between border-t border-amber-100 pt-3 text-xl font-black"><dt>К оплате</dt><dd>{{ number_format($total, 0, ',', ' ') }} ₽</dd></div>
                    </dl>
                    @if($promoCode)
                        <p class="mt-3 rounded-2xl bg-emerald-50 p-3 text-sm text-emerald-800">Применён промокод {{ $promoCode->code }}</p>
                    @endif
                </div>
                <form method="POST" action="{{ route('cart.promo') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                    @csrf
                    <label class="text-sm font-bold">Промокод</label>
                    <div class="mt-2 flex gap-2">
                        <input name="code" placeholder="TOYBOX10" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        <button class="rounded-full bg-amber-300 px-4 py-2 font-bold">OK</button>
                    </div>
                </form>
                <form method="POST" action="{{ route('cart.checkout') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                    @csrf
                    <h2 class="text-2xl font-black">Оформление</h2>
                    <div class="mt-4 grid gap-3">
                        <input name="customer_name" value="{{ old('customer_name', auth()->user()?->name) }}" placeholder="Имя" class="rounded-2xl border border-amber-200 px-4 py-2">
                        <input name="customer_email" value="{{ old('customer_email', auth()->user()?->email) }}" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                        <input name="customer_phone" value="{{ old('customer_phone', auth()->user()?->phone) }}" placeholder="Телефон" class="rounded-2xl border border-amber-200 px-4 py-2">
                        <textarea name="delivery_address" rows="3" placeholder="Адрес доставки" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('delivery_address') }}</textarea>
                        <textarea name="comment" rows="2" placeholder="Комментарий" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('comment') }}</textarea>
                        <button @disabled($items->isEmpty()) class="rounded-full bg-rose-500 px-5 py-3 font-bold text-white disabled:opacity-50">Оформить заказ</button>
                    </div>
                </form>
            </aside>
        </div>
    </section>
@endsection
