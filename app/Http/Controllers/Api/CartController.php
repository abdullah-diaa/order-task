<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user = Auth::user();
    
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);
    
        $product = Product::findOrFail($request->product_id);
    
        // here is Checking if there is enough stock for the product
        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock available'], 400);
        }
    
        $cart = Cart::where('user_id', $user->id)->first();
        if (!$cart) {
            $cart = Cart::create(['user_id' => $user->id]); // Create it only if it doesn’t exist
        }
    
        //  and here is Checking if the product already exists in the cart and if the status is 'active'
        $cartItem = $cart->cartItems()->where('product_id', $product->id)->first();
    
        if ($cartItem) {
            if ($cartItem->status === 'active') {
                // Update the quantity if the product is already in the cart and is 'active'
                $cartItem->update(['quantity' => $cartItem->quantity + $request->quantity]);
            } else {
                // Create a new cart item if the status is not 'active' (e.g., 'ordered' or 'removed')
                $cart->cartItems()->create([
                    'product_id' => $product->id,
                    'quantity' => $request->quantity,
                    'price_at_time_of_addition' => $product->price,
                    'status' => 'active', // Mark as active by default
                ]);
            }
        } else {
            // Create a new cart item if it doesn't exist in the cart
            $cart->cartItems()->create([
                'product_id' => $product->id,
                'quantity' => $request->quantity,
                'price_at_time_of_addition' => $product->price,
                'status' => 'active', 
            ]);
        }
    
        return response()->json(['message' => 'Item added to cart successfully']);
    }
    






public function removeFromCart($cartItemId)
{
    $cartItem = CartItem::whereHas('cart', function ($query) {
        $query->where('user_id', Auth::id());
    })->find($cartItemId);

    if (!$cartItem) {
        return response()->json(['message' => 'Cart item not found or not authorized to delete this item.'], 404);
    }

    $cartItem->delete();
    
    return response()->json(['message' => 'Cart item deleted successfully.']);
}



    
}
