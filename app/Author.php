<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name', 'surname', 'patronymic',
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->belongsToMany(Book::class, 'books_authors');
    }
}
