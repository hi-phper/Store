<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use App\Lib\ViewState;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ViewState::setState($request, 'admin.order.');

        $builder = Order::with('books')->with('user')
            ->orderBy('id', 'desc');

        $search_keyword = session('admin.order.search_keyword');
        if($search_keyword) {
            if(preg_match('/id:(\d+)/i', $search_keyword, $matches)) {
                $builder->where('id', $matches[1]);
            }
        }        

        $member_id = session('admin.order.member_id');
        if($member_id) {
            $builder->where('member_id', $member_id);
        }

        $page = session('admin.order.page');
        $count = $builder->count();
        $resultPage = ceil($count / 5);
        if($page > $resultPage) {
            $page--;
            session(['admin.order.page' => $page]);
        }
        if($page) {
            $orders = $builder->paginate(5, ['*'], 'page', $page);
        } else {
            $orders = $builder->paginate(5);
        }
        
        $users = User::select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();            

        return view('admin.order.index')
            ->with('orders', $orders)
            ->with('users', $users);
    }

    public function details(Order $order)
    {
        return view('admin.order.details')
            ->with('order', $order);        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.order.index')
            ->with('message', '订单号'. $order->id . '的订单已删除');
    }
}
