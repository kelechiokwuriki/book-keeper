<?php


namespace App\Services\CheckerSystem;


use App\Book;
use App\Interfaces\BookCheckSystemInterface;
use App\Repositories\Book\BookRepository;
use App\Services\Book\BookService;
use App\Services\Reservation\ReservationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class HardCoverBookCheckerService implements BookCheckSystemInterface
{
    protected $bookRepository;
    protected $bookService;

    public function __construct(BookRepository $bookRepository, BookService $bookService)
    {
        $this->bookRepository = $bookRepository;
        $this->bookService = $bookService;
    }

    public function checkBookIn(Book $book)
    {
        try{
            $getBook = $this->bookRepository->getById($book->id);

            $bookReservation = $getBook->reservations()->where('book_id', $getBook->id)->first();

            if(isset($bookReservation)) {
                $bookReservation->update([
                    'checked_in_at' => now()
                ]);

                //change book availability to true
                $this->updateBookAvailability($book->id, true);
                return $bookReservation;
            }

        } catch (\Exception $exception){
            Log::error('Unable to check book in ' . 'Excep: ' . $exception->getMessage() . 'Book with ID: ' . $book->id);
            return false;
        }
    }

    public function checkBookOut(Book $book)
    {
        try{
            $getBook = $this->bookRepository->getById($book->id);

            if(isset($getBook)) {
                $bookReservation = $getBook->reservations()->create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'checked_out_at' => now(),
                    'checked_in_at' => null
                ]);

                //change book availability to false
                $this->updateBookAvailability($book->id, false);
                return $bookReservation;
            }

        } catch (\Exception $exception) {
            Log::error('Unable to check book out ' . 'Excep: ' . $exception->getMessage() . 'Book with ID: ' . $book->id);
            return false;
        }
    }

    /**
     * @param $bookId - id of intended book to update
     * @param $value - intended value
     * @return mixed bool or book data
     */
    private function updateBookAvailability($bookId, $value)
    {
        return $this->bookRepository->updateBookWhere($bookId, $value);
    }
}