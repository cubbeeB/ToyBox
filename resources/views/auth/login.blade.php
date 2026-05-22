@extends('layouts.app')

@section('title', 'Вход - ToyBox')

@section('content')
    <section class="mx-auto max-w-md px-4 py-10">
        <form method="POST" action="{{ route('login.store') }}" class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            <h1 class="text-3xl font-black">Вход</h1>
            <div class="mt-5 grid gap-3">
                <input name="email" value="{{ old('email') }}" type="email" placeholder="Email" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="password" type="password" placeholder="Пароль" class="rounded-2xl border border-amber-200 px-4 py-2">
                <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Запомнить меня</label>
                <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Войти</button>
                <a href="{{ route('register') }}" class="text-sm font-bold text-emerald-700">Создать аккаунт</a>
            </div>
        </form>
    </section>
@endsection
