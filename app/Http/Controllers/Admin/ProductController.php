<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::query()->with(['category', 'brand'])->latest()->paginate(20),
        ]);
    }

    public function create()
    {
        return view('admin.products.form', $this->formData(new Product));
    }

    public function store(Request $request)
    {
        Product::query()->create($this->validatedData($request));

        return redirect()->route('admin.products.index')->with('status', 'Товар добавлен.');
    }

    public function show(Product $product)
    {
        return redirect()->route('products.show', $product);
    }

    public function edit(Product $product)
    {
        return view('admin.products.form', $this->formData($product));
    }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validatedData($request, $product));

        return redirect()->route('admin.products.index')->with('status', 'Товар обновлён.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('status', 'Товар удалён.');
    }

    private function formData(Product $product): array
    {
        return [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
            'brands' => Brand::query()->orderBy('name')->get(),
            'ageGroups' => Product::AGE_GROUPS,
            'genders' => Product::GENDERS,
        ];
    }

    private function validatedData(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product)],
            'sku' => ['required', 'string', 'max:100', Rule::unique('products', 'sku')->ignore($product)],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'age_group' => ['required', Rule::in(Product::AGE_GROUPS)],
            'gender' => ['required', Rule::in(Product::GENDERS)],
            'image_url' => ['nullable', 'url', 'max:1000'],
            'features_text' => ['nullable', 'string'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'popularity' => ['nullable', 'integer', 'min:0'],
            'is_new' => ['nullable', 'boolean'],
            'is_hit' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        $data['features'] = collect(preg_split('/\r\n|\r|\n/', $data['features_text'] ?? ''))->filter()->values()->all();
        $data['is_new'] = $request->boolean('is_new');
        $data['is_hit'] = $request->boolean('is_hit');
        $data['is_active'] = $request->boolean('is_active');
        $data['published_at'] = $data['is_active'] ? now() : null;
        unset($data['features_text']);

        return $data;
    }
}
