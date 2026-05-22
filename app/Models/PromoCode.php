<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PromoCode extends Model
{
    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'decimal:2',
            'min_order_amount' => 'decimal:2',
            'is_active' => 'boolean',
            'starts_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }

    public function scopeAvailable(Builder $query): Builder
    {
        return $query
            ->where('is_active', true)
            ->where(fn (Builder $query) => $query->whereNull('starts_at')->orWhere('starts_at', '<=', now()))
            ->where(fn (Builder $query) => $query->whereNull('expires_at')->orWhere('expires_at', '>=', now()))
            ->where(fn (Builder $query) => $query->whereNull('usage_limit')->orWhereColumn('used_count', '<', 'usage_limit'));
    }

    public function discountFor(float $subtotal): float
    {
        if ($this->min_order_amount !== null && $subtotal < (float) $this->min_order_amount) {
            return 0;
        }

        $discount = $this->type === 'fixed'
            ? (float) $this->value
            : $subtotal * ((float) $this->value / 100);

        return min($discount, $subtotal);
    }
}
