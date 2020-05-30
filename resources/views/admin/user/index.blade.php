@extends('admin.layouts.app')

@section('content')
    <h4>用户管理</h4>
    <form action="{{ route('admin.user.search') }}" method="post" id="search_form" class="mb-2">
        @csrf
        {{ method_field('put') }}
        <input type="text" name="search_keyword" value="{{ session('admin.user.search_keyword') }}" id="search_keyword"
        title="在用户名称中搜索，使用id:数字表示使用用户ID号搜索"
        data-toggle="tooltip"
        placeholder="搜索"
        >
        <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" title="搜索">搜索</button>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="清除" onclick="$('#search_keyword').val('');$('#search_form').submit();">清除</button>
    </form> 
    @if(count($users) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>用户名</th>
                    <th>创建时间</th>
                    <th>删除</th>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>{{ $user->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.user.destroy', $user->id) }}" method="post">
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
        {!! $users->links() !!}
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