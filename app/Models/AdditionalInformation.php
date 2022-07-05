<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdditionalInformation extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value', 'product_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $casts = ['product_id' => 'integer'];

    /**
     * Get the product that owns the AdditionalInformation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
