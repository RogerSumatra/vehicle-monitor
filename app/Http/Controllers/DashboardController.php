<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Data KPI
        $totalVehicles = Vehicle::count();
        $activeVehicles = Vehicle::where('status', 'in use')->count();
        $bookedVehicles = Vehicle::where('status', 'booked')->count();
        $idleVehicles = Vehicle::where('status', 'idle')->count();
        $vehiclesInService = Vehicle::where('status', 'in service')->count();
    
        // Jadwal servis kendaraan
        $vehicles = Vehicle::all();
        $serviceSchedules = $vehicles->map(function ($vehicle) {
            $nextServiceDate = Carbon::parse($vehicle->last_service_date)->addMonths(6);
            $status = now()->greaterThan($nextServiceDate) ? 'Servis Due' : 'Upcoming';
    
            return [
                'registration_number' => $vehicle->registration_number,
                'last_service_date' => $vehicle->last_service_date,
                'next_service_date' => $nextServiceDate->format('Y-m-d'),
                'status' => $status,
            ];
        })->all();
    
        // Konsumsi BBM dari tabel histories
        $fuelConsumption = DB::table('histories')
            ->selectRaw("DATE_FORMAT(end_date, '%Y-%m') as month, SUM(fuel_consumption) as total_fuel")
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
    
        // Konversi data konsumsi BBM untuk chart
        $fuelConsumptionLabels = $fuelConsumption->pluck('month')->map(function ($month) {
            return Carbon::parse($month . '-01')->translatedFormat('F Y'); // Format bulan-tahun
        });
        $fuelConsumptionData = $fuelConsumption->pluck('total_fuel');
    
        return view('dashboard', [
            'totalVehicles' => $totalVehicles,
            'activeVehicles' => $activeVehicles,
            'bookedVehicles' => $bookedVehicles,
            'idleVehicles' => $idleVehicles,
            'vehiclesInService' => $vehiclesInService,
            'vehicleUsageLabels' => Vehicle::pluck('registration_number'),
            'vehicleUsageData' => History::selectRaw('count(*) as count')
                                        ->groupBy('vehicle_id')
                                        ->pluck('count'),
            'fuelConsumptionLabels' => $fuelConsumptionLabels,
            'fuelConsumptionData' => $fuelConsumptionData,
            'serviceSchedules' => $serviceSchedules,
        ]);
    } 
}
