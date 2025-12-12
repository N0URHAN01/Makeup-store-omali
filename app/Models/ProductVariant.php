<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
     use HasFactory;

    protected $fillable = [
        'product_id',
        'color_name',
        'color_code',
        'image',
        'stock',
        'price_difference',
    ];


     public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

    
}
