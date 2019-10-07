<?php


namespace App\Repositories\BookReservation;


use App\Repositories\EloquentRepository;
use App\Reservation;

class BookReservationRepository extends EloquentRepository
{
    public function __construct(Reservation $reservationModel)
    {
        parent::__construct($reservationModel);
    }
}