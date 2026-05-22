@extends('layouts.app')

@section('title', 'Акции - ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black text-slate-950">Акции и спецпредложения</h1>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            @foreach($promotions as $promotion)
                <article class="rounded-3xl bg-rose-500 p-6 text-white shadow-sm">
                    <div class="text-sm font-bold uppercase">{{ $promotion->discount_label }}</div>
                    <h2 class="mt-3 text-2xl font-black">{{ $promotion->title }}</h2>
                    <p class="mt-3 text-rose-50">{{ $promotion->description }}</p>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $promotions->links() }}</div>
    </section>
@endsection
