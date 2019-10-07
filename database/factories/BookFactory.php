<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'author' => $faker->name,
        'version' => $faker->numberBetween(0, 10),
        'available' => 'true'
    ];
});
