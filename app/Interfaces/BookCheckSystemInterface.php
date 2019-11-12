<?php


namespace App\Interfaces;


use App\Book;

interface BookCheckSystemInterface
{
    public function checkBookIn($book);
    public function checkBookOut($book);

}