@php
    $customImageUrl = $product->image_url;
    $hasReliableCustomImage = filled($customImageUrl) && ! str($customImageUrl)->contains('images.unsplash.com');
    $themedImageUrl = match ($product->category?->slug) {
        'soft-toys' => asset('images/products/soft-toys.svg'),
        'constructors' => asset('images/products/constructors.svg'),
        'board-games' => asset('images/products/board-games.svg'),
        'educational-toys' => asset('images/products/educational-toys.svg'),
        default => asset('images/products/default-toys.svg'),
    };
    $imageUrl = $hasReliableCustomImage ? $customImageUrl : $themedImageUrl;
@endphp

<article class="group overflow-hidden rounded-3xl bg-white shadow-sm ring-1 ring-amber-100 transition hover:-translate-y-1 hover:shadow-lg">
    <a href="{{ route('products.show', $product) }}">
        <div class="aspect-[4/3] overflow-hidden bg-amber-100">
            <img
                src="{{ $imageUrl }}"
                alt="{{ $product->name }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                loading="lazy"
            >
        </div>
    </a>
    <div class="space-y-3 p-5">
        <div class="flex items-start justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-wide text-emerald-700">{{ $product->category?->name }}</p>
                <h3 class="mt-1 text-lg font-black text-slate-900">
                    <a href="{{ route('products.show', $product) }}">{{ $product->name }}</a>
                </h3>
            </div>
            <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-bold">★ {{ $product->rating }}</span>
        </div>
        <p class="line-clamp-2 text-sm text-slate-600">{{ $product->description }}</p>
        <div class="flex items-end justify-between gap-3">
            <div>
                <div class="text-xl font-black text-emerald-700">{{ number_format((float) $product->price, 0, ',', ' ') }} ₽</div>
                @if($product->hasDiscount())
                    <div class="text-sm text-slate-400 line-through">{{ number_format((float) $product->old_price, 0, ',', ' ') }} ₽</div>
                @endif
            </div>
            <form method="POST" action="{{ route('cart.add', $product) }}">
                @csrf
                <button class="rounded-full bg-rose-500 px-4 py-2 text-sm font-bold text-white">В корзину</button>
            </form>
        </div>
        @auth
            <form method="POST" action="{{ route('account.favorites.toggle', $product) }}">
                @csrf
                <button class="text-sm font-semibold text-emerald-700">Добавить в избранное</button>
            </form>
        @endauth
    </div>
</article>
