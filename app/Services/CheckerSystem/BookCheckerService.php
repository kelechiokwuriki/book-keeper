<?php


namespace App\Services\CheckerSystem;


use App\Interfaces\BookCheckSystemInterface;

class BookCheckerService
{
    public function checkBookOut($book, BookCheckSystemInterface $bookCheckSystem) {
        return $bookCheckSystem->checkBookOut($book);
    }

}