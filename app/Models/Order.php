<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
     use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone1',
        'customer_phone2',
        'address',
        'governorate',
        'product_id',
        'quantity',
        'total_price',
        'status',
    ];
 
 //relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
