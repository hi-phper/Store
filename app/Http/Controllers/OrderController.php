<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Http\Requests\OrderCreateRequest;

class OrderController extends Controller
{
    public function store(OrderCreateRequest $request)
    {
        $member_id = $request->user()->id;
        $address = $request->address;
        $cart_books = Cart::with('book')
            ->where('member_id', $member_id)
            ->get();
        $cart_total = Cart::where('member_id', $member_id)
            ->sum('total');
        if(count($cart_books) === 0) {
            return redirect()
                ->route('index')
                ->with('message', '您的购物车是空的');
        }
        $order = Order::create([
            'member_id' => $member_id,
            'address' => $address,
            'total' => $cart_total,
        ]);
        foreach($cart_books as $order_books) {
            $order->books()->attach($order_books->book_id, [
                'amount' => $order_books->amount,
                'price' => $order_books->book->price,
                'total' => $order_books->book->price * $order_books->amount,
            ]);
        }
        Cart::where('member_id', $member_id)
            ->delete();
        
        return redirect()
            ->route('order')
            ->with('message', '订单已成功处理');
    }

    public function index(Request $request)
    {
        $member_id = $request->user()->id;
        $orders = Order::with('books')
            ->where('member_id', $member_id)
            ->orderBy('id', 'desc')
            ->get();
        
        return view('order.index')
            ->with('orders', $orders);
    }
}
