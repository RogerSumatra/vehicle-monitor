<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run()
    {
        $vehicles = [
            [
                'type' => 'passenger',
                'registration_number' => 'B1234XYZ',
                'last_service_date' => Carbon::now()->addMonths(3),
                'status' => 'booked',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'cargo',
                'registration_number' => 'D5678ABC',
                'last_service_date' => Carbon::now()->addMonths(6),
                'status' => 'idle',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'passenger',
                'registration_number' => 'E9101DEF',
                'last_service_date' => Carbon::now()->subMonths(7),
                'status' => 'booked',
                'created_at' => Carbon::now()->subMonths(7),
                'updated_at' => Carbon::now()->subMonths(7),
            ],
            [
                'type' => 'cargo',
                'registration_number' => 'B7425PLO',
                'last_service_date' => Carbon::now()->addMonths(1),
                'status' => 'in use',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Vehicle::insert($vehicles);
    }
}