<?php

namespace App\Models;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model


{

    use HasFactory;

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

   public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id', 'id');
}

public function variants()
{
    return $this->hasMany(ProductVariant::class, 'product_id', 'id');
}

protected static function booted()
{
    static::deleting(function ($product) {
        $product->variants()->delete();
        $product->images()->delete();
    });
}

}
