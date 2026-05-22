@extends('layouts.app')

@section('title', ($product->exists ? 'Редактирование товара' : 'Новый товар').' - ToyBox')

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-10">
        <h1 class="text-4xl font-black">{{ $product->exists ? 'Редактирование товара' : 'Новый товар' }}</h1>
        <form method="POST" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="mt-8 grid gap-4 rounded-3xl bg-white p-6 shadow-sm ring-1 ring-amber-100">
            @csrf
            @if($product->exists)
                @method('PUT')
            @endif
            <div class="grid gap-4 md:grid-cols-2">
                <input name="name" value="{{ old('name', $product->name) }}" placeholder="Название" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="slug" value="{{ old('slug', $product->slug) }}" placeholder="URL slug" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="sku" value="{{ old('sku', $product->sku) }}" placeholder="Артикул" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="image_url" value="{{ old('image_url', $product->image_url) }}" placeholder="URL изображения" class="rounded-2xl border border-amber-200 px-4 py-2">
                <select name="category_id" class="rounded-2xl border border-amber-200 px-4 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $product->category_id) === $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="brand_id" class="rounded-2xl border border-amber-200 px-4 py-2">
                    <option value="">Без бренда</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" @selected((int) old('brand_id', $product->brand_id) === $brand->id)>{{ $brand->name }}</option>
                    @endforeach
                </select>
                <input name="price" value="{{ old('price', $product->price) }}" placeholder="Цена" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="old_price" value="{{ old('old_price', $product->old_price) }}" placeholder="Старая цена" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="stock" value="{{ old('stock', $product->stock ?? 0) }}" placeholder="Остаток" class="rounded-2xl border border-amber-200 px-4 py-2">
                <input name="popularity" value="{{ old('popularity', $product->popularity ?? 0) }}" placeholder="Популярность" class="rounded-2xl border border-amber-200 px-4 py-2">
                <select name="age_group" class="rounded-2xl border border-amber-200 px-4 py-2">
                    @foreach($ageGroups as $age)
                        <option value="{{ $age }}" @selected(old('age_group', $product->age_group) === $age)>{{ $age }}</option>
                    @endforeach
                </select>
                <select name="gender" class="rounded-2xl border border-amber-200 px-4 py-2">
                    @foreach($genders as $gender)
                        <option value="{{ $gender }}" @selected(old('gender', $product->gender ?? 'unisex') === $gender)>{{ $gender }}</option>
                    @endforeach
                </select>
            </div>
            <textarea name="description" rows="5" placeholder="Описание" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('description', $product->description) }}</textarea>
            <textarea name="features_text" rows="4" placeholder="Особенности, каждая с новой строки" class="rounded-2xl border border-amber-200 px-4 py-2">{{ old('features_text', implode("\n", $product->features ?? [])) }}</textarea>
            <div class="flex flex-wrap gap-4 text-sm font-semibold">
                <label><input type="checkbox" name="is_new" value="1" @checked(old('is_new', $product->is_new))> Новинка</label>
                <label><input type="checkbox" name="is_hit" value="1" @checked(old('is_hit', $product->is_hit))> Хит продаж</label>
                <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))> Активен</label>
            </div>
            <button class="rounded-full bg-emerald-600 px-5 py-3 font-bold text-white">Сохранить</button>
        </form>
    </section>
@endsection
