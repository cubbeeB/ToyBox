<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    public const AGE_GROUPS = ['0-1', '1-3', '3-6', '6-12', '12+'];

    public const GENDERS = ['boys', 'girls', 'unisex'];

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'description',
        'price',
        'old_price',
        'stock',
        'age_group',
        'gender',
        'image_url',
        'features',
        'rating',
        'reviews_count',
        'popularity',
        'is_new',
        'is_hit',
        'is_active',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'rating' => 'decimal:1',
            'is_new' => 'boolean',
            'is_hit' => 'boolean',
            'is_active' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)->whereNotNull('published_at');
    }

    public function hasDiscount(): bool
    {
        return $this->old_price !== null && (float) $this->old_price > (float) $this->price;
    }
}
