<?php

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

Route::get('/offers', [OfferController::class, 'index']);
Route::get('offers/{id}', [OfferController::class, 'show']);
Route::delete('offers/{id}', [OfferController::class, 'delete']);
Route::post('/offers', [OfferController::class, 'save']);
Route::put('offers/{id}/booked', [OfferController::class, 'changeBookedStatus']);
Route::put('newAppointment', [AppointmentRequestController::class, 'makeAppointment']);
Route::put('rejectAppointment/{id}', [AppointmentRequestController::class, 'rejectAppointment']);
Route::put('acceptAppointment/{id}', [AppointmentRequestController::class, 'acceptAppointment']);
Route::get('appointmentRequests', [AppointmentRequestController::class, 'getAppointmentRequests']);

