<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shipping extends Model
{
    use HasFactory;

    protected $table = 'shipping';

    protected $fillable = [
        'address_line1',
        'address_line2',
        'city',
        'province',
        'postal_code',
        'courier',
        'cost',
        'eta_estimation',
    ];

    protected $casts = [
        'cost' => 'decimal:2',
    ];

    /**
     * Get all orders using this shipping
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
