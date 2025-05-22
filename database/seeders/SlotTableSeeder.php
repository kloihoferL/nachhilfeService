<?php

namespace Database\Seeders;

use App\Models\Slot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SlotTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $slot = new Slot();
        $slot->start_time = '2025-05-16 10:00:00';
        $slot->end_time = '2025-05-16 12:00:00';
        $slot->offer_id = 1;
        $slot->save();

        $slot2 = new Slot();
        $slot2->start_time = '2025-05-17 10:00:00';
        $slot2->end_time = '2025-05-17 12:00:00';
        $slot2->offer_id = 1;
        $slot2->save();
    }
}
