@extends('layouts.app')

@section('title', 'Настройки магазина - ToyBox')

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-10">
        <h1 class="text-4xl font-black">Настройки магазина</h1>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-8 grid gap-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            @method('PATCH')
            <input name="store_name" value="{{ old('store_name', $settings['store_name'] ?? 'ToyBox') }}" placeholder="Название" class="rounded-2xl border border-amber-200 px-4 py-2">
            <input name="manager_phone" value="{{ old('manager_phone', $settings['manager_phone'] ?? '+79005553535') }}" placeholder="Телефон для кнопки Позвонить" class="rounded-2xl border border-amber-200 px-4 py-2">
            <input name="display_phone" value="{{ old('display_phone', $settings['display_phone'] ?? '+7 900 555-35-35') }}" placeholder="Телефон на сайте" class="rounded-2xl border border-amber-200 px-4 py-2">
            <input name="email" value="{{ old('email', $settings['email'] ?? 'hello@toybox.test') }}" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
            <input name="address" value="{{ old('address', $settings['address'] ?? '') }}" placeholder="Адрес" class="rounded-2xl border border-amber-200 px-4 py-2">
            <input name="work_hours" value="{{ old('work_hours', $settings['work_hours'] ?? '') }}" placeholder="График" class="rounded-2xl border border-amber-200 px-4 py-2">
            <textarea name="mission" rows="5" placeholder="Миссия магазина" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('mission', $settings['mission'] ?? '') }}</textarea>
            <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Сохранить</button>
        </form>
    </section>
@endsection
