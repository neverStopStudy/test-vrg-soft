@extends('layout')
@section('content')
    <div class="title py-2 text-center">
        <h2>Авторы</h2>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{route("authors.index")}}" class="py-3 search-form">
                <h3>Cортировка</h3>
                <div class="form-group">
                    <label for="name">Фамилия</label>
                    <input type="text" name="surname" value="{{$request->name ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="author">Имя</label>
                    <input type="text" name="name" value="{{$request->surname ?? ''}}">
                </div>
                <div class="form-group">
                    <label for="sortByName">Отсортировать по Фамилии</label>
                    <input type="checkbox" name="sortBySurname" value="1">
                </div>
                <button type="submit" class="btn btn-secondary">Отсортировать</button>
            </form>
        </div>
    </div>
    <div class="add-btn py-2">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary py-2" data-toggle="modal" data-target="#modal" id="addBtn">
            Добавить автора
        </button>
    </div>
    <table class="table">
        <thead class="thead-light">
        <tr>
            <th>#</th>
            <th>Имя</th>
            <th>Фамилия</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        @forelse($authors as $author)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <th>{{mb_substr($author->name, 0, 15)}}</th>
                <th>{{$author->surname}}</th>
                <th>
                    <div class="btn-group">
                        <div class="btn-group__control">
                            <a href="{{route("authors.show", $author->id)}}">
                                <button type="button" class="btn btn-success">Просмотреть</button>
                            </a>
                        </div>
                        <div class="btn-group__control">
                            <button type="button" class="btn btn-warning edit-btn" data-toggle="modal" data-target="#modal" author-id="{{$author->id}}">
                                Изменить
                            </button>
                        </div>
                        <div class="btn-group__control">
                            <form action="{{route('authors.destroy', $author->id)}}" method="get" >
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
                <td colspan="5">Нет авторов! Добавьте автора!</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @if($authors->total() > $authors->count())
        <div class="pagination d-flex flex-row justify-content-center py-3">
            <div class="raw justify-content-center">
                <div class="col-md-4">
                    {{$authors->links()}}
                </div>
            </div>
        </div>
    @endif
@endsection
<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить Автора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('authors.store')}}" method="POST" id="addForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nameInput">Добавьте имя </label>
                        <input type="text" class="form-control" id="nameInput" aria-describedby="nameHelp" name="name">
                        <small id="nameHelp" class="form-text text-muted">
                            <span class="text-danger">*</span>Обязательное поле
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="surnameInput">Добавьте фамилию</label>
                        <input type="text" class="form-control" id="surnameInput" aria-describedby="surnameHelp" name="surname">
                        <small id="surnameHelp" class="form-text text-muted">
                            <span class="text-danger">*</span>Обязательное поле
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="patronymicInput">Добавьте отчество</label>
                        <input type="text" class="form-control" id="patronymicInput" aria-describedby="patronymicHelp" name="patronymic">
                        <small id="patronymicHelp" class="form-text text-muted">
                            Не обязательное поле
                        </small>
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
<script type="text/javascript" src="{{asset('js/actionAuthors.js')}}"></script>