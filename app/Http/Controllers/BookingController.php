<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        // Mengambil semua data booking
        $bookings = Booking::with('vehicle')->orderBy('start_date', 'desc')->get();
        $availableVehicles = Vehicle::where('status', 'idle')->get();

        return view('bookings.index', compact('bookings', 'availableVehicles', ));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'driver' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            
        ]);

        // Menambahkan booking baru
        Booking::create($request->all());

        // Update status kendaraan
        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle->update(['status' => 'booked']);

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function destroy($id)
{
    // Cari booking berdasarkan ID
    $booking = Booking::findOrFail($id);

    // Ubah status kendaraan menjadi idle
    $vehicle = Vehicle::find($booking->vehicle_id);
    if ($vehicle) {
        $vehicle->update(['status' => 'idle']);
    }

    // Hapus booking
    $booking->delete();

    return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus.');
}
}
