<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['web'])->group(function () {
    Route::get('/', function () {
        return view('auth.login');
    });

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/history', 'HistoryController@index')->name('history');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/endpoint', [LocationController::class, 'store']);
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
});
