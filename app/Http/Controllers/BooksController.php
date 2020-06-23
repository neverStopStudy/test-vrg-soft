<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Illuminate\Support\Facades\Storage;
use App\Author;
use App\Http\Requests\BooksRequest;
use Illuminate\Database\Eloquent\Builder;

class BooksController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::all();
        $books = Book::with('authors');

        if ($request->has('author')) {
            // Получить книги, где хотя бы у одного автора фамилия начинается со слова $request->author
            $books = Book::whereHas('authors', function (Builder $query) use ($request) {
                $query->where('surname', 'like', "%$request->author%");
            });
        }

        if ($request->has('name')) {
            $books = $books->where('name','like',"%$request->name%");
        }

        if($request->has('sortByName')) {
            $books->orderBy('name','desc');
        }

        $books = $books->paginate(15);

        return view('books.index', compact('books','authors'));
    }

    public function show(int $id)
    {
        $book = Book::with('authors')->where('id','=',$id)->first();
        return view('books.show', compact("book"));
    }

    public function update(BooksRequest $request, int $id){

        $book = Book::find($id);

        $authors_id = explode(',', $request->authors);

        $file = $request->file('img');
        $path = $file->storeAs('public', time() . rand() . $file->getClientOriginalName());

        $path = explode('/',$path);

        $book->fill([
            'name' => $request->name,
            'title' => $request->title ?? '',
            'img_link' =>  $path[1],
            'pub_date' =>  $request->pub_date,
        ]);

        foreach ($authors_id as $author){
            $book->authors()->attach($author);
        }
        $book->save();
        return response()->json($book);
    }

    public function getBookByid(int $id)
    {
        $book = Book::with('authors')->find($id);
        return response()->json($book);
    }

    public function store(BooksRequest $request)
    {
        $authors_id = explode(',',$request->authors);

        $file = $request->file('img');
        $path = $file->storeAs('public', time() . rand() . $file->getClientOriginalName());

        $path = explode('/',$path);

        $book = Book::create([
            'name' => $request->name,
            'title' => $request->title ?? '',
            'img_link' =>  $path[1],
            'pub_date' =>  $request->pub_date,
        ]);

        foreach ($authors_id as $author){
            $book->authors()->attach($author);
        }

        $book = Book::with('authors')->where('id','=',$book->id)->first();
        return response()->json($book);
    }

    public function destroy(int $id){
        Book::find($id)->authors()->detach();
        Book::destroy($id);
        return redirect()->route('books.index');
    }

}
