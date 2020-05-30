@extends('admin.layouts.app')

@section('content')
    <p>
        <a href="{{ route('admin.order.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-directions"></i> 返回
        </a>
    </p>
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
@endsection