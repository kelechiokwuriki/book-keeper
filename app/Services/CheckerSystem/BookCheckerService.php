<?php


namespace App\Services\CheckerSystem;


use App\Book;
use App\Interfaces\BookCheckSystemInterface;

class BookCheckerService
{
    public function CheckBookOut(Book $book, BookCheckSystemInterface $bookCheckSystem) {
        return $bookCheckSystem->checkBookOut($book);
    }

}