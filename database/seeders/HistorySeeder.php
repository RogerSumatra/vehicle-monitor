<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\History;
use App\Models\Booking;
use Faker\Factory as Faker;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $history = [
            [
                'vehicle_id' => 1,
                'start_date'=> now()->subMonths(3),
                'end_date'=> now()->subMonths(3)->addDays(7),
                'fuel_consumption' => 50,
                'created_at' => now()->subMonths(3)->addDays(7),
                'updated_at' => now()->subMonths(3)->addDays(7),
            ],
            [
                'vehicle_id' => 1,
                'start_date'=> now()->subMonths(3),
                'end_date'=> now()->subMonths(3)->addDays(3),
                'fuel_consumption' => 30,
                'created_at' => now()->subMonths(3)->addDays(3),
                'updated_at' => now()->subMonths(3)->addDays(3),
            ],
            [
                'vehicle_id' => 2,
                'start_date'=> now()->subMonths(4),
                'end_date'=> now()->subMonths(4)->addDays(3),
                'fuel_consumption' => 32,
                'created_at' => now()->subMonths(4)->addDays(3),
                'updated_at' => now()->subMonths(4)->addDays(3),
            ],
            [
                'vehicle_id' => 3,
                'start_date'=> now()->subMonths(4),
                'end_date'=> now()->subMonths(4)->addDays(3),
                'fuel_consumption' => 27,
                'created_at' => now()->subMonths(4)->addDays(3),
                'updated_at' => now()->subMonths(4)->addDays(3),
            ],
            [
                'vehicle_id' => 2,
                'start_date'=> now()->subMonths(5),
                'end_date'=> now()->subMonths(5)->addDays(10),
                'fuel_consumption' => 32,
                'created_at' => now()->subMonths(5)->addDays(10),
                'updated_at' => now()->subMonths(5)->addDays(10),
            ],
        ];

        History::insert($history);
    }
}
