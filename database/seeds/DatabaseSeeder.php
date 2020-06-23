<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\Author;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(Book::class,100)->create()->each(function ($book){
           $book->authors()->save(factory(Author::class)->make());
        });
    }
}
