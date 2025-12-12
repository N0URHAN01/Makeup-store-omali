<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;



class Governorate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shipping_cost',
    ];

    
    
protected $casts = [
        'shipping_cost' => 'decimal:2',
    ];
    


// relationship: Governorate has many Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


}
