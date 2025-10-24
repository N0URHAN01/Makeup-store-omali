<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
       'name',
        'product_code',
        'description',
        'price',
        'discount_percentage',
        'image',
        'stock',
        'category_id',
    ];

    // calculate discounted price
 public function getDiscountedPriceAttribute()
    {
        return $this->price - ($this->price * $this->discount_percentage / 100);
    }

    // relationship with Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

   //relationship with Order
   public function orders()
   {
       return $this->hasMany(Order::class);
   }

}
