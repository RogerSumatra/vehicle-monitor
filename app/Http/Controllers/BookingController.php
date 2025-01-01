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
        $bookings = Booking::with(['vehicle', 'user'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $approvers = User::where('role', 'approver')->get();
        return view('bookings.create', compact('vehicles', 'approvers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'approvers' => 'required|array|min:2',
        ]);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'vehicle_id' => $request->vehicle_id,
            'status' => 'pending',
        ]);

        foreach ($request->approvers as $index => $approverId) {
            $booking->approvals()->create([
                'approver_id' => $approverId,
                'level' => $index + 1,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully!');
    }

    public function show(Booking $booking)
    {
        $booking->load(['vehicle', 'approvals.approver']);
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::all();
        $approvers = User::where('role', 'approver')->get();
        return view('bookings.edit', compact('booking', 'vehicles', 'approvers'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        $booking->update([
            'vehicle_id' => $request->vehicle_id,
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully!');
    }

    public function approve($id)
    {
        $booking = Booking::find($id);
        $booking->status = 'approved';
        $booking->save();

        $booking->vehicle->update(['status' => 'booked']);
    }
}
