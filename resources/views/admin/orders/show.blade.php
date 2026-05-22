@extends('layouts.app')

@section('title', 'Заказ '.$order->number.' - ToyBox')

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-10">
        <h1 class="text-4xl font-black">Заказ {{ $order->number }}</h1>
        <div class="mt-8 grid gap-8 lg:grid-cols-[1fr_320px]">
            <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">Состав заказа</h2>
                <div class="mt-4 space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex justify-between rounded-2xl bg-amber-50 p-4">
                            <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                            <b>{{ number_format((float) $item->total, 0, ',', ' ') }} ₽</b>
                        </div>
                    @endforeach
                </div>
            </div>
            <aside class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                <h2 class="text-2xl font-black">Данные</h2>
                <div class="mt-4 space-y-2 text-sm text-slate-700">
                    <p>{{ $order->customer_name }}</p>
                    <p>{{ $order->customer_email }}</p>
                    <p>{{ $order->customer_phone }}</p>
                    <p>{{ $order->delivery_address }}</p>
                    <p><b>Итого:</b> {{ number_format((float) $order->total, 0, ',', ' ') }} ₽</p>
                </div>
                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-5">
                    @csrf
                    @method('PUT')
                    <select name="status" class="w-full rounded-2xl border border-amber-200 px-4 py-2">
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" @selected($order->status === $key)>{{ $label }}</option>
                        @endforeach
                    </select>
                    <button class="mt-3 w-full rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Обновить статус</button>
                </form>
            </aside>
        </div>
    </section>
@endsection
