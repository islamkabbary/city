<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyHasCategory extends Model
{
    use HasFactory;
    protected $fillable = ['company_id', 'category_id'];
    protected $hidden = ['created_at', 'updated_at'];
    protected $table = 'company_has_category';
}
