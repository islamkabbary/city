<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'city_id', 'street', 'building_type', 'district', 'street', 'building_number', 'apartment_number', 'floor', 'location_details'
    ];
    protected $casts = [
        'user_id' => 'integer',
        'city_id' => 'integer',
    ];

    /**
     * Get the user that owns the UserAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all of the orders for the UserAddress
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
