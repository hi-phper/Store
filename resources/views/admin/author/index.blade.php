@extends('admin.layouts.app')

@section('content')
    <h4>作者管理</h4>
    <p>
        <a href="{{ route('admin.author.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> 添加
        </a>
    </p>
    <form action="{{ route('admin.author.search') }}" method="post" id="search_form" class="mb-2">
        @csrf
        {{ method_field('put') }}
        <input type="text" name="search_keyword" value="{{ session('admin.author.search_keyword') }}" id="search_keyword"
        title="在作者名称中搜索，使用id:数字表示使用作者ID号搜索"
        data-toggle="tooltip"
        placeholder="搜索"
        >
        <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" title="搜索">搜索</button>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="清除" onclick="$('#search_keyword').val('');$('#search_form').submit();">清除</button>
    </form>    
    @if(count($authors) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>创建时间</th>
                    <th>删除</th>
                </tr>
            </thead>
            <tbody>
            @foreach($authors as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>
                        <a href="{{ route('admin.author.edit', $author->id) }}" data-toggle="tooltip" title="编辑">
                        {{ $author->name }} <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td>{{ $author->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.author.destroy', $author->id) }}" method="post">
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
        {!! $authors->links() !!}
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