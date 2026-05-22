<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    public const STATUSES = [
        'new' => 'Новый',
        'processing' => 'В обработке',
        'shipped' => 'Отправлен',
        'completed' => 'Выполнен',
        'cancelled' => 'Отменён',
    ];

    protected $fillable = [
        'user_id',
        'number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'delivery_address',
        'status',
        'subtotal',
        'delivery_cost',
        'discount_amount',
        'total',
        'promo_code',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'delivery_cost' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
