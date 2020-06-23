<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/','BooksController@index')->name('books.index');
Route::get('/book/{id}/show','BooksController@show')->name('books.show');
Route::get('/book/{id}','BooksController@getBookByid')->name('books.getBookByid');
Route::post('/book/store','BooksController@store')->name('books.store');
Route::post('/book/{id}/update','BooksController@update')->name('books.update');
Route::get('/book/{id}/destroy','BooksController@destroy')->name('books.destroy');


Route::get('/authors','AuthorsController@index')->name('authors.index');
Route::get('/author/{id}/show','AuthorsController@show')->name('authors.show');
Route::get('/author/{id}/destroy','AuthorsController@destroy')->name('authors.destroy');
Route::post('/author/store','AuthorsController@store')->name('authors.store');
Route::get('/author/{id}','AuthorsController@getAuthorByid')->name('authors.getAuthorByid');
Route::post('/author/{id}/update','AuthorsController@update')->name('authors.update');
Route::get('/author/{id}/destroy','AuthorsController@destroy')->name('authors.destroy');