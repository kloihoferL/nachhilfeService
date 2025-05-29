<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Database\Seeders\OfferTableSeeder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

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
            //checken ob er das löschen darf
            if (Gate::denies('own-offer', $offer)) {
                return response()->json(['message' => 'You do not own this offer.'], 403);
            }else{
                $offer->delete();
                return response()->json(['message' => 'Offer deleted successfully'], 200);
            }
        } else {
            return response()->json(['message' => 'Offer not found'], 404);
        }
    }

    public function save(Request $request): JsonResponse
    {
        $request = $this->parseRequest($request);
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


    public function update(Request $request, string $id): JsonResponse
    {
        $request = $this->parseRequest($request); // optional, je nach Umsetzung

        DB::beginTransaction();

        try {
            $offer = Offer::find($id);
            if (Gate::denies('own-offer', $offer)) {
                return response()->json(['message' => 'You do not own this offer.'], 403);
            }else{
                if (!$offer) {
                    return response()->json(['message' => "Offer with ID $id not found"], 404);
                }

                $offer->update($request->all());
                DB::commit();

                return response()->json($offer, 200);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Updating offer failed: ' . $e->getMessage()], 500);
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



    private function parseRequest(Request $request): Request{
        $date = new \DateTime($request->published);
        $request['published'] = $date->format('Y-m-d H:i:s');
        return $request;
    }

}
