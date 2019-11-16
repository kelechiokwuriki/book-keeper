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

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function checkBookIn($bookId)
    {
        try{
            $getBook = $this->bookService->getBookById($bookId);

            $bookReservation = $getBook->reservations()->where('book_id', $bookId)->first();

            if(isset($bookReservation)) {
                $bookReservation->update([
                    'checked_in_at' => now()
                ]);

                //change book availability to true
                $this->updateBookAvailability($bookId, true);
                return $bookReservation;
            }

        } catch (\Exception $exception){
            Log::error('Unable to check book in ' . 'Excep: ' . $exception->getMessage() . 'Book with ID: ' . $bookId);
            return false;
        }
    }

    public function checkBookOut($bookId)
    {
        try{
            $getBook = $this->bookService->getBookById($bookId);

            if(isset($getBook)) {
                $bookReservation = $getBook->reservations()->create([
                    'user_id' => Auth::id(),
                    'book_id' => $bookId,
                    'checked_out_at' => now(),
                    'checked_in_at' => null
                ]);

                //change book availability to false
                $this->updateBookAvailability($bookId, false);
                return $bookReservation;
            }

        } catch (\Exception $exception) {
            Log::error('Unable to check book out ' . 'Excep: ' . $exception->getMessage() . 'Book with ID: ' . $bookId);
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
        return $this->bookService->updateBookWhere($bookId, $value);
    }
}