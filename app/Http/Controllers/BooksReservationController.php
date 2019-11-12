<?php /** @noinspection PhpUndefinedFieldInspection */

namespace App\Http\Controllers;

use App\Notifications\BookCheckedInNotification;
use App\Notifications\BookReservedNotification;
use App\Repositories\Book\BookRepository;
use App\Reservation;
use App\Services\Book\BookService;
use App\Services\CheckerSystem\BookCheckerService;
use App\Services\CheckerSystem\HardCoverBookCheckerService;
use App\Services\FormatterService;
use App\Services\Reservation\ReservationFormatter;
use App\Services\Reservation\ReservationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class BooksReservationController extends Controller
{
    protected $bookReservationService;
    protected $bookService;
    protected $userService;
    protected $bookCheckerService;
    protected $bookRepository;
    protected $formatterService;

    public function __construct(ReservationService $bookReservationService,
                                FormatterService $formatterService,
                                BookCheckerService $bookCheckerService,
                                BookRepository $bookRepository,
                                BookService $bookService,
                                UserService $userService)
    {
        $this->bookReservationService = $bookReservationService;
        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->bookRepository = $bookRepository;
        $this->formatterService = $formatterService;

        $this->bookCheckerService = $bookCheckerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->get();

        $newReservationObject = $this->formatterService->format($reservations,
            new ReservationFormatter($this->bookService, $this->userService));

        return view('reservations.reservations', compact('newReservationObject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->bookCheckerService->checkBookOut($request->bookId, new HardCoverBookCheckerService($this->bookRepository));

        Notification::send(auth()->user(), new BookReservedNotification);
        return back()->with('success', 'Book reserved!');
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return bool
     */
    public function show($id)
    {
        $reservation = $this->bookReservationService->getReservationWhereFieldMatches($id);
        $reservationObj = $this->bookReservationService->returnReservObjWithMoreInfo($reservation);

        return $reservationObj;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->bookReservationService->checkBookIn($request->bookId);

        Notification::send(auth()->user(), new BookCheckedInNotification());
        return back()->with('success', 'Book checked in!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->bookReservationService->deleteReservation($id);
        return back()->with('success', 'Book deleted!');
    }
}
