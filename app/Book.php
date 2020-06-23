<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'name', 'title', 'img_link', 'pub_date'
    ];

    public $timestamps = false;

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'books_authors');
    }
}
