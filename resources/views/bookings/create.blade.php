@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Tambah Booking</h1>
    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="vehicle_id" class="form-label">Pilih Kendaraan</label>
            <select name="vehicle_id" id="vehicle_id" class="form-select" required>
                <option value="">-- Pilih Kendaraan --</option>
                @foreach($vehicles as $vehicle)
                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="driver" class="form-label">Nama Driver</label>
            <input type="text" name="driver" id="driver" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="approvers" class="form-label">Pilih Pihak Penyetuju</label>
            <select name="approvers[]" id="approvers" class="form-select" multiple required>
                @foreach($approvers as $approver)
                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                @endforeach
            </select>
            <small class="form-text text-muted">Pilih minimal 2 pihak penyetuju.</small>
        </div>

        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
