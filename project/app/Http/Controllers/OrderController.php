<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    //
    public function checkoutPage()
    {
        $cartItems = Cart::with('item')
            ->where('user_id', Auth::id())
            ->get();

        $total = $cartItems->sum(fn($cart) => $cart->item->price * $cart->quantity);

        return Inertia::render('Checkout', [
            'cartItems' => $cartItems,
            'total' => $total
        ]);
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'card_number' => 'required|string|min:8',
        ]);

        $user = Auth::user();
        $cartItems = Cart::with('item')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Your cart is empty.');
        }

        $totalPrice = $cartItems->sum(fn($cart) => $cart->item->price * $cart->quantity);

        $order = Order::create([
            'user_id' => $user->id,
            'shipping_address' => $request->shipping_address,
            'card_number' => $request->card_number,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);

        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'item_id' => $cartItem->item_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->item->price,
            ]);

            $cartItem->item->decrement('quantity', $cartItem->quantity);
        }

        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('orders.history')->with('success', 'Checkout successful!');
    }

    public function orderHistory()
    {
       $orders = Order::where('user_id', auth()->id())
        ->with('items')
        ->orderBy('created_at', 'asc') 
        ->get();

        return Inertia::render('OrderHistory', [
            'orders' => $orders
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Pending,Processing,Completed,Cancelled',
        ]);

        $order = Order::where('user_id', auth()->id())->findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Order status updated successfully.');
    }

}
