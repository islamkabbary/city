<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'code', 'discount', 'company_id', 'start_date', 'end_date', 'type', 'max_discount', 'limit_for_user', 'limit_use'];
    protected $casts = [
        'discount' => 'float',
        'company_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'max_discount' => 'float',
        'limit_for_user' => 'integer',
        'limit_use' => 'integer',
    ];

    /**
     * Get all of the orders for the PromoCode
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
