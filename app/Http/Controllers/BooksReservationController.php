<?php

namespace App\Http\Controllers;

use App\Reservation;
use App\Services\Book\BookService;
use App\Services\Reservation\BookReservationService;
use Illuminate\Http\Request;

class BooksReservationController extends Controller
{
    protected $bookReservationService;
    protected $bookService;

    public function __construct(BookReservationService $bookReservationService, BookService $bookService)
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

        foreach($reservations as $reservation)
        {
            $reservation->bookTitlesNew = $this->bookService->getBookById($reservation->book_id)->title;
        }

        return view('reservations.reservations', compact('reservations'));
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

        return redirect('/books')->with('success', 'Book reserved!');
    }

    /**
     * Display the specified resource.
     *
     * @param Reservation $reservation
     * @return void
     */
    public function show(Reservation $reservation)
    {
        //
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
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        //
    }
}
