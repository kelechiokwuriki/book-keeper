<?php


namespace App\Repositories\Book;


use App\Book;
use App\Repositories\EloquentRepository;

class BookRepository extends EloquentRepository
{
    protected $bookModel;

    public function __construct(Book $bookModel)
    {
        parent::__construct($bookModel);
        $this->bookModel = $bookModel;
    }

    public function updateBookWhere($id, $data)
    {
        return $this->bookModel::where('id', $id)->update(['available' => $data]);
    }


}