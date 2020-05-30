@extends('layouts.app')

@section('content')
    <div class="row row-cols-1 row-cols-md-3">
    @foreach($books as $book)
    <div class="col mb-4">
        <div class="card">
            @if($book->cover)
            <img class="card-img-top" width="100%" height="100%" src="{{ asset($book->cover) }}" alt="{{ $book->title }}">
            @endif
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{ route('book.show', $book->id) }}">{{ $book->title }}</a>
                </h5>
                <p class="card-text">作者: {{ $book->author->name }}</p>
                <p class="card-text">价格: {{ $book->price }}</p>
                @include('partials.add_to_cart')
            </div>
        </div>
    </div>
    @endforeach
    </div>
    {{ $books->links() }}
@endsection