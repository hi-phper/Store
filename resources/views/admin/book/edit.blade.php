@extends('admin.layouts.app')

@section('content')
<h4>修改作者</h4>
<form action="{{ route('admin.book.update', $id) }}" method="post">
    @csrf
    {{ method_field('put') }}
    @include('admin.book._form')
    <div class="form-group row">
        <div class="col-sm-10">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 保存
            </button>
            <a href="{{ route('admin.book.index') }}" class="btn btn-secondary">
                <i class="fas fa-directions"></i> 取消
            </a>
        </div>
    </div>
</form>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/colorbox.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/jquery.colorbox-min.js') }}"></script>
<script src="{{ asset('packages/barryvdh/elfinder/js/standalonepopup.min.js') }}"></script>
<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
    function processSelectedFile(filePath, inputId)
    {
        $('#' + inputId).val(filePath.replace(/\\/g, '\/'));
    }

    CKEDITOR.replace( 'description' );
</script>
@endsection