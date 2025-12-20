@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')

@section('content')
<section class="space-y-6">

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Pendaftar Baru</p>
            <p class="text-3xl font-bold mt-2">{{ $totalPendaftar }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Total Santri</p>
            <p class="text-3xl font-bold mt-2">{{ $totalSantri }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Santri Aktif</p>
            <p class="text-3xl font-bold mt-2">{{ $totalSantriAktif }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Admin</p>
            <p class="text-3xl font-bold mt-2">{{ $totalAdmin }}</p>
        </div>
    </div>

    <!-- Table / Section -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-semibold mb-4">Santri Terbaru</h2>

        @if($santriTerbaru->isEmpty())
            <p class="text-gray-500 text-sm">Belum ada data santri</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="text-left py-2">Nama</th>
                            <th class="text-left py-2">NISN</th>
                            <th class="text-left py-2">Status</th>
                            <th class="text-left py-2">Tanggal Daftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($santriTerbaru as $santri)
                            <tr class="border-b last:border-0">
                                <td class="py-2 font-medium">
                                    {{ $santri->user->name }}
                                </td>
                                <td class="py-2">
                                    {{ $santri->nisn ?? '-' }}
                                </td>
                                <td class="py-2">
                                    @if($santri->status_pendaftaran === 'verified')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700">
                                            Verified
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700">
                                            Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2 text-gray-500">
                                    {{ $santri->created_at->format('d M Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</section>

@endsection
