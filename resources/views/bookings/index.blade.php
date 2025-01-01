@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Booking</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Tambah Booking</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Kendaraan</th>
                <th>Driver</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->id }}</td>
                    <td>{{ $booking->vehicle->registration_number }}</td>
                    <td>{{ $booking->driver }}</td>
                    <td>
                        <span class="badge {{ $booking->status === 'pending' ? 'bg-warning' : ($booking->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
