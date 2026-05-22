@extends('layouts.app')

@section('title', 'Товары - админка ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-4xl font-black">Товары</h1>
            <a href="{{ route('admin.products.create') }}" class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Добавить товар</a>
        </div>
        <div class="mt-8 overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-amber-100">
            @foreach($products as $product)
                <div class="grid gap-3 border-b border-amber-100 p-4 md:grid-cols-[1fr_160px_160px_auto] md:items-center">
                    <div><b>{{ $product->name }}</b><div class="text-sm text-slate-500">{{ $product->category?->name }} · {{ $product->brand?->name }}</div></div>
                    <div>{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</div>
                    <div>{{ $product->stock }} шт.</div>
                    <div class="flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="font-bold text-emerald-700">Изменить</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                            @csrf
                            @method('DELETE')
                            <button class="font-bold text-rose-600">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    </section>
@endsection
