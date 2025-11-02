<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;
use Inertia\Inertia;

class CartController extends Controller
{
    //
    public function add(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $user = $request->user();

        $cartItem = Cart::where('user_id', $user->id)
            ->where('item_id', $validated['item_id'])
            ->first();

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $cartItem->quantity + $validated['quantity']
            ]);
        } else {
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $validated['item_id'],
                'quantity' => $validated['quantity'],
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart');
    }

    public function index(Request $request)
    {
        $cartItems = Cart::with('item')
            ->where('user_id', $request->user()->id)
            ->get();

        return Inertia::render('Cart', [
            'cartItems' => $cartItems,
        ]);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem->quantity = $validated['quantity'];
        $cartItem->save();

        return redirect()->route('cart.index');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->back()->with('success', 'Item removed from cart');
    }

}
