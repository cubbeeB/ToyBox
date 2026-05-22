@php
    $storeName = \App\Models\StoreSetting::value('store_name', config('app.name', 'ToyBox'));
    $managerPhone = \App\Models\StoreSetting::value('manager_phone', '+79005553535');
    $displayPhone = \App\Models\StoreSetting::value('display_phone', '+7 900 555-35-35');
    $cartCount = collect(session('cart', []))->sum();
@endphp
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'ToyBox - интернет-магазин безопасных игрушек, подарков и развивающих товаров для детей.')">
    <title>@yield('title', $storeName.' - магазин игрушек')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('schema')
</head>
<body class="flex min-h-screen flex-col bg-[#fbf7ef] text-slate-800 antialiased">
    <header class="sticky top-0 z-40 border-b border-amber-100 bg-white/90 backdrop-blur">
        <div class="mx-auto flex max-w-7xl flex-col gap-4 px-4 py-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center justify-between gap-4">
                <a href="{{ route('home') }}" class="text-2xl font-black tracking-tight text-emerald-700">ToyBox</a>
                <a href="tel:{{ $managerPhone }}" class="rounded-full bg-rose-500 px-4 py-2 text-sm font-bold text-white shadow-sm lg:hidden">Позвонить</a>
            </div>
            <nav class="flex flex-wrap items-center gap-3 text-sm font-semibold text-slate-700">
                <a class="hover:text-emerald-700" href="{{ route('about') }}">О нас</a>
                <a class="hover:text-emerald-700" href="{{ route('catalog.index') }}">Каталог</a>
                <a class="hover:text-emerald-700" href="{{ route('articles.index') }}">Полезные статьи</a>
                <a class="hover:text-emerald-700" href="{{ route('promotions.index') }}">Акции</a>
                <a class="hover:text-emerald-700" href="{{ route('reviews.index') }}">Отзывы</a>
                <a class="hover:text-emerald-700" href="{{ route('contacts') }}">Контакты</a>
                <a class="rounded-full bg-amber-300 px-4 py-2 text-slate-900" href="{{ route('cart.index') }}">Корзина ({{ $cartCount }})</a>
                @auth
                    <a class="hover:text-emerald-700" href="{{ route('account.index') }}">Кабинет</a>
                    @if(auth()->user()->is_admin)
                        <a class="hover:text-emerald-700" href="{{ route('admin.dashboard') }}">Админка</a>
                    @endif
                @else
                    <a class="hover:text-emerald-700" href="{{ route('login') }}">Войти</a>
                @endauth
            </nav>
            <form action="{{ route('catalog.index') }}" class="flex min-w-64 flex-1 gap-2 lg:max-w-sm">
                <input name="q" value="{{ request('q') }}" placeholder="Поиск игрушек..." class="w-full rounded-full border border-amber-200 bg-white px-4 py-2 outline-none ring-emerald-200 focus:ring">
                <button class="rounded-full bg-emerald-600 px-4 py-2 font-bold text-white">Найти</button>
            </form>
            <a href="tel:{{ $managerPhone }}" class="hidden rounded-full bg-rose-500 px-5 py-2 font-bold text-white shadow-sm lg:inline-flex">Позвонить {{ $displayPhone }}</a>
        </div>
    </header>

    <main class="flex-1">
        @if (session('status'))
            <div class="mx-auto mt-4 max-w-7xl rounded-2xl bg-emerald-100 px-4 py-3 text-emerald-900">{{ session('status') }}</div>
        @endif

        @if ($errors->any())
            <div class="mx-auto mt-4 max-w-7xl rounded-2xl bg-rose-100 px-4 py-3 text-rose-900">
                {{ $errors->first() }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="mt-auto border-t border-amber-100 bg-white">
        <div class="mx-auto grid max-w-7xl gap-6 px-4 py-10 md:grid-cols-2">
            <div>
                <div class="text-2xl font-black text-emerald-700">ToyBox</div>
                <p class="mt-2 text-sm text-slate-600">Игрушки, которые радуют детей и спокойно проходят родительскую проверку.</p>
            </div>
            <div class="text-sm text-slate-600">
                <div class="font-bold text-slate-900">Контакты</div>
                <p>{{ \App\Models\StoreSetting::value('address', 'Москва') }}</p>
                <p>{{ \App\Models\StoreSetting::value('work_hours', 'Ежедневно') }}</p>
                <p>{{ \App\Models\StoreSetting::value('email', 'hello@toybox.test') }}</p>
            </div>
        </div>
    </footer>

    <a href="tel:{{ $managerPhone }}" class="fixed bottom-5 right-5 rounded-full bg-rose-500 px-5 py-3 font-bold text-white shadow-xl">Позвонить</a>
</body>
</html>
