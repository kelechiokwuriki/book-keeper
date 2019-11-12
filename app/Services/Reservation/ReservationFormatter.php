<?php /** @noinspection ReturnTypeCanBeDeclaredInspection */


namespace App\Services\Reservation;


use App\Interfaces\Formatter;
use App\Services\Book\BookService;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Log;

class ReservationFormatter implements Formatter
{
    protected $bookService;
    protected $userService;

    public function __construct(BookService $bookService, UserService $userService)
    {
        $this->bookService = $bookService;
        $this->userService = $userService;
    }

    /**
     * @param $reservations - Reservations object
     * @return bool
     * This method formats a reservation object by adding a book title and reserved by
     * property
     */
    public function format($reservations)
    {
        try{
            foreach ($reservations as $reservation) {
                $reservation->bookTitle = $this->bookService->getBookById($reservation->book_id)->title;
                $reservation->reservedBy = $this->userService->getUserById($reservation->user_id)->name;
            }

            return $reservations ?? false;

        } catch (\Exception $exception) {
            Log::error('Unable to format reservation object' .
                'Excep: ' . $exception->getMessage() .
                'Reservation: ' . json_encode($reservations));
            return false;
        }
    }
}