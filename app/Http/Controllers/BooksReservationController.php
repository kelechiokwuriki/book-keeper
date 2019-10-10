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

        $newReservationObject = $this->bookReservationService->addBooksTitlesToReservationObject($reservations);

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


        return redirect('/books')->with('success', 'Book reserved!');
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
        $newReservation = $this->bookReservationService->addBooksTitlesToReservationObject($reservation);
        $result = $this->bookReservationService->addReservedByInfoToReservationObject($newReservation);
        return $result;

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
    public function destroy($id)
    {
        $this->bookReservationService->deleteReservation($id);

        return redirect('/reservations')->with('success', 'Book deleted!');
    }
}
