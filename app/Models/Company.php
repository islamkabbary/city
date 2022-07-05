<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Company extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['owner_name', 'whats', 'commission', 'slog'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts = ['owner_name' => 'integer'];

    /**
     * Get the user that owns the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_name', 'id');
    }

    /**
     * Get all of the products for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all of the DeliveryValues for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function DeliveryValues(): HasMany
    {
        return $this->hasMany(DeliveryValue::class);
    }

    /**
     * Get all of the PromoCodes for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function PromoCodes(): HasMany
    {
        return $this->hasMany(PromoCode::class);
    }

    /**
     * Get all of the AddedTaxes for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function AddedTaxes(): HasMany
    {
        return $this->hasMany(AddedTax::class);
    }

    /**
     * The categories that belong to the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'company_has_category', 'company_id', 'category_id');
    }
}
