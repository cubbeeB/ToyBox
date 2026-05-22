@extends('layouts.app')

@section('title', 'Полезные статьи - ToyBox')
@section('meta_description', 'Советы по выбору игрушек, развитию через игру и обзоры новинок от ToyBox.')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black text-slate-950">Полезные статьи</h1>
        <p class="mt-3 max-w-2xl text-slate-600">Подборки и советы для родителей: как выбрать игрушку по возрасту, интересам и пользе для развития.</p>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($articles as $article)
                <article class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-amber-100 transition hover:-translate-y-1 hover:shadow-lg">
                    <a href="{{ route('articles.show', $article) }}" class="block">
                        <div class="aspect-[16/10] overflow-hidden bg-amber-100">
                            <img
                                src="{{ $article->image_url ?: 'https://images.unsplash.com/photo-1503454537845-7e8b5b2374ea?auto=format&fit=crop&w=900&q=80' }}"
                                alt="{{ $article->title }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                loading="lazy"
                            >
                        </div>
                    </a>
                    <div class="p-5">
                        @if($article->tags)
                            <div class="flex flex-wrap gap-2">
                                @foreach(array_slice($article->tags, 0, 2) as $tag)
                                    <span class="rounded-full bg-emerald-50 px-2 py-1 text-xs font-bold text-emerald-700">{{ $tag }}</span>
                                @endforeach
                            </div>
                        @endif
                        <h2 class="mt-3 text-lg font-black text-slate-900">
                            <a href="{{ route('articles.show', $article) }}" class="hover:text-emerald-700">{{ $article->title }}</a>
                        </h2>
                        <p class="mt-2 line-clamp-3 text-sm text-slate-600">{{ $article->excerpt }}</p>
                        <a href="{{ route('articles.show', $article) }}" class="mt-4 inline-flex font-bold text-emerald-700 hover:text-emerald-800">Читать →</a>
                    </div>
                </article>
            @endforeach
        </div>
        <div class="mt-8">{{ $articles->links() }}</div>
    </section>
@endsection
