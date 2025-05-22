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
        $offers = Offer::with('course', 'giver', 'slots')->get();
        return response()->json($offers, 200);

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
