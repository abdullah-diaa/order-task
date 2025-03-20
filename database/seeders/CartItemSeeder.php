<?php
namespace Database\Seeders;

use App\Models\CartItem;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Attach 3-5 cart items to each cart
        $carts = \App\Models\Cart::all();
        
        foreach ($carts as $cart) {
            CartItem::factory()->count(rand(3, 5)) 
                ->create(['cart_id' => $cart->id]);
        }
    }
}
