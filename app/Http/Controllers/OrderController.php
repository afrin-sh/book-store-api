<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
    public function place()
    {
        $carts = Cart::where('user_id', auth()->id())->get();

        if ($carts->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $total = $carts->sum(function ($cart) {
            return $cart->book->price * $cart->quantity;
        });

        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => $total,
            'status' => 'Pending',
            'payment_method' => 'Cash on Delivery',
        ]);

        Cart::where('user_id', auth()->id())->delete();

        return response()->json(['message' => 'Order placed successfully', 'order' => $order]);
    }

    public function view()
    {
        return Order::where('user_id', auth()->id())->get();
    }
}
