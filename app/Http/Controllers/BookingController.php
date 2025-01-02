<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Booking;
use App\Models\Region;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('vehicle')->orderBy('start_date', 'desc')->get();
        $availableVehicles = Vehicle::where('status', 'idle')->get();

        // Ambil data penyetuju
        $approversMine = User::where('role', 'approver')
            ->whereHas('region', fn($q) => $q->where('type', 'mine'))
            ->get();
        $approversBranch = User::where('role', 'approver')
            ->whereHas('region', fn($q) => $q->where('type', 'branch'))
            ->get();
        $approversHeadOffice = User::where('role', 'approver')
            ->whereHas('region', fn($q) => $q->where('type', 'head_office'))
            ->get();

        return view('admin.index', compact('bookings', 'availableVehicles', 'approversMine', 'approversBranch', 'approversHeadOffice'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'driver' => 'required',
            'mine_approver_id' => 'required|exists:users,id',
            'branch_approver_id' => 'required|exists:users,id',
            'head_office_approver_id' => 'required|exists:users,id',
        ]);

        $dataBooking = $request->except(['mine_approver_id', 'branch_approver_id', 'head_office_approver_id']);

        // Buat Booking Baru
        $booking = Booking::create($dataBooking);

        // Panggil ApprovalController untuk membuat data approvals
        app(ApprovalController::class)->storeApprovals($booking->id, [
            ['approver_id' => $request->mine_approver_id, 'level' => 0],
            ['approver_id' => $request->branch_approver_id, 'level' => 1],
            ['approver_id' => $request->head_office_approver_id, 'level' => 2],
        ]);

        // Update status kendaraan menjadi 'booked'
        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle->update(['status' => 'booked']);

        return redirect()->route('admin.index')->with('success', 'Booking berhasil ditambahkan.');
    }

    public function updateBookingStatus(Booking $booking)
    {
        // Cek apakah semua approval untuk booking ini telah selesai
        $approvals = Approval::where('booking_id', $booking->id)->get();

        if ($approvals->every(fn($approval) => $approval->status === 'approved')) {
            $booking->update(['status' => 'approved']);
        } elseif ($approvals->contains('status', 'rejected')) {
            $booking->update(['status' => 'rejected']);
        }
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

        // Hapus approval yang terkait
        $approvals = Approval::find($id);
        if ($approvals) {
            $approvals->delete();
        }

        // Hapus booking
        $booking->delete();

        return redirect()->route('admin.index')->with('success', 'Booking berhasil dihapus.');
    }
}
