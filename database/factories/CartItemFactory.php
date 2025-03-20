<?php

namespace Database\Factories;

use App\Models\CartItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class CartItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Ensure there is at least one Cart and Product to assign
        $cart = Cart::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();

        // If no carts or products exist, we can create one or handle the case accordingly
        if (!$cart) {
            $cart = Cart::factory()->create(); // Create a cart if none exist
        }

        if (!$product) {
            $product = Product::factory()->create(); // Create a product if none exist
        }

        return [
            'cart_id' => $cart->id, 
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 5), // Random quantity between 1 and 5
            'price_at_time_of_addition' => $this->faker->randomFloat(2, 10, 500), 
        ];
    }
}
