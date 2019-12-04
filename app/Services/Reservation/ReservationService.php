<?php


namespace App\Services\Reservation;


use App\Book;
use App\Repositories\Book\BookRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Reservation;
use App\Services\Book\BookService;
use App\Services\User\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReservationService
{
    protected $reservationRepository;
    protected $bookService;
    protected $userService;
    protected $bookRepository;

    protected $bookModel;

    public function __construct(ReservationRepository $reservationRepository,
                                BookService $bookService,
                                UserService $userService,
                                Book $bookModel)
    {
        $this->reservationRepository = $reservationRepository;
        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->bookModel = $bookModel;
    }

    /**
     * @param $bookId id of intended book to be checked in
     * @return bool or reservation
     */
    public function checkBookIn($bookId)
    {
        try{
            $book = $this->bookService->getBookById($bookId);

            $bookReservation = $book->reservations()->where('book_id', $bookId)->first();

            if(isset($bookReservation)) {
                $bookReservation->update([
                    'checked_in_at' => now()
                ]);

                $this->updateBookAvailability($bookId, true);
                return $bookReservation;
            }
            return false;

        } catch (\Exception $exception){
            Log::error('Unable to check book in ' . 'Excep: ' . $exception->getMessage() . 'Book with ID: ' . $bookId);
            return false;
        }
    }

    /**
     * @param $bookId id of intended book to be checked out
     * @return bool or reseravation
     */
    public function checkBookOut($bookId)
    {
        try{
            $book = $this->bookService->getBookById($bookId);

            if(isset($book)) {
                $bookReservation = $book->reservations()->create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'checked_out_at' => now(),
                    'checked_in_at' => null
                ]);

                $this->updateBookAvailability($bookId, false);
                return $bookReservation;
            }
            return false;

        } catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @param $id of intended registeration to retrieve
     * @return bool or result
     */
    public function getReservationById($id)
    {
        try{
            $result = $this->reservationRepository->findById($id);

            return $this->isValid($result);

        } catch (\Exception $exception){
            echo $exception->getMessage();
            Log::error($exception->getMessage());

            return false;
        }
    }

    /**
     * @param $id id of intended book to delete
     * @return bool
     */
    public function deleteReservation($id)
    {
        try{
            return $this->reservationRepository->delete($id);
        } catch (\Exception $exception){
            echo $exception->getMessage(); Log::error($exception->getMessage());
            return false;
        }
    }

    /**
     * @return bool get all registerations
     */
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

    /**
     * @param $reservations $reservations model
     * @return bool or reservation object
     * This method returns the reservation model with added properties
     */
    public function returnReservObjWithMoreInfo($reservations) {
        foreach($reservations as $reservation)
        {
            $reservation->bookTitleNew = $this->bookService->getBookById($reservation->book_id)->title;
            $reservation->reservedBy = $this->userService->getUserById($reservation->user_id)->name;
        }

        return $reservations ?? false;
    }

    /**
     * @param $id id of reservatation to find
     * @return bool or reservation model
     */
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

    /**
     * @return mixed returns the total numnber of registerations
     */
    public function getNumberOfUserRegisterationInfo() {
        return $this->reservationRepository->getCount();
    }

    //validate result data

    /**
     * @param $result book result from eloquent find
     * @return mixed
     */
    private function isValid($result)
    {
        return isset($result) && $result !== null ? $result : false;
    }

    /**
     * @param $bookId id of intented book to update
     * @param $value - intended value
     * @return mixed bool or book data
     */
    private function updateBookAvailability($bookId, $value)
    {
        return $this->bookService->updateBookWhere($bookId, $value);
    }

}
