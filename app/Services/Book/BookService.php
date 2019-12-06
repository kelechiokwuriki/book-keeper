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

    public function updateBook($id, $data)
    {
        try{
            return $this->bookRepository->update($id, $data);
        } catch (\Exception $e){
            Log::error('Unable to update book with ID: '. json_encode($id) . 'Data: ' . json_encode($data)
            . 'Exception: ' . json_encode($e->getMessage()));
            return false;
        }
    }

    public function numberOfBooksAvailable()
    {
        return $this->bookRepository->getCount();
    }

    public function getAllBooks(){
        try{
            return $this->bookRepository->all();
        }  catch (\Exception $exception){
            Log::error('Error fetching all books');
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function getBookById($id){
        return $this->bookRepository->findById($id);
    }
}
