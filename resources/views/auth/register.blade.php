@extends('layouts.app')

@section('title', 'Регистрация - ToyBox')

@section('content')
    <section class="mx-auto max-w-md px-4 py-10">
        <form method="POST" action="{{ route('register.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            <h1 class="text-3xl font-black">Регистрация</h1>
            <div class="mt-5 grid gap-3">
                <input name="name" value="{{ old('name') }}" placeholder="Имя" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="email" value="{{ old('email') }}" type="email" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="phone" value="{{ old('phone') }}" placeholder="Телефон" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="password" type="password" placeholder="Пароль" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="password_confirmation" type="password" placeholder="Повторите пароль" class="rounded-2xl border border-amber-200 px-4 py-2">
                <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Зарегистрироваться</button>
                <a href="{{ route('login') }}" class="text-sm font-bold text-emerald-700">Уже есть аккаунт</a>
            </div>
        </form>
    </section>
@endsection
