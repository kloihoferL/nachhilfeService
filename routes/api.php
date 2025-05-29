<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\AppointmentRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//für alle zugänglich
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('/offers', [OfferController::class, 'index']);
Route::get('offers/{id}', [OfferController::class, 'show']);
Route::get('/appointmentRequests', [AppointmentRequestController::class, 'getAppointmentRequests']);

//Routen die für autentifizierte Geber und Nehmer zugänglich sind
Route::group(['middleware' => ['api', 'auth.jwt']], function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/bookings', [BookingController::class, 'index']); //alle Nutzer können ihre eigenen bookings erhalten
});


//Routen für Geber
Route::group(['middleware' => ['api', 'auth.jwt', 'role:geber']], function () {
    Route::delete('offers/{id}', [OfferController::class, 'delete']);
    Route::post('/saveOffer', [OfferController::class, 'save']);
    Route::put('/rejectAppointment/{id}', [AppointmentRequestController::class, 'rejectAppointment']);
    Route::put('/acceptAppointment/{id}', [AppointmentRequestController::class, 'acceptAppointment']);
    Route::put('offers/{id}', [OfferController::class, 'update']);
    //wenn optionale Änderungen vorgenommen werden sollen
    //Route::put('/offers/{id}/booked', [OfferController::class, 'changeBookedStatus']);
});

//Routen für Nehmer
Route::group(['middleware' => ['api', 'auth.jwt', 'role:nehmer']], function () {
    Route::post('/newAppointment', [AppointmentRequestController::class, 'makeAppointment']);
    Route::post('/bookings', [BookingController::class, 'makeBooking']); //nur nehmer können buchen

});








