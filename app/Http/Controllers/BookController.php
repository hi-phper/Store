<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('author')
            ->orderBy('id', 'desc')
            ->paginate(6);
        return view('book.index')
            ->with('books', $books);
    }

    public function show(Book $book)
    {
        return view('book.show')
            ->with('book', $book);
    }
}
