@extends('admin.layouts.app')

@section('content')
    <h4>订单管理</h4>
    <form action="{{ route('admin.order.search') }}" method="post" id="search_form" class="mb-2">
        @csrf
        {{ method_field('put') }}
        <input type="text" name="search_keyword" value="{{ session('admin.order.search_keyword') }}" id="search_keyword"
        title="使用id:数字表示使用订单ID号搜索"
        data-toggle="tooltip"
        placeholder="搜索"
        >
        <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" title="搜索">搜索</button>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="清除" onclick="$('#search_keyword').val('');$('#search_form').submit();">清除</button>
        <select name="member_id" onchange="$('#search_form').submit()">
            <option value="">选择用户</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @if(session('admin.order.member_id') == $user->id) selected @endif>{{ $user->name }}</option>
        @endforeach
        </select>
    </form>
    @if(count($orders) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>总金额</th>
                    <th>创建时间</th>
                    <th>详情</th>
                    <th>删除</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->created_at }}</td>
                    <td>
                        <a href="{{ route('admin.order.details', $order->id) }}">详情</a>
                    </td>
                    <td>
                        <form action="{{ route('admin.order.destroy', $order->id) }}" method="post">
                            @csrf
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fas fa-times-circle"></i> 删除
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $orders->links() !!}
    @else
        @include('partials.no_record')
    @endif
@endsection

@section('scripts')
    <script>
        $(function() {
            $('[data-toggle=tooltip]').tooltip();
        });
    </script>
@endsection