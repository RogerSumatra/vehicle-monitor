<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{

    public function index()
    {
        // Logika untuk daftar persetujuan
        $approvals = Approval::with(['booking.vehicle', 'approver.region'])
            ->get()
            ->groupBy('booking_id')
            ->map(function ($group) {
                $booking = $group->first()->booking;
                $statuses = $group->pluck('status', 'level');
                if ($statuses->contains('rejected')) {
                    return null;
                }
                $approval_level = $statuses->search('approved') !== false
                    ? $statuses->keys()->filter(fn ($level) => $statuses[$level] === 'approved')->max()
                    : 0;

                return [
                    'no' => $booking->id,
                    'kendaraan' => $booking->vehicle->registration_number,
                    'nama_pengemudi' => $booking->driver,
                    'penyetuju_level_1' => optional($group->where('level', 1)->first())->approver->name ?? '-',
                    'penyetuju_level_2' => optional($group->where('level', 2)->first())->approver->name ?? '-',
                    'penyetuju_level_3' => optional($group->where('level', 3)->first())->approver->name ?? '-',
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
    
}
