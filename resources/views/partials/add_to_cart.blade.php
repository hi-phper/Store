<form action="{{ route('cart.add') }}" method="post">
    @csrf
    <input type="hidden" name="book_id" value="{{ $book->id }}">
    <label for="amount">数量</label>
    <input type="number" name="amount" min="1" max="20" step="1" value="1">
    <button class="btn btn-primary btn-sm">加入购物车</button>
</form>