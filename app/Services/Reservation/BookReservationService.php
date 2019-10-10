<?php


namespace App\Services\Reservation;


use App\Book;
use App\Repositories\Book\BookRepository;
use App\Repositories\BookReservation\BookReservationRepository;
use App\Reservation;
use App\Services\Book\BookService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BookReservationService
{
    protected $reservationRepository;
    protected $bookService;
    protected $userService;
    protected $bookRepository;

    protected $bookModel;

    public function __construct(BookReservationRepository $reservationRepository,
                                BookRepository $bookRepository,
                                BookService $bookService,
                                UserService $userService,
                                Book $bookModel)
    {
        $this->reservationRepository = $reservationRepository;
        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->bookModel = $bookModel;
    }

    public function checkBookIn($bookId)
    {
        try{
            $bookReservation = $this->bookModel->reservations()->where('user_id', auth()->id())
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

    public function getReservationById($id)
    {
        try{
            $result = $this->reservationRepository->getById($id);
            return $this->isValid($result);
        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    public function deleteReservation($id)
    {
        try{
            return $this->reservationRepository->delete($id);
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

    public function returnReservObjWithMoreInfo($reservations) {
        foreach($reservations as $reservation)
        {
            $reservation->bookTitleNew = $this->bookService->getBookById($reservation->book_id)->title;
            $reservation->reservedBy = $this->userService->getUserById($reservation->user_id)->name;
        }

        return $reservations ?? false;
    }

    public function getReservationWhereFieldMatches($id)
    {
        try{
            $result = $this->reservationRepository->where('book_id', $id);
            return $this->isValid($result);
        }catch (\Exception $exception){
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