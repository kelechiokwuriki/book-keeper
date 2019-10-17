<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Services\Book\BookService;
use App\Services\Reservation\BookReservationService;
use App\Services\Reservation\ReservationCrud;
use Illuminate\Http\Request;

class BooksReservationController extends Controller
{
    protected $bookReservationService;
    protected $bookService;

    public function __construct(BookReservationService $bookReservationService,
                                BookService $bookService)
    {
        $this->bookReservationService = $bookReservationService;
        $this->bookService = $bookService;
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
//        session()->put('success','Book reserved!');

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
