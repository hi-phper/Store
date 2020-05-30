<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;
use App\Author;
use App\Http\Requests\BookCreateRequest;
use App\Http\Requests\BookEditRequest;
use App\Lib\ViewState;

class BookController extends Controller
{
    protected $fields = [
        'title' => '',
        'isbn' => '',
        'cover' => '',
        'price' => '',
        'author_id' => '',
        'description' => '',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ViewState::setState($request, 'admin.book.');

        $builder = Book::with('author')->orderBy('id', 'desc');
        
        $search_keyword = session('admin.book.search_keyword');
        if($search_keyword) {
            if(preg_match('/id:(\d+)/i', $search_keyword, $matches)) {
                $builder->where('id', $matches[1]);
            } else {
                $builder->where('title', 'like', '%' . $search_keyword . '%');
            }
        }        

        $author_id = session('admin.book.author_id');
        if($author_id) {
            $builder->where('author_id', $author_id);
        }

        $page = session('admin.book.page');
        $count = $builder->count();
        $resultPage = ceil($count / 5);
        if($page > $resultPage) {
            $page--;
            session(['admin.book.page' => $page]);
        }
        if($page) {
            $books = $builder->paginate(5, ['*'], 'page', $page);
        } else {
            $books = $builder->paginate(5);
        }
        
        $authors = Author::select('id', 'name')
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.book.index')
            ->with('books', $books)
            ->with('authors', $authors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [];
        foreach($this->fields as $field => $default) {
            $data[$field] = old($field, $default);
        }
        $authors = Author::orderBy('id', 'desc')->get();

        return view('admin.book.create', $data)
            ->with('authors', $authors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookCreateRequest $request)
    {
        $book = new Book();
        foreach(array_keys($this->fields) as $field) {
            $book->$field = $request->$field;
        }
        $book->save();

        return redirect()->route('admin.book.index')
            ->with('message', $book->title . '添加成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $book = Book::with('author')->findOrFail($id);
        $data['id'] = $id;
        foreach(array_keys($this->fields) as $field) {
            $data[$field] = old($field, $book->$field);
        }

        $authors = Author::orderBy('id', 'desc')->get();

        return view('admin.book.edit', $data)
            ->with('authors', $authors);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BookEditRequest $request, $id)
    {
        $book = Book::findOrFail($id);
        foreach(array_keys($this->fields) as $field) {
            $book->$field = $request->$field;
        }
        $book->save();

        return redirect()->route('admin.book.index')
            ->with('message', $book->title . '已修改');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        if($book->orders->count()) {
            return redirect()->route('admin.book.index')
                ->with('message', '不能删除' . $book->title . '，有订单相关联');
        }

        $book->delete();

        return redirect()->route('admin.book.index')
            ->with('message', $book->title . '已删除');
    }
}
