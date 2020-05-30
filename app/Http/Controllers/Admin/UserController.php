<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorEditRequest;
use Illuminate\Support\Facades\DB;
use App\Lib\ViewState;

class UserController extends Controller
{
    protected $fields = [
        'name' => '',
        'email' => '',
        'is_admin' => 0,
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ViewState::setState($request, 'admin.user.');

        $builder = User::orderBy('id', 'desc');

        $search_keyword = session('admin.user.search_keyword');
        if($search_keyword) {
            if(preg_match('/id:(\d+)/i', $search_keyword, $matches)) {
                $builder->where('id', $matches[1]);
            } else {
                $builder->where('name', 'like', '%' . $search_keyword . '%');
            }
        }

        $page = session('admin.user.page');
        $count = $builder->count();
        $resultPage = ceil($count / 5);
        if($page > $resultPage) {
            $page--;
            session(['admin.user.page' => $page]);
        }
        if($page) {
            $users = $builder->paginate(5, ['*'], 'page', $page);
        } else {
            $users = $builder->paginate(5);
        }        

        return view('admin.user.index')
            ->with('users', $users);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order_count = \App\Order::where('member_id', $id)->count();
        if($order_count > 0) {
            return redirect()->route('admin.user.index')
                ->with('message', '不允许删除此用户, 有' . $order_count . '个订单分配给此用户');
        }

        $user = User::findOrFail($id);
        $user->delete();

        $cart = DB::table('carts')
            ->where('member_id', $id)
            ->delete();

        return redirect()->route('admin.user.index')
            ->with('message', $user->name . '已删除');
    }
}
