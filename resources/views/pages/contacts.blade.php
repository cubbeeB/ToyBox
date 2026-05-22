@extends('layouts.app')

@section('title', 'Контакты ToyBox')

@section('content')
    <section class="mx-auto grid max-w-7xl gap-8 px-4 py-10 lg:grid-cols-[.9fr_1.1fr]">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            <p class="font-bold text-emerald-700">Контакты</p>
            <h1 class="mt-2 text-4xl font-black">Мы рядом</h1>
            <div class="mt-6 space-y-3 text-slate-700">
                <p><b>Адрес:</b> {{ $settings['address'] ?? 'Москва' }}</p>
                <p><b>Телефон:</b> {{ $settings['display_phone'] ?? '+7 900 555-35-35' }}</p>
                <p><b>Email:</b> {{ $settings['email'] ?? 'hello@toybox.test' }}</p>
                <p><b>График:</b> {{ $settings['work_hours'] ?? 'Пн-Вс 10:00-21:00' }}</p>
            </div>
            <div class="mt-6 overflow-hidden rounded-3xl bg-amber-100">
                <iframe title="Карта ToyBox" src="https://maps.google.com/maps?q=Moscow&t=&z=11&ie=UTF8&iwloc=&output=embed" class="h-72 w-full border-0"></iframe>
            </div>
        </div>
        <form method="POST" action="{{ route('contacts.send') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            <h2 class="text-2xl font-black">Форма обратной связи</h2>
            <div class="mt-4 grid gap-3">
                <input name="name" value="{{ old('name') }}" placeholder="Ваше имя" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="email" value="{{ old('email') }}" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                <textarea name="message" rows="6" placeholder="Сообщение" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('message') }}</textarea>
                <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Отправить</button>
            </div>
        </form>
    </section>
@endsection
