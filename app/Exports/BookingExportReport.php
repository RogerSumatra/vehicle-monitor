<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingExportReport implements FromQuery, WithHeadings
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
            ->select('id', 'vehicle_id', 'driver', 'start_date', 'end_date', 'status');
    }

    // Headings untuk Excel
    public function headings(): array
    {
        return ['ID', 'Vehicle ID', 'Driver', 'Start Date', 'End Date', 'Status'];
    }
}

