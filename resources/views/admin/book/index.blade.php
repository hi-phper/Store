@extends('admin.layouts.app')

@section('content')
    <h4>书籍管理</h4>
    <p>
        <a href="{{ route('admin.book.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> 添加
        </a>
    </p>
    <form action="{{ route('admin.book.search') }}" method="post" id="search_form" class="mb-2">
        @csrf
        {{ method_field('put') }}
        <input type="text" name="search_keyword" value="{{ session('admin.book.search_keyword') }}" id="search_keyword"
        title="在书籍名称中搜索，使用id:数字表示使用书籍ID号搜索"
        data-toggle="tooltip"
        placeholder="搜索"
        >
        <button type="submit" class="btn btn-primary btn-sm" data-toggle="tooltip" title="搜索">搜索</button>
        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" title="清除" onclick="$('#search_keyword').val('');$('#search_form').submit();">清除</button>
        <select name="author_id" onchange="$('#search_form').submit()">
            <option value="">选择作者</option>
        @foreach($authors as $author)
            <option value="{{ $author->id }}" @if(session('admin.book.author_id') == $author->id) selected @endif>{{ $author->name }}</option>
        @endforeach
        </select>
    </form>
    @if(count($books) > 0)    
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名称</th>
                    <th>作者</th>
                    <th>创建时间</th>
                    <th>删除</th>
                </tr>
            </thead>
            <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>
                    <td>
                        <a href="{{ route('admin.book.edit', $book->id) }}">
                        {{ $book->title }} <i class="fas fa-edit"></i>
                        </a>
                    </td>
                    <td>{{ $book->author->name }}</td>
                    <td>{{ $book->created_at }}</td>
                    <td>
                        <form action="{{ route('admin.book.destroy', $book->id) }}" method="post">
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
        {!! $books->links() !!}
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