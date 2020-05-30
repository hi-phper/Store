@extends('layouts.app')

@section('content')
    @if(count($cart_books) > 0)
        <form action="{{ route('cart.update') }}" method="post">
            @csrf
            {{ method_field('put') }}
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <th>商品名称</th>
                        <th>数量</th>
                        <th>价格</th>
                        <th>金额</th>
                        <th>删除</th>
                    </tr>
                @foreach($cart_books as $cart_item)
                    <tr>
                        <td>{{ $cart_item->book->title }}</td>
                        <td>
                            <input type="hidden" name="ids[]" value="{{ $cart_item->id }}">
                            <input type="number" min="1" max="20" step="1" name="amount_{{ $cart_item->id }}" value="{{ $cart_item->amount }}">
                        </td>
                        <td>{{ $cart_item->book->price }}</td>
                        <td>{{ $cart_item->total }}</td>
                        <td>
                            <a href="{{ URL::route('delete_book_from_cart', [$cart_item->id]) }}">
                            <i class="fas fa-times-circle"></i> 删除
                            </a>
                        </td>
                    </tr>
                @endforeach
                    <td></td>
                    <td></td>
                    <td>总金额</td>
                    <td>{{ $cart_total }}</td>
                    <td></td>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5">
                            <button type="submit" class="btn btn-primary btn-sm">修改购物车</button>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </form>
        <h5>收货信息</h5>
        <form action="/order" method="post">
            @csrf
            <div class="form-group row">
                <label for="address" class="col-sm-2 col-form-label">收货地址</label>
                <div class="col-sm-10">
                    <input class="form-control" type="text" name="address" id="address">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <button type="submit" class="btn btn-primary">提交订单</button>
                </div>
            </div>
        </form>
    @else
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 提示信息
            </div>
            <div class="card-body">
                <p>购物车中没有商品</p>
            </div>
        </div>
    @endif
@endsection