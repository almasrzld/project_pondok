@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header-title', 'Dashboard')

@section('content')
<section class="space-y-6">

    <!-- Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Total Santri</p>
            <p class="text-3xl font-bold mt-2">120</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Santri Aktif</p>
            <p class="text-3xl font-bold mt-2">98</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Pendaftar Baru</p>
            <p class="text-3xl font-bold mt-2">{{ $totalPendaftar }}</p>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <p class="text-sm text-gray-500">Admin</p>
            <p class="text-3xl font-bold mt-2">{{ $totalAdmin }}</p>
        </div>
    </div>

    <!-- Table / Section -->
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="font-semibold mb-4">Santri Terbaru</h2>
        <p class="text-gray-500 text-sm">Belum ada data</p>
    </div>

</section>

@endsection
