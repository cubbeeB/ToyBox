@extends('layouts.app')

@section('title', $article->title.' - ToyBox')
@section('meta_description', $article->excerpt)

@section('content')
    <article class="mx-auto max-w-3xl px-4 py-10">
        <a href="{{ route('articles.index') }}" class="font-bold text-emerald-700">← Все статьи</a>
        <h1 class="mt-4 text-4xl font-black text-slate-950">{{ $article->title }}</h1>
        <p class="mt-4 text-lg text-slate-600">{{ $article->excerpt }}</p>
        <div class="mt-8 rounded-3xl bg-white p-8 text-lg leading-8 text-slate-700 shadow-sm ring-1 ring-amber-100">
            {!! nl2br(e($article->body)) !!}
        </div>
    </article>
@endsection
