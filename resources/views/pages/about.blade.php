@extends('layouts.app')

@section('title', 'О ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <div class="rounded-[2rem] bg-white p-8 shadow-sm ring-1 ring-amber-100">
            <p class="font-bold text-emerald-700">О нас</p>
            <h1 class="mt-2 text-4xl font-black text-slate-950">ToyBox выбирает игрушки с заботой о детях и спокойствии родителей.</h1>
            <p class="mt-5 max-w-3xl text-lg text-slate-600">{{ $mission }}</p>
        </div>
        <div class="mt-8 grid gap-6 md:grid-cols-3">
            <article class="rounded-3xl bg-emerald-100 p-6"><h2 class="text-xl font-black">Миссия</h2><p class="mt-2 text-slate-700">Подбирать игрушки, которые развивают, вдохновляют и соответствуют возрасту ребёнка.</p></article>
            <article class="rounded-3xl bg-amber-100 p-6"><h2 class="text-xl font-black">Качество</h2><p class="mt-2 text-slate-700">Работаем с поставщиками, проверяем сертификаты и безопасность материалов.</p></article>
            <article class="rounded-3xl bg-rose-100 p-6"><h2 class="text-xl font-black">Команда</h2><p class="mt-2 text-slate-700">Менеджеры помогают подобрать подарок, собрать заказ и быстро решить вопросы.</p></article>
        </div>
        <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <h2 class="text-2xl font-black">История и преимущества</h2>
            <p class="mt-3 text-slate-600">ToyBox вырос из небольшого семейного магазина. Сегодня мы объединяем витрину с фильтрами, полезные статьи, отзывы покупателей и понятную поддержку менеджера.</p>
        </div>
    </section>
@endsection
