<?php


namespace App\Services\Book;


use App\Repositories\Book\BookRepository;
use Illuminate\Support\Facades\Log;

class BookService
{
    protected $bookRepository;

    public function __construct(BookRepository $bookRepository)
    {
        $this->bookRepository = $bookRepository;
    }

    public function createBook($book)
    {
        return $this->bookRepository->create($book);
    }

    public function updateBook($id, $book)
    {
        return $this->bookRepository->update($id, $book);
    }

    public function updateBookWhere($id, $data)
    {
        return $this->bookRepository->updateBookWhere($id, $data);
//        return Book::where('id', $id)->update(['available' => $data]);
    }

    public function deleteBook($id)
    {
        $this->bookRepository->delete($id);
    }

    public function getNumberOfbooksAvailable()
    {
        return $this->bookRepository->getCount();
    }

    public function getAllBooks(){
        try{
            $result = $this->bookRepository->all();
            if(isset($result) && $result !== null)
            {
                return $result;
            }
            return false;

        }  catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function getBookById($id){
        return $this->bookRepository->getById($id);
    }
}