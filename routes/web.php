<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Auth::routes();

//books
Route::resource('books', 'BooksController')->middleware('auth');

//reservations
Route::resource('reservations', 'ReservationsController')->middleware('auth');

//dashboard
Route::resource('dashboard', 'DashboardController')->middleware('auth');





