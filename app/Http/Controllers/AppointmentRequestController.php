<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentRequestController extends Controller
{

    public function makeAppointment(Request $request): JsonResponse
    {
        $request = $this->parseRequest($request);
        DB::beginTransaction();
        try {
            $appointment = AppointmentRequest::create($request->all());
            DB::commit();
            return response()->json($appointment, 201);
        } catch (\Exception $e) {
            DB::rollBack(); //wenn ein Fehler auftritt, dann rollback
            return response()->json(['message' => 'Creating Appointment failed: ' . $e->getMessage()], 500);
        }
    }

    public function getAppointmentRequests()
    {
        $appointments = AppointmentRequest::with(['offer', 'sender', 'receiver'])->get();
        return response()->json(['data' => $appointments], 200);
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

    private function parseRequest(Request $request): Request{
        $date = new \DateTime($request->requested_time);
        $request['requested_time'] = $date->format('Y-m-d H:i:s');
        return $request;
    }

}
