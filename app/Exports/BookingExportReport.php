<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingExportReport implements FromQuery, WithHeadings, WithMapping
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    // Query data booking berdasarkan periode
    public function query()
    {
        return Booking::query()
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->with(['approvals.approver', 'vehicle'])
            ->select('id', 'vehicle_id', 'driver', 'start_date', 'end_date', 'status');
    }

    // Headings untuk Excel
    public function headings(): array
    {
        return [
            'ID',
            'Vehicle Number',
            'Driver',
            'Start Date',
            'End Date',
            'Status',
            'Mine Approver',
            'Branch Approver',
            'Head Office Approver',
        ];
    }

    // Mapping data untuk setiap baris
    public function map($booking): array
    {
        // Ambil nama approver dari approvals
        $mineApprover = $booking->approvals->where('level', 0)->first()?->approver->name ?? 'N/A';
        $branchApprover = $booking->approvals->where('level', 1)->first()?->approver->name ?? 'N/A';
        $headOfficeApprover = $booking->approvals->where('level', 2)->first()?->approver->name ?? 'N/A';

        $vehicleNumber = $booking->vehicle?->registration_number ?? 'N/A';

        return [
            $booking->id,
            $vehicleNumber,
            $booking->driver,
            $booking->start_date,
            $booking->end_date,
            $booking->status,
            $mineApprover,
            $branchApprover,
            $headOfficeApprover,
        ];
    }
}
