{{--<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin="anonymous"></script>--}}

@extends('layout')
@section('content')

<div class="title py-2 text-center">
    <h2>Книги</h2>
</div>
<div class="row">
    <div class="col-12">
        <form action="{{route('books.index')}}" class="py-3 search-form">
            <h3>Cортировка</h3>
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="name" value="{{$request->name ?? ''}}">
            </div>
            <div class="form-group">
                <label for="author">Автор</label>
                <input type="text" name="author" value="{{$request->author ?? ''}}">
            </div>
            <div class="form-group">
                <label for="sortByName">Отсортировать по названию</label>
                <input type="checkbox" name="sortByName" value="1">
            </div>
            <button type="submit" class="btn btn-secondary">Отсортировать</button>
        </form>
    </div>
</div>

<div class="add-btn py-2">
<!-- Button trigger modal -->
    <button type="button" class="btn btn-primary py-2" data-toggle="modal" data-target="#exampleModal" id="addBtn">
        Добавить книгу
    </button>
</div>

<table class="table">
    <thead class="thead-light">
    <tr>
        <th>#</th>
        <th>Книга</th>
        <th>Автор</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>

    @forelse($books as $book)
        <tr>
            <th scope="row">{{$loop->iteration}}</th>
            <th>{{mb_substr($book->name, 0, 15)}}</th>
            <th>
                @forelse($book->authors as $author)
                    {{$author->surname . ","}}
                @empty
                    Добавьте автора!!
                @endforelse
            </th>
            <th>
                <div class="btn-group">
                    <div class="btn-group__control">
                        <a href="{{route("books.show", $book->id)}}">
                            <button type="button" class="btn btn-success">Просмотреть</button>
                        </a>
                    </div>
                    <div class="btn-group__control">
                        <button type="button" class="btn btn-warning edit-btn" data-toggle="modal" data-target="#exampleModal" book-id="{{$book->id}}">
                            Изменить
                        </button>
                    </div>
                    <div class="btn-group__control">
                        <form action="{{route('books.destroy', $book->id)}}" method="get" >
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-danger admin-delete-btn" >Удалить</button>
                        </form>
                    </div>
                </div>
            </th>
        </tr>
    @empty
        <tr class="table-warning">
            <td colspan="5">Нет книг! Добавьте книгу!</td>
        </tr>
    @endforelse
    </tbody>
</table>

@if($books->total() > $books->count())
    <div class="pagination d-flex flex-row justify-content-center py-3">
        <div class="raw justify-content-center">
            <div class="col-md-4">
                {{$books->links()}}
            </div>
        </div>
    </div>
@endif

@endsection
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить книгу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('books.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nameInput">Добавьте название книги</label>
                        <input type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" name="name" required>
                        <small id="nameHelp" class="form-text text-muted">
                            <span class="text-danger">*</span>Обязательное поле
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="titleInput">Добавьте описание</label>
                        <textarea class="form-control" id="titleInput" rows="3" name="title"></textarea>
                        <small id="titleHelp" class="form-text text-muted">Не обязательное поле</small>
                    </div>
                    <div class="form-group">
                        <label for="select">Добавьте автора</label>
                        <select multiple size="3" class="custom-select" name="authors" id="authorInput">
                            @foreach ($authors as $author)
                                <option value="{{$author->id}}">{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dateInput">Добавьте дату</label>
                        <input type="date" id="dateInput" name="date" value="{{now()->format('Y-m-d')}}">
                    </div>
                    <div class="form-group">
                        <div class="error-file"></div>
                        <label for="exampleFormControlFile1">Добавьте фото</label>
                        <input type="file" class="form-control-file" name="img" id="imgInput" accept=".jpg, .jpeg, .png">
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                <button type="button" type="submit" class="btn btn-primary" id="submitBtn" >Сохранить</button>
                <button type="button" type="submit" class="btn btn-primary" id="changeBtn" >Изменить</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/actionBooks.js')}}"></script>

