<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddToCartRequest;

class CartController extends Controller
{
    public function addToCart(AddToCartRequest $request)
    {
        $member_id = Auth::user()->id;
        $book_id = $request->book_id;
        $amount = $request->amount;
        $cart = Cart::where('book_id', $book_id)
            ->where('member_id', $member_id)
            ->first();
        $book = Book::find($book_id);
        if($cart) {
            $cart->increment('amount', $amount);

            $total = $cart->amount * $book->price;
            $cart->total = $total;
            $cart->save();
        } else {
            Cart::create([
                'member_id' => $member_id,
                'book_id' => $book_id,
                'amount' => $amount,
                'total' => $amount * $book->price,
            ]);
        }

        return redirect()->route('cart.index')
            ->with('message', '商品已成功加入购物车');
    }

    public function update(Request $request)
    {
        $ids = $request->ids;
        foreach($ids as $order_id) {
            $amount_name = "amount_" . $order_id;
            $amount_value = (int)$request->$amount_name;
            if($amount_value > 0) {
                $cart = Cart::findOrFail($order_id);
                $price = Book::findOrFail($cart->book_id)->price;
                $total = $price * $amount_value;

                $cart->amount = $amount_value;
                $cart->total = $total;
                $cart->save();
            }
        }

        return redirect()->route('cart.index')
            ->with('message', '购物车已修改');
    }

    public function index()
    {
        $member_id = Auth::user()->id;
        $cart_books = Cart::with('book')
            ->where('member_id', $member_id)
            ->get();
        $cart_total = Cart::with('book')
            ->where('member_id', $member_id)
            ->sum('total');
        
        return view('cart.index')
            ->with('cart_books', $cart_books)
            ->with('cart_total', $cart_total);
    }

    public function delete($id)
    {
        $cart = Cart::find($id)->delete();
        
        return redirect()->route('cart.index')
            ->with('message', '购物车中的商品已删除');
    }
}
