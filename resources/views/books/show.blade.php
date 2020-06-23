@extends('layout')
@section('content')
    <div class="title py-2 text-center">
        <h2>Просмотр книги {{$book->name}}</h2>
    </div>
<div class="book py-3">
    <div class="book__img">
        <img src="/storage/{{$book->img_link}}" alt="">
    </div>
    <div class="book__name py-3">
        <h2>Название книги: {{$book->name}}</h2>
    </div>
    <div class="book__title py-3">{{$book->title}}</div>
    <div class="book__title">Дата публикации: {{$book->pub_date}}</div>
</div>
@endsection