@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Daftar Persetujuan</h1>
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
            @foreach($approvals as $approval)
                <tr>
                    <td>{{ $approval->id }}</td>
                    <td>{{ $approval->booking->vehicle->registration_number }}</td>
                    <td>{{ $approval->booking->driver }}</td>
                    <td>
                        <span class="badge {{ $approval->status === 'pending' ? 'bg-warning' : ($approval->status === 'approved' ? 'bg-success' : 'bg-danger') }}">
                            {{ ucfirst($approval->status) }}
                        </span>
                    </td>
                    <td>
                        @if($approval->status === 'pending')
                            <form action="{{ route('approvals.update', $approval) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button name="status" value="approved" class="btn btn-success btn-sm">Setujui</button>
                                <button name="status" value="rejected" class="btn btn-danger btn-sm">Tolak</button>
                            </form>
                        @else
                            <span class="text-muted">Sudah diproses</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
