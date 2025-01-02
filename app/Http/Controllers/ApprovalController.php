<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BookingController;
use App\Models\Approval;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{

    public function approvalsInfo()
    {
        // Logika untuk daftar persetujuan
        $approvals = Approval::with(['booking.vehicle', 'approver.region'])
            ->get()
            ->groupBy('booking_id')
            ->map(function ($group) {
                $booking = $group->first()->booking;
                // Ambil status persetujuan berdasarkan level
                $statuses = $group->pluck('status', 'level');

                // Jika ada status "rejected", set booking menjadi null (abaikan data ini)
                if ($statuses->contains('rejected')) {
                    return null;
                }

                // Hitung level persetujuan tertinggi (jumlah level dengan status approved)
                $approval_level = $statuses->filter(fn($status) => $status === 'approved')->count();

                return [
                    'no' => $booking->id,
                    'kendaraan' => $booking->vehicle->registration_number,
                    'nama_pengemudi' => $booking->driver,
                    'penyetuju_level_1' => optional($group->where('level', 0)->first())->approver->name ?? '-',
                    'penyetuju_level_2' => optional($group->where('level', 1)->first())->approver->name ?? '-',
                    'penyetuju_level_3' => optional($group->where('level', 2)->first())->approver->name ?? '-',
                    'status_persetujuan' => $approval_level,
                ];
            })
            ->filter()
            ->values();

        // Logika untuk kendaraan yang sedang digunakan
        $vehiclesInUse = Vehicle::join('bookings', 'vehicles.id', '=', 'bookings.vehicle_id')
            ->where('vehicles.status', 'in use')
            ->select('vehicles.id', 'vehicles.registration_number', 'bookings.driver', 'bookings.start_date', 'bookings.end_date')
            ->get();

        return view('admin.management', compact('approvals', 'vehiclesInUse'));
    }
    public function storeApprovals($bookingId, array $approvers)
    {
        foreach ($approvers as $approver) {
            Approval::create([
                'booking_id' => $bookingId,
                'approver_id' => $approver['approver_id'],
                'level' => $approver['level'],
                'status' => 'pending',
            ]);
        }
    }
    
    public function approvalIndex()
    {
        $user = auth()->user();
        $regionType = $user->region->type;

        // Tentukan level berdasarkan tipe region
        $level = match ($regionType) {
            'mine' => 0,
            'branch' => 1,
            'head_office' => 2,
            default => null,
        };

        if ($level === null) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Ambil data approvals sesuai level
        $approvals = Approval::with(['booking.vehicle'])
            ->where('approver_id', $user->id) // Cek approver_id sesuai user login
            ->where('level', $level)
            ->where('status', 'pending')
            ->get()
            ->filter(function ($approval) {
                // Filter: hanya tampilkan jika level sebelumnya sudah approved
                $previousApproval = Approval::where('booking_id', $approval->booking_id)
                    ->where('level', $approval->level - 1)
                    ->first();

                return !$previousApproval || $previousApproval->status === 'approved';
            })
            ->values();

        return view('approver.approvals', compact('approvals'));
    }
    
    public function updateApproval(Request $request, Approval $approval)
    {
        $request->validate( [
            'action' => 'required|in:approved,rejected',
        ]);

        $action = $request->input('action');

        // Update status approval terkait
        $approval->update(['status' => $action]);

        if ($action === 'rejected') {
            // Ubah status approval terkait yang masih pending menjadi rejected
            Approval::where('booking_id', $approval->booking_id)
                ->where('status', 'pending')
                ->update(['status' => 'rejected']);

            // Ubah status booking menjadi rejected
            $booking = Booking::find($approval->booking_id);
            $booking->update(['status' => 'rejected']);

            // Ubah status kendaraan bookde menjadi idle
            $vehicle = Vehicle::find($booking->vehicle_id);
            if ($vehicle) {
                $vehicle->update(['status' => 'idle']);
            }

        } elseif ($action === 'approved') {
            // Cek apakah semua approval telah selesai
            $booking = Booking::find($approval->booking_id);
            app(BookingController::class)->updateBookingStatus($booking);
        }

        return redirect()->route('approver.approvals.index')->with('success', 'Approval berhasil diperbarui.');
    }
}
