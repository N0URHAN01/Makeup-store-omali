<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
     use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone1',
        'customer_phone2',
        'notes',
        'address',
        'governorate_id',
        'shipping_cost',
        'total_price',
        'status',
    ];
 


protected $casts = [
        'shipping_cost' => 'decimal:2',
        'total_price' => 'decimal:2',
    ];


    // Every order belongs to a governorate
    public function governorate()
    {
        return $this->belongsTo(Governorate::class);
    }

    /**
     * Relationship: Order has many items
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }


    /**
     * Calculate the subtotal (sum of item totals)
     */
    public function getSubtotalAttribute()
    {
        return $this->items->sum('total');
    }
    /**
     * Calculate the final total (subtotal + shipping cost)
     */

       public function getGrandTotalAttribute()
    {
        return $this->subtotal + $this->shipping_cost;
    }


      /**
     * Generate a unique code for the order
     */
    public static function generateOrderCode()
    {
        return 'ORD-' . strtoupper(uniqid());
    }
    
 //relationship with Product
    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
