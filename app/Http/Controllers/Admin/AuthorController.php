<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Book;
use App\Http\Requests\AuthorCreateRequest;
use App\Http\Requests\AuthorEditRequest;
use App\Lib\ViewState;

class AuthorController extends Controller
{
    protected $fields = [
        'name' => '',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        ViewState::setState($request, 'admin.author.');

        $builder = Author::orderBy('id', 'desc');

        $search_keyword = session('admin.author.search_keyword');
        if($search_keyword) {
            if(preg_match('/id:(\d+)/i', $search_keyword, $matches)) {
                $builder->where('id', $matches[1]);
            } else {
                $builder->where('name', 'like', '%' . $search_keyword . '%');
            }
        }

        $page = session('admin.author.page');
        $count = $builder->count();
        $resultPage = ceil($count / 5);
        if($page > $resultPage) {
            $page--;
            session(['admin.author.page' => $page]);
        }
        if($page) {
            $authors = $builder->paginate(5, ['*'], 'page', $page);
        } else {
            $authors = $builder->paginate(5);
        }
        return view('admin.author.index')
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

        return view('admin.author.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AuthorCreateRequest $request)
    {
        $author = new Author();
        foreach(array_keys($this->fields) as $field) {
            $author->$field = $request->$field;
        }
        $author->save();

        return redirect()->route('admin.author.index')
            ->with('message', $author->name . '添加成功');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $author = Author::findOrFail($id);
        $data['id'] = $id;
        foreach(array_keys($this->fields) as $field) {
            $data[$field] = old($field, $author->$field);
        }

        return view('admin.author.edit', $data);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AuthorEditRequest $request, $id)
    {
        $author = Author::findOrFail($id);
        foreach(array_keys($this->fields) as $field) {
            $author->$field = $request->$field;
        }
        $author->save();

        return redirect()->route('admin.author.index')
            ->with('message', $author->name . '已修改');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book_count = Book::where('author_id', $id)->count();
        if($book_count > 0) {
            return redirect()->route('admin.author.index')
                ->with('message', '不允许删除此作者, 有' . $book_count . '本书分配给此作者');
        }

        $author = Author::findOrFail($id);
        $author->delete();

        return redirect()->route('admin.author.index')
            ->with('message', $author->name . '已删除');
    }
}
