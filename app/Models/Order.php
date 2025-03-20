<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_item_id',
        'cart_id',
        'user_id',
        'product_id',
        'quantity',
        'price_at_time_of_addition',
        'total_price',
        'status',
    ];


    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }


public function cartItem()
{
    return $this->belongsTo(CartItem::class);
}



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    
}
