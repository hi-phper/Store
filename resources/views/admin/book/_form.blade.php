<div class="form-group row">
    <label for="title" class="col-sm-1 col-form-label">标题</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="title" value="{{ $title }}">
    </div>
</div>
<div class="form-group row">
    <label for="author_id" class="col-sm-1 col-form-label">作者</label>
    <div class="col-sm-3">
        <select class="form-control" name="author_id">
        @foreach($authors as $author)
            <option value="{{ $author->id }}" @if($author_id == $author->id) selected @endif>{{ $author->name }}</option>
        @endforeach
        </select>
    </div>
</div>
<div class="form-group row">
    <label for="isbn" class="col-sm-1 col-form-label">ISBN</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="isbn" value="{{ $isbn }}">
    </div>
</div>
<div class="form-group row">
    <label for="price" class="col-sm-1 col-form-label">价格</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="price" value="{{ $price }}">
    </div>
</div>
<div class="form-group row">
    <label for="cover" class="col-sm-1 col-form-label">封面</label>
    <div class="col-sm-6">
        <input type="text" class="form-control" name="cover" id="cover" value="{{ $cover }}">
        <a href="#" class="btn btn-primary popup_selector" data-inputid="cover">选择图片</a>
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-sm-1 col-form-label">介绍</label>
    <div class="col-sm-11">
        <textarea class="form-control" name="description">{{ $description }}</textarea>
    </div>
</div>
