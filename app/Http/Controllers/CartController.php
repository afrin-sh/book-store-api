<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Book;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Cart::create([
            'user_id' => auth()->id(),
            'book_id' => $request->book_id,
            'quantity' => $request->quantity,
        ]);

        return response()->json($cart);
    }

    public function view()
    {
        return Cart::where('user_id', auth()->id())->with('book')->get();
    }

    public function remove($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $cart->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }
}
