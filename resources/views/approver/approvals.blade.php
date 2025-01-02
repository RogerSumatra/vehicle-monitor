<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Approval Management') }}
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

            <!-- Data Approval -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h5 class="font-semibold text-gray-700 dark:text-gray-200 mb-4">Daftar Approval</h5>
                    <table class="table-auto w-full text-left text-gray-700 dark:text-gray-200">
                        <thead class="border-b border-gray-300 dark:border-gray-700">
                            <tr>
                                <th class="border px-4 py-2">No</th>
                                <th class="border px-4 py-2">Kendaraan</th>
                                <th class="border px-4 py-2">Nama Pengemudi</th>
                                <th class="border px-4 py-2">Level</th>
                                <th class="border px-4 py-2">Status</th>
                                <th class="border px-4 py-2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($approvals as $approval)
                                <tr>
                                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border px-4 py-2">{{ $approval->booking->vehicle->registration_number }}</td>
                                    <td class="border px-4 py-2">{{ $approval->booking->driver }}</td>
                                    <td class="border px-4 py-2">{{ $approval->level }}</td>
                                    <td class="border px-4 py-2">{{ ucfirst($approval->status) }}</td>
                                    <td class="border px-4 py-2">
                                        <form action="{{ route('approver.approvals.update', $approval) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="approved" class="border bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ route('approver.approvals.update', $approval) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" name="action" value="rejected" class="border bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                                                Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">Tidak ada data persetujuan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
