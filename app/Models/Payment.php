<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'paid_at',
        'status',
        'transaction_id',
        'payment_type',
        'raw_response',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the order that owns the payment
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
