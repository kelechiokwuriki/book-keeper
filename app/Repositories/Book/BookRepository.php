<?php


namespace App\Repositories\Book;


use App\Book;
use App\Repositories\EloquentRepository;

class BookRepository extends EloquentRepository
{
    protected $bookModel;

    /**
     * BookRepository constructor.
     * @param Book $bookModel
     */
    public function __construct(Book $bookModel)
    {
        parent::__construct($bookModel);
        $this->bookModel = $bookModel;
    }
}
