<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'user_addresses_id', 'status', 'added_tax_id', 'delivery_value_id', 'company_id', 'promo_code_id',
        'sub_total', 'total'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'user_addresses_id' => 'integer',
        'added_tax_id' => 'integer',
        'delivery_value_id' => 'integer',
        'company_id' => 'integer',
        'promo_code_id' => 'integer',
        'sub_total' => 'float',
        'total' => 'float',
    ];

    /**
     * Get all of the orderDetails for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function orderDetails(): HasMany
    {
        return $this->hasMany(orderDetails::class);
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function UserAddresses(): BelongsTo
    {
        return $this->belongsTo(UserAddress::class);
    }

    /**
     * Get the rate that owns the Order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rate(): HasOne
    {
        return $this->hasOne(Rate::class);
    }
}
