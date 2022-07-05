<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id', 'product_id', 'qty', 'price', 'total'
    ];
}
