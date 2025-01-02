<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Booking Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Flash Message -->
            @if (session('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Data Booking -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Daftar Booking</h5>
                    <table class="table-auto w-full text-left text-gray-700 dark:text-gray-200">
                        <thead class="border-b border-gray-300 dark:border-gray-700">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kendaraan</th>
                                <th class="border px-4 py-2">Tanggal Mulai</th>
                                <th class="border px-4 py-2">Tanggal Selesai</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bookings as $booking)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $booking->vehicle->registration_number }}</td>
                                    <td class="border px-4 py-2">{{ $booking->start_date }}</td>
                                    <td class="border px-4 py-2">{{ $booking->end_date }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($booking->status) }}</td>
                                    <td class="border px-4 py-2">
                                        <!-- Form untuk Hapus Booking -->
                                        <form method="POST" action="{{ route('admin.destroy', $booking->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="border bg-red-500 text-white px-4 py-2 rounded"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus booking ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    <!-- Form Download Data -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Download Data Booking</h5>
                            <form method="GET" action="{{ route('bookings.export') }}">
                                <div class="mb-4">
                                    <label for="start_date" class="block text-gray-700 dark:text-gray-200">Tanggal
                                        Mulai</label>
                                    <input type="date" name="start_date" id="start_date"
                                        class="form-input mt-1 block w-full" required>
                                </div>
                                <div class="mb-4">
                                    <label for="end_date" class="block text-gray-700 dark:text-gray-200">Tanggal
                                        Selesai</label>
                                    <input type="date" name="end_date" id="end_date"
                                        class="form-input mt-1 block w-full" required>
                                </div>
                                <button type="submit" class="border bg-green-500 text-white px-4 py-2 rounded">
                                    Download Excel
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Booking -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Tambah Booking</h5>
                    <form method="POST" action="{{ route('admin.store') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Kendaraan</label>
                            <select name="vehicle_id" class="form-select mt-1 block w-full">
                                <option value="" selected disabled hidden>Choose here</option>
                                @foreach ($availableVehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->registration_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-input mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="form-input mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Nama Peminjam</label>
                            <input type="string" name="driver" class="form-input mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Penyetuju - Mine</label>
                            <select name="mine_approver_id" class="form-select mt-1 block w-full">
                                <option value="" selected disabled hidden>Choose approver</option>
                                @foreach ($approversMine as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Penyetuju - Branch</label>
                            <select name="branch_approver_id" class="form-select mt-1 block w-full">
                                <option value="" selected disabled hidden>Choose approver</option>
                                @foreach ($approversBranch as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 dark:text-gray-200">Penyetuju - Head Office</label>
                            <select name="head_office_approver_id" class="form-select mt-1 block w-full">
                                <option value="" selected disabled hidden>Choose approver</option>
                                @foreach ($approversHeadOffice as $approver)
                                    <option value="{{ $approver->id }}">{{ $approver->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="border bg-blue-500 text-white px-4 py-2 rounded">
                            Tambah Booking
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>