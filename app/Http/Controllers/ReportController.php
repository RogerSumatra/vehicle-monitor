<?php

namespace App\Http\Controllers;

use App\Exports\BookingReportExport;
use app\Exports\BookingExportReport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $validated['start_date'];
        $endDate = $validated['end_date'];

        return Excel::download(new BookingExportReport($startDate, $endDate), 'booking-report.xlsx');
    }
}
