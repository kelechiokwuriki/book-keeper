<?php


namespace App\Repositories\Reservation;


use App\Repositories\EloquentRepository;
use App\Reservation;

class ReservationRepository extends EloquentRepository
{
    public function __construct(Reservation $reservationModel)
    {
        parent::__construct($reservationModel);
    }
}