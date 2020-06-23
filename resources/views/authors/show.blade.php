@extends('layout')
@section('content')
    <div class="title py-2 text-center">
        <h2>Просмотр автора {{$author->name}} {{$author->surname}}</h2>
    </div>
    <div class="author py-3">
        <div class="author__name py-1">
            <h2>Имя: {{$author->name}}</h2>
        </div>
        <div class="author__surname py-1">
            <h3>Фамилия: {{$author->surname}}</h3>
        </div>
        <div class="author__surname py-1">
            <h4>Отчество: {{$author->patronymic ?? ""}}</h4>
        </div>
        <div class="author_books">
            <p>Книги автора: </p>
            @forelse($author->books as $book)

                <p>{{$loop->iteration}} -
                   <a href="{{route("books.show", $book->id)}}">{{$book->name}}</a> Дата: {{$book->pub_date}}
               </p>
            @empty
                <p>У автора нет книг!</p>
            @endforelse
        </div>
    </div>
@endsection