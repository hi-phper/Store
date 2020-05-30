@if(Session::has('message'))
    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
        <strong>
            <i class="fas fa-info-circle"></i> 提示信息
        </strong>
        {{ Session::get('message') }}
    </div>
@endif