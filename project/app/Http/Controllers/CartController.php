<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Item;

class CartController extends Controller
{
    //
    public function index(Request $request) 
    {
        $carts = $request->user()->carts()->with('item')->get();

        return Inertia('Cart/Index', ['carts' => $carts]);
    }

    public function add(Request $request) 
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items, id',
            'quantity' => 'required|integer|min:1',
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($validated['quantity'] > $item->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $existingCart = $request->user()->carts()
            ->where('item_id', $item->id)
            ->first();

        if ($existingCart) {
            $newQuantity = $existingCart -> quantity + $validated['quantity'];

            if ($newQuantity > $item->quantity) {
                return back()->withErrors(['quantity' => 'Not enough stock available.']);
            } 
            $existingCart->update(['quantity' => $newQuantity]);
        } else {
            $request -> user()->carts()->create($validated);
        }

        return back()->with('success', 'Item added to cart successfully.');
    }

    public function update(Request $request, $id) 
    {
        $this->authorize('update', $cart);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validated['quantity'] > $cart->item->quantity) {
            return back()->withErrors(['quantity' => 'Not enough stock available.']);
        }

        $cart->update($validated);

        return back()->with('success', 'Cart updated successfully.');
    }

    public function remove(Cart $cart)
    {
        $this->authorize('delete', $cart);

        $cart->delete();

        return back()->with('sucess', 'Item removed from cart successfully.');
    }
}
