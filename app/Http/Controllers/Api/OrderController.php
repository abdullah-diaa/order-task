<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\CartItem;

use Illuminate\Support\Facades\Auth;
class OrderController extends Controller
{

    public function getUserOrders()
    {
        $userId = Auth::id();
    
        $orders = Order::where('user_id', $userId)
            ->with(['product', 'cartItem'])
            ->get();
    
        // If the user has no orders, return a message
        if ($orders->isEmpty()) {
            return response()->json(['message' => 'No orders found.'], 404);
        }
    
        return response()->json(['orders' => $orders]);
    }
    





    public function checkout(Request $request)
    {
        $userId = Auth::id();  
    
        // Get all active cart items for the user
        $cartItems = CartItem::whereHas('cart', function ($query) use ($userId) {
            $query->where('user_id', $userId)->where('status', 'active');
        })->where('status', 'active')->get(); // Only get cart items that are 'active'
    
        // this is just cheking If no active cart items found, return an error
        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty or not active'], 400);
        }
    
        // Create orders for each cart item and reduce stock
        foreach ($cartItems as $cartItem) {
            // Check if there is enough stock for the product (stock for product)
            $product = $cartItem->product;
            if ($product->stock < $cartItem->quantity) {
                return response()->json(['message' => 'Not enough stock for product: ' . $product->name], 400);
            }
    
            // Reduce the stock of the product
            $product->stock -= $cartItem->quantity;
            $product->save();
    
            Order::create([
                'cart_item_id' => $cartItem->id,
                'cart_id' => $cartItem->cart_id,
                'user_id' => $userId,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price_at_time_of_addition' => $cartItem->price_at_time_of_addition,
                'total_price' => $cartItem->quantity * $cartItem->price_at_time_of_addition,
                'status' => 'pending',  
            ]);
    
            // Change the status of the cart item to 'ordered' (after it gets checkedout the status should be ordered)
            $cartItem->update(['status' => 'ordered']);
        }
    
    
        return response()->json(['message' => 'Checkout successful, orders created and cart items marked as ordered!']);
    }




    public function updateOrder(Request $request, $orderId)
    {
        $userId = Auth::id();  
        
        $request->validate([
            'quantity' => 'required|integer|min:1',  
        ]);
        

        $order = Order::where('id', $orderId)
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->first();
        
        // If the order doesn't exist or isn't 'pending', should return an error
        if (!$order) {
            return response()->json(['message' => 'Order not found or cannot be updated'], 404);
        }
        
        $product = $order->product;
        
        $previousQuantity = $order->quantity;
        
        // Return the old quantity back to stock
        $product->stock += $previousQuantity;
        
        if ($product->stock < $request->quantity) {
            return response()->json(['message' => 'Not enough stock for the new quantity'], 400);
        }
        
        $order->update([
            'quantity' => $request->quantity,
            'total_price' => $request->quantity * $order->price_at_time_of_addition,  // Update total price
        ]);
        
        // here also I Subtract the new quantity from the stock
        $product->stock -= $request->quantity;
        
    
        if (!$product->save()) {
            return response()->json(['message' => 'Failed to update stock'], 500);
        }
        
        return response()->json(['message' => 'Order updated successfully']);
    }
    


    public function deleteOrder($orderId)
    {
        $order = Order::where('user_id', Auth::id())->find($orderId);
    
        if (!$order) {
            return response()->json(['message' => 'Order not found or not authorized to delete this order.'], 404);
        }
    
        $product = $order->product;
    
        $product->stock += $order->quantity;
        $product->save();
    
        $order->delete();
    
        return response()->json(['message' => 'Order deleted successfully and stock updated.']);
    }
    


}
