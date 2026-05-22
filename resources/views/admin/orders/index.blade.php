@extends('layouts.app')

@section('title', 'Заказы - админка ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black">Заказы</h1>
        <div class="mt-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-amber-100">
            @foreach($orders as $order)
                <div class="grid gap-3 border-b border-amber-100 p-4 md:grid-cols-[1fr_180px_160px_auto] md:items-center">
                    <div><b>{{ $order->number }}</b><div class="text-sm text-slate-500">{{ $order->customer_name }} · {{ $order->customer_phone }}</div></div>
                    <div>{{ $statuses[$order->status] ?? $order->status }}</div>
                    <div>{{ number_format((float) $order->total, 0, ',', ' ') }} ₽</div>
                    <a href="{{ route('admin.orders.show', $order) }}" class="font-bold text-emerald-700">Открыть</a>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $orders->links() }}</div>
    </section>
@endsection
