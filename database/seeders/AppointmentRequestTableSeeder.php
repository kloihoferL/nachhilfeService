<?php

namespace Database\Seeders;

use App\Models\AppointmentRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $appointment = new AppointmentRequest();
        $appointment->offer_id = 1;
        $appointment->sender_id = 2;
        $appointment->receiver_id = 1;
        $appointment->requested_time = '2025-05-16 10:00:00';
        $appointment->save();

    }
}
