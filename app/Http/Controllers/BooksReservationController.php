<?php

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
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Notification;

class BooksReservationController extends Controller
{
    protected $bookReservationService;
    protected $bookService;
    protected $userService;
    protected $bookCheckerService;
    protected $bookRepository;

    use FormatterService;

    public function __construct(ReservationService $bookReservationService,
                                BookCheckerService $bookCheckerService,
                                BookRepository $bookRepository,
                                BookService $bookService,
                                UserService $userService)
    {
        $this->bookReservationService = $bookReservationService;
        $this->bookService = $bookService;
        $this->userService = $userService;
        $this->bookRepository = $bookRepository;
        $this->bookCheckerService = $bookCheckerService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->get();

        $newReservationObject = $this->format($reservations,
            new ReservationFormatter($this->bookService, $this->userService));

        return view('reservations.reservations', compact('newReservationObject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->bookCheckerService->checkBookOut($request->bookId, new HardCoverBookCheckerService($this->bookService));

//        Notification::send(auth()->user(), new BookReservedNotification);
        return back()->with('success', 'Book reserved!');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return bool
     */
    public function show($id): bool
    {
        $reservation = $this->bookReservationService->getReservationWhereFieldMatches($id);

        return $this->format($reservation, new ReservationFormatter($this->bookService, $this->userService));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function edit(Reservation $reservation)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->bookCheckerService->checkBookIn($request->bookId, new HardCoverBookCheckerService($this->bookService));

        Notification::send(auth()->user(), new BookCheckedInNotification());
        return back()->with('success', 'Book checked in!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Response
     */
    public function destroy($id): Response
    {
        $this->bookReservationService->deleteReservation($id);
        return back()->with('success', 'Book deleted!');
    }
}
