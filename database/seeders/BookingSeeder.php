<?php

namespace Database\Seeders;


use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $vehicles = Vehicle::all();

        $bookings = [
            [
                'vehicle_id' => $vehicles[0]->id,
                'driver' => 'John Doe',
                'start_date' => now()->addDays(5),
                'end_date' => now()->addDays(10),
                'status' => 'approved',
                'created_at' => now()->addDays(5),
                'updated_at' => now()->addDays(5),
            ],
            [
                'vehicle_id' => $vehicles[2]->id,
                'driver' => 'Billy Man',
                'start_date' => now()->addDays(3),
                'end_date' => now()->addDays(10),
                'status' => 'pending',
                'created_at' => now()->addDays(3),
                'updated_at' => now()->addDays(3),
            ],
        ];

        Booking::insert($bookings);
    }
}
