<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $guarded = [];

    //a book has many reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
