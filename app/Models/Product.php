<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'price', 'image', 'description', 'status', 'brand_id', 'category_id', 'company_id', 'added_tax_id'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'price' => 'float',
        'brand_id' => 'integer',
        'category_id' => 'integer',
        'company_id' => 'integer',
        'added_tax_id' => 'integer',
    ];

    /**
     * Get the category that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the company that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * The carts that belong to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Cart::class, 'product_id', 'user_id')->wherePivot('qty');
    }

    /**
     * Get all of the information for the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function informations(): HasMany
    {
        return $this->hasMany(AdditionalInformation::class);
    }
}
