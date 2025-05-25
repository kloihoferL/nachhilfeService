<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Database\Seeders\OfferTableSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{

    public function index(): JsonResponse
    {
        $offers = Offer::with(['course.subcourses', 'giver', 'slots'])->get();
        return response()->json($offers, 200);
    }

    public function show($id): JsonResponse
    {
        $offer = Offer::with(['course.subcourses', 'giver', 'slots'])->find($id);
        if ($offer) {
            return response()->json($offer, 200);
        } else {
            return response()->json(['message' => 'Offer not found'], 404);
        }
    }

    public function delete($id): JsonResponse
    {
        //$offer = Offer::find($id);
        $offer = Offer::where('id', $id)->first();
        if ($offer) {
            //TODO Check if the user has permission to delete the offer
            $offer->delete();
            return response()->json(['message' => 'Offer deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Offer not found'], 404);
        }
    }

    public function save(Request $request): JsonResponse
    {
        $request = $this->parseRequest($request); //request parsen
        DB::beginTransaction();
        try {
            $offer = Offer::create($request->all());
            DB::commit();
            return response()->json($offer, 201);
        } catch (\Exception $e) {
            DB::rollBack(); //wenn ein Fehler auftritt, dann rollback
            return response()->json(['message' => 'Saving offer failed: ' . $e->getMessage()], 500);
        }
    }

    public function changeBookedStatus($id): JsonResponse
    {
        $offer = Offer::find($id);
        if ($offer) {
            $offer->booked = !$offer->booked;
            $offer->save();
            return response()->json($offer, 200);
        } else {
            return response()->json(['message' => 'Offer not found'], 404);
        }
    }









    /*public function save(Request $request):JsonResponse{

        $request = $this->parseRequest($request);

        DB::beginTransaction();
        try {
            $offer = Offer::create

        } catch (\Exception $e) {
            DB::rollBack(); //wenn ein Fehler auftritt, dann rollback
            return response()->json("saving offer failed: " . $e->getMessage(), 500);
        }

    }*/




    private function parseRequest(Request $request): Request{
        $date = new \DateTime($request->published);
        $request['published'] = $date->format('Y-m-d H:i:s');
        return $request;
    }

}
