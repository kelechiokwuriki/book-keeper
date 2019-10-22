<?php

namespace App\Http\Controllers;

use App\Notifications\BookReservedNotification;
use App\Reservation;
use App\Services\Book\BookService;
use App\Services\Reservation\ReservationService;
use App\Services\User\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\Notifiable;

class BooksReservationController extends Controller
{
    protected $bookReservationService;
    protected $bookService;
    protected $userService;

    public function __construct(ReservationService $bookReservationService,
                                BookService $bookService,
                                UserService $userService)
    {
        $this->bookReservationService = $bookReservationService;
        $this->bookService = $bookService;
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = auth()->user()->reservations()->get();

        $newReservationObject = $this->bookReservationService->returnReservObjWithMoreInfo($reservations);

        return view('reservations.reservations', compact('newReservationObject'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
//        $reservations = $this->reservationService->getAllReservations();
//        return view('reservations.create', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->bookReservationService->checkBookOut($request->bookId);

        //send a book reserved notification to logged in user
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
        //get reservation by book id
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
        //
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
//        session()->put('success','Book checked in!');

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
