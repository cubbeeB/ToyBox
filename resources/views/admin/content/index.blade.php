@extends('layouts.app')

@section('title', 'Контент - админка ToyBox')

@section('content')
    <section class="mx-auto max-w-7xl px-4 py-10">
        <h1 class="text-4xl font-black">Контент, акции и отзывы</h1>
        <div class="mt-8 grid gap-8 lg:grid-cols-3">
            <form method="POST" action="{{ route('admin.content.articles.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @csrf
                <h2 class="text-2xl font-black">Новая статья</h2>
                <div class="mt-4 grid gap-3">
                    <input name="title" placeholder="Заголовок" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="excerpt" placeholder="Краткое описание" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="tags" placeholder="теги через запятую" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <textarea name="body" rows="5" placeholder="Текст" class="rounded-2xl border border-amber-200 px-4 py-2"></textarea>
                    <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Опубликовать</button>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.content.promotions.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @csrf
                <h2 class="text-2xl font-black">Новая акция</h2>
                <div class="mt-4 grid gap-3">
                    <input name="title" placeholder="Название" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="discount_label" placeholder="до -30%" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <textarea name="description" rows="5" placeholder="Описание" class="rounded-2xl border border-amber-200 px-4 py-2"></textarea>
                    <button class="rounded-full bg-rose-500 px-5 py-3 font-bold text-white">Создать</button>
                </div>
            </form>
            <form method="POST" action="{{ route('admin.content.promo-codes.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
                @csrf
                <h2 class="text-2xl font-black">Промокод</h2>
                <div class="mt-4 grid gap-3">
                    <input name="code" placeholder="TOYBOX10" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <select name="type" class="rounded-2xl border border-amber-200 px-4 py-2"><option value="percent">Процент</option><option value="fixed">Сумма</option></select>
                    <input name="value" placeholder="Значение" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="min_order_amount" placeholder="Мин. сумма заказа" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <input name="expires_at" type="date" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <button class="rounded-full bg-amber-300 px-5 py-3 font-bold text-slate-900">Создать</button>
                </div>
            </form>
        </div>

        <div class="mt-8 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <h2 class="text-2xl font-black">Модерация отзывов</h2>
            <div class="mt-4 space-y-3">
                @foreach($reviews as $review)
                    <div class="grid gap-3 rounded-2xl bg-amber-50 p-4 md:grid-cols-[1fr_auto] md:items-center">
                        <div><b>{{ $review->author_name }} · {{ $review->status }}</b><p class="text-sm text-slate-600">{{ $review->body }}</p></div>
                        <div class="flex gap-2">
                            @if($review->status !== 'approved')
                                <form method="POST" action="{{ route('admin.content.reviews.approve', $review) }}">@csrf @method('PATCH')<button class="font-bold text-emerald-700">Одобрить</button></form>
                            @endif
                            <form method="POST" action="{{ route('admin.content.reviews.destroy', $review) }}">@csrf @method('DELETE')<button class="font-bold text-rose-600">Удалить</button></form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
