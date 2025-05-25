<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentRequestController extends Controller
{
    public function makeAppointment(Request $request){
        $appointmentRequest = AppointmentRequest::create($request->all());
        return response()->json(['message' => 'Appointment request created successfully', 'data' => $appointmentRequest], 201);
    }

    public function getAppointmentRequests(){
        $appointmentRequests = AppointmentRequest::all();
        return response()->json(['data' => $appointmentRequests], 200);
    }

    public function acceptAppointment($id){
        $appointmentRequest = AppointmentRequest::find($id);
        if ($appointmentRequest) {
            $appointmentRequest->status = 'accepted';
            $appointmentRequest->save();
            return response()->json(['message' => 'Appointment request accepted successfully'], 200);
        } else {
            return response()->json(['message' => 'Appointment request not found'], 404);
        }
    }

    public function rejectAppointment($id){
        $appointmentRequest = AppointmentRequest::find($id);
        if ($appointmentRequest) {
            $appointmentRequest->status = 'rejected';
            $appointmentRequest->save();
            return response()->json(['message' => 'Appointment request rejected successfully'], 200);
        } else {
            return response()->json(['message' => 'Appointment request not found'], 404);
        }
    }
}
