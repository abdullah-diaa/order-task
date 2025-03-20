<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\CartItem;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        // Attempt to use an existing CartItem; if none exists, create one.
        $cartItem = CartItem::inRandomOrder()->first() ?: CartItem::factory()->create();
        
        // the samething for Cart
        $cart = $cartItem->cart ?: Cart::factory()->create();
        
        // the samething for User
        $user = $cart->user ?: User::factory()->create();
        
        $product = $cartItem->product ?: (Product::inRandomOrder()->first() ?: Product::factory()->create());

        $quantity = $this->faker->numberBetween(1, 5);
        $priceAtAddition = $this->faker->randomFloat(2, 10, 500);
        $totalPrice = $priceAtAddition * $quantity;

        return [
            'cart_item_id'           => $cartItem->id,
            'cart_id'                => $cart->id,
            'user_id'                => $user->id,
            'product_id'             => $product->id,
            'quantity'               => $quantity,
            'price_at_time_of_addition' => $priceAtAddition,
            'total_price'            => $totalPrice,
            'status'                 => $this->faker->randomElement(['pending', 'completed', 'canceled']),
        ];
    }
}
