@extends('layouts.app')

@section('content')
    @if(count($orders) > 0)
        @foreach($orders as $order)
            <p>Order # {{ $order->id }} - {{ $order->user->name }} - {{ $order->created_at }}</p>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>商品名称</th>
                        <th>数量</th>
                        <th>价格</th>
                        <th>金额</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($order->books as $orderitem)
                    <tr>
                        <td>{{ $orderitem->title }}</td>
                        <td>{{ $orderitem->pivot->amount }}</td>
                        <td>{{ $orderitem->pivot->price }}</td>
                        <td>{{ $orderitem->pivot->total }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td></td>
                        <td></td>
                        <td>总计</td>
                        <td>{{ $order->total }}</td>
                    </tr>
                    <tr>
                        <td>收货地址</td>
                        <td>{{ $order->address }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        @endforeach
    @else
        <div class="card">
            <div class="card-header">
                <i class="fas fa-info-circle"></i> 提示信息
            </div>
            <div class="card-body">
                <p>目前没有订单</p>
            </div>
        </div>
    @endif
@endsection
