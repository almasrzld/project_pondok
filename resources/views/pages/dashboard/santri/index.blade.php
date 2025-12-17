@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('header-title', 'Data Santri')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-xl shadow p-6">
        <p class="text-sm text-gray-500">Total Santri</p>
        <p class="text-3xl font-bold mt-2">120</p>
    </div>
</div>
@endsection
