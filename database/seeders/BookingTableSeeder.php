<?php

namespace Database\Seeders;

use App\Models\Booking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $booking = new Booking();
        $booking->giver_id = 1;
        $booking->receiver_id = 2;
        $booking->offer_id = 1;
        $booking->slot_id = 1;
        $booking->save();


    }
}
