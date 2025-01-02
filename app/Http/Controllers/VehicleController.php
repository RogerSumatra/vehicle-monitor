<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\History;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function complete(Request $request, $vehicleId)
    {
        $request->validate([
            'fuel_consumption' => 'required|numeric|min:0',
        ]);

        // Ambil data kendaraan dan booking terkait
        $vehicle = Vehicle::findOrFail($vehicleId);
        $historyData = Booking::join('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
            ->where('vehicles.id', $vehicleId)
            ->where('bookings.status', 'approved')
            ->select('vehicles.id as vehicle_id', 'bookings.driver', 'bookings.start_date', 'bookings.end_date')
            ->first();

        if (!$historyData) {
            return redirect()->back()->with('error', 'Data booking untuk kendaraan ini tidak ditemukan.');
        }

        // Simpan data ke tabel histories
        History::create([
            'vehicle_id' => $historyData->vehicle_id,
            'driver' => $historyData->driver,
            'start_date' => $historyData->start_date,
            'end_date' => $historyData->end_date,
            'fuel_consumption' => $request->fuel_consumption,
        ]);

        // Update status kendaraan menjadi idle
        $vehicle->update(['status' => 'idle']);

        return redirect()->back()->with('success', 'Kendaraan telah ditandai sebagai selesai digunakan.');
    }
}
