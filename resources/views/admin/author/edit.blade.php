@extends('admin.layouts.app')

@section('content')
<h4>修改作者</h4>
<form action="{{ route('admin.author.update', $id) }}" method="post">
    @csrf
    {{ method_field('put') }}
    @include('admin.author._form')
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 保存
            </button>
            <a href="{{ route('admin.author.index') }}" class="btn btn-secondary">
                <i class="fas fa-directions"></i> 取消
            </a>
        </div>
    </div>
</form>
@endsection