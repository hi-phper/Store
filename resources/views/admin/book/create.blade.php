@extends('admin.layouts.app')

@section('content')
<h4>添加书籍</h4>
<form action="{{ route('admin.book.store') }}" method="post">
    @csrf
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

    CKEDITOR.replace( 'description');
</script>
@endsection