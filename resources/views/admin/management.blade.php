<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Vehicle Management') }}
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

            <!-- Data Persetujuan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Daftar Proses Persetujuan</h5>
                    <table class="table-auto w-full text-left text-gray-700 dark:text-gray-200">
                        <thead class="border-b border-gray-300 dark:border-gray-700">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kendaraan</th>
                                <th class="border px-4 py-2">Nama Pengemudi</th>
                                <th class="border px-4 py-2">Penyetuju Level 1</th>
                                <th class="border px-4 py-2">Penyetuju Level 2</th>
                                <th class="border px-4 py-2">Penyetuju Level 3</th>
                                <th class="border px-4 py-2">Status Persetujuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($approvals as $approval)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $approval['kendaraan'] }}</td>
                                    <td class="border px-4 py-2">{{ $approval['nama_pengemudi'] }}</td>
                                    <td class="border px-4 py-2">{{ $approval['penyetuju_level_1'] }}</td>
                                    <td class="border px-4 py-2">{{ $approval['penyetuju_level_2'] }}</td>
                                    <td class="border px-4 py-2">{{ $approval['penyetuju_level_3'] }}</td>
                                    <td class="border px-4 py-2">{{ $approval['status_persetujuan'] }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Kendaraan yang digunakan -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Kendaraan Yang Sedang Digunakan</h5>
                    <table class="table-auto w-full text-left text-gray-700 dark:text-gray-200">
                        <thead class="border-b border-gray-300 dark:border-gray-700">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kendaraan</th>
                                <th class="border px-4 py-2">Nama Pengemudi</th>
                                <th class="border px-4 py-2">Tanggal Berangkat</th>
                                <th class="border px-4 py-2">Jadwal Selesai</th>
                                <th class="border px-4 py-2">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($vehiclesInUse as $vehicle)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $vehicle->registration_number }}</td>
                                    <td class="border px-4 py-2">{{ $vehicle->driver }}</td>
                                    <td class="border px-4 py-2">{{ $vehicle->start_date }}</td>
                                    <td class="border px-4 py-2">{{ $vehicle->end_date }}</td>
                                    <td class="border px-4 py-2">
                                        <button onclick="toggleFuelInput({{ $vehicle->id }})"
                                            class="border bg-blue-500 text-white px-4 py-2 rounded">
                                            Selesai
                                        </button>
                                        <form id="fuel-form-{{ $vehicle->id }}"
                                            action="{{ route('vehicles.complete', $vehicle->id) }}" method="POST"
                                            class="hidden mt-2">
                                            @csrf
                                            <label class="block text-gray-700 dark:text-gray-200 mb-2">Konsumsi BBM (liter)</label>
                                            <input type="number" name="fuel_consumption"
                                                class="form-input mt-1 block w-full" step="0.1" required>
                                            <button type="submit" class="border bg-green-500 text-white px-4 py-2 rounded mt-2">
                                                Simpan
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">Tidak ada kendaraan yang sedang digunakan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleFuelInput(vehicleId) {
            const form = document.getElementById(`fuel-form-${vehicleId}`);
            form.classList.toggle('hidden');
        }
    </script>

</x-app-layout>