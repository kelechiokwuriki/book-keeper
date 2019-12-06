<?php


namespace App\Services\Reservation;


use App\Book;
use App\Repositories\Book\BookRepository;
use App\Repositories\Reservation\ReservationRepository;
use App\Services\Book\BookService;
use App\Services\User\UserService;
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
                                BookRepository $bookRepository,
                                BookService $bookService,
                                UserService $userService,
                                Book $bookModel)
    {
        $this->reservationRepository = $reservationRepository;
        $this->bookRepository = $bookRepository;

        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->bookModel = $bookModel;
    }

    /**
     * @param $reservationId
     * @return bool or reservation
     */
    public function returnBookToLibrary($reservationId): ?bool
    {
        try{
            $reservation = $this->reservationRepository->findById($reservationId);

             $this->reservationRepository->update($reservation->id, [
                'checked_in_at' => now()
            ]);

             //book is now available after
             return $this->bookRepository->update($reservation->book_id, [
                 'available' => true
             ]);

        } catch (\Exception $exception){
            Log::error('Unable to return book to library with ID: ' . $reservationId . 'Exception: ' .
                $exception->getMessage());
            return false;
        }
    }

    /**
     * @param $id
     * @return bool or reseravation
     */
    public function removeBookFromLibrary($id): ?bool
    {
        try{
            $book = $this->getBookId($id);

            $this->reservationRepository->create([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'checked_out_at' => now(),
                'checked_in_at' => null
            ]);

            //book is no more available after checking out - reservation made
            return $this->bookRepository->update($book->id, [
                'available' => false
            ]);

        } catch (\Exception $exception){
            Log::error('Unable to check book out with id: ' . $id . 'Exception: ' . json_encode($exception));
            return false;
        }
    }

    public function findBookReservationById($id) {
        return $this->reservationRepository->where('book_id', $id)->first();
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

    /**
     * @param $result book result from eloquent find
     * @return mixed
     */
    private function isValid($result)
    {
        return isset($result) && $result !== null ? $result : false;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getBookId($id) {
        return $this->bookRepository->findById($id);
    }

//    private function checkIfBookHasBeenReserved($id) {
//        $this->reservationRepository->where()
//    }

}
