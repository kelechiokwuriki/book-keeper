<?php


namespace App\Interfaces;


use App\Book;

interface BookCheckSystemInterface
{
    public function checkBookIn(Book $book);
    public function checkBookOut(Book $book);

}