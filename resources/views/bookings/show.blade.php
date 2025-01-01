@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Detail Booking</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Informasi Booking</h5>
            <p><strong>Kendaraan:</strong> {{ $booking->vehicle->registration_number }}</p>
            <p><strong>Driver:</strong> {{ $booking->driver }}</p>
            <p><strong>Status:</strong> 
                <span class="badge {{ $booking->status === 'pending' ? 'bg-warning' : ($booking->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
        </div>
    </div>

    <h5 class="mt-4">Penyetuju</h5>
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Level</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->approvals as $approval)
                <tr>
                    <td>{{ $approval->id }}</td>
                    <td>{{ $approval->approver->name }}</td>
                    <td>{{ $approval->level }}</td>
                    <td>
                        <span class="badge {{ $approval->status === 'pending' ? 'bg-warning' : ($approval->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                            {{ ucfirst($approval->status) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
