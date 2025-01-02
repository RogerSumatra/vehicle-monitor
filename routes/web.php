<?php


use App\Http\Controllers\BookingController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ApproverMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/export-bookings', [ReportController::class, 'export'])->name('bookings.export');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', AdminMiddleware::class])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('admin.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('admin.store');
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy'])->name('admin.destroy');

    Route::get('/management', [ApprovalController::class, 'approvalsInfo'])->name('admin.management');
    Route::post('/vehicles/{vehicle}/complete', [VehicleController::class, 'complete'])->name('vehicles.complete');

    Route::get('/export-bookings', [ReportController::class, 'export'])->name('bookings.export');

});

Route::middleware(['auth', ApproverMiddleware::class])->group(function () {
    Route::get('/approvals', [ApprovalController::class, 'approvalIndex'])->name('approver.approvals.index');
    Route::put('/approvals/{approval}', [ApprovalController::class, 'updateApproval'])->name('approver.approvals.update');
});

require __DIR__.'/auth.php';
