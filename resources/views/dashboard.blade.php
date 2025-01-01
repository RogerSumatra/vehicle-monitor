<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Total Kendaraan</h5>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalVehicles }}</h3>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Kendaraan Aktif</h5>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $activeVehicles }}</h3>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Kendaraan Dipesan</h5>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $bookedVehicles }}</h3>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Kendaraan Idle</h5>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $idleVehicles }}</h3>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Kendaraan dalam Servis</h5>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $vehiclesInService }}</h3>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Pemakaian Kendaraan</h5>
                        <canvas id="vehicleUsageChart"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h5 class="font-semibold text-gray-700 dark:text-gray-200">Konsumsi BBM</h5>
                        <canvas id="fuelConsumptionChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Service Schedule Table -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Jadwal Servis Kendaraan</h5>
                    <table class="table-auto w-full text-left text-gray-700 dark:text-gray-200">
                        <thead class="border-b border-gray-300 dark:border-gray-700">
                            <tr>
                                <th class="px-4 py-2">Nomor Registrasi</th>
                                <th class="px-4 py-2">Tanggal Terakhir Servis</th>
                                <th class="px-4 py-2">Jadwal Servis Berikutnya</th>
                                <th class="px-4 py-2">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($serviceSchedules as $schedule)
                                <tr>
                                    <td>{{ $schedule['registration_number'] }}</td>
                                    <td>{{ $schedule['last_service_date'] }}</td>
                                    <td>{{ $schedule['next_service_date'] }}</td>
                                    <td>{{ $schedule['status'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Vehicle Usage Chart
        const vehicleUsageCtx = document.getElementById('vehicleUsageChart').getContext('2d');
        new Chart(vehicleUsageCtx, {
            type: 'bar',
            data: {
                labels: @json($vehicleUsageLabels),
                datasets: [{
                    label: 'Pemakaian Kendaraan',
                    data: @json($vehicleUsageData),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            }
        });

        // Fuel Consumption Chart
        const fuelConsumptionCtx = document.getElementById('fuelConsumptionChart').getContext('2d');
        new Chart(fuelConsumptionCtx, {
            type: 'line',
            data: {
                labels: @json($fuelConsumptionLabels),
                datasets: [{
                    label: 'Konsumsi BBM (Liter)',
                    data: @json($fuelConsumptionData),
                    borderColor: 'rgba(255, 99, 132, 0.8)',
                    backgroundColor: 'rgba(255, 99, 132, 0.4)',
                    fill: true
                }]
            }
        });
    </script>
</x-app-layout>
