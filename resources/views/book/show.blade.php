@extends('layouts.app')

@section('content')
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
            <p class="card-title">介绍:</p>
            <p class="card-text">{!! $book->description !!}</p>
            @include('partials.add_to_cart')
        </div>
    </div>
@endsection