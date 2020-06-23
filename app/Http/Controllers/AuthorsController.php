<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Illuminate\Validation\Validator;
use App\Http\Requests\AuthorsRequest;

class AuthorsController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::with('books');
        if ($request->has('surname')) {
            $authors = $authors->where('surname','like',"%$request->surname%");
        }
        if ($request->has('name')) {
            $authors = $authors->where('name','like',"%$request->name%");
        }

        if($request->has('sortBySurname')) {
            $authors->orderBy('surname','desc');
        }

        $authors = $authors->paginate(15);

        return view('authors.index',compact('authors'));
    }

    public function show(int $id)
    {
        $author = Author::with('books')->where('id','=',$id)->first();
        return view('authors.show', compact("author"));
    }

    public function store(AuthorsRequest $request)
    {
        $author = Author::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' =>  $request->patronymic,
        ]);

        return response()->json($author);
    }

    public function update(AuthorsRequest $request, int $id){

        $author = Author::find($id);

        $author->fill([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' =>  $request->patronymic,
        ]);

        $author->save();
        return response()->json($author);
    }

    public function getAuthorByid(int $id)
    {
        $author = Author::with('books')->find($id);
        return response()->json($author);
    }

    public function destroy(int $id){
        Author::find($id)->books()->detach();
        Author::destroy($id);
        return redirect()->route('authors.index');
    }
}
