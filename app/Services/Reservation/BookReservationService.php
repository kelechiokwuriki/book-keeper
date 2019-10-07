<?php


namespace App\Services\Reservation;


use App\Book;
use App\Repositories\BookReservation\BookReservationRepository;
use App\Reservation;
use App\Services\Book\BookService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookReservationService
{
    protected $reservationRepository;
    protected $bookService;
    protected $bookModel;

    public function __construct(BookReservationRepository $reservationRepository, BookService $bookService, Book $bookModel)
    {
        $this->reservationRepository = $reservationRepository;
        $this->bookService = $bookService;
        $this->bookModel = $bookModel;
    }

    public function checkBookIn($bookId)
    {
        try{
            $bookReservation = $this->bookModel->reservations()->where('user_id', Auth::id())
                ->whereNotNull('checked_out_at')
                ->whereNull('checked_in_at')
                ->first();

            if($bookReservation){
                $bookReservation->update([
                    'checked_in_at' => now()
                ]);

                $this->updateBookAvailability($bookId, true);

                return $bookReservation;
            }
        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function checkBookOut($bookId)
    {
        try{
            $book = $this->bookService->getBookById($bookId);

            $bookReservation = $book->reservations()->create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'checked_out_at' => now(),
                'checked_in_at' => null
            ]);

            $this->updateBookAvailability($bookId, false);
            return $bookReservation;

        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function getAllReservations()
    {
        try{
            $result = $this->reservationRepository->all();

            return $this->isValid($result);

        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function getAllReservationsForLoggedInUser()
    {
        try{
            $result = $this->reservationRepository->where('user_id', Auth::id());

            return $this->isValid($result);

        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    //validate result data
    private function isValid($result)
    {
        if(isset($result) && $result !== null)
        {
            return $result;
        }
        return false;
    }

    private function updateBookAvailability($bookId, $value)
    {
        return $this->bookService->updateBookWhere($bookId, $value);
    }

}