<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'total_price',
        'shipping_id',
        'payment_method',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
    ];

    /**
     * Get the user that owns the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the shipping information
     */
    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class);
    }

    /**
     * Get all items in this order
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the payment for this order
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }
}
