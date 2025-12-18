@extends('layouts.dashboard')

@section('title', 'Data Santri')
@section('header-title', 'Data Santri')

@section('content')
<div 
    x-data="santriSearch()"
    x-init="init()"
>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col md:flex-row gap-3 mb-6">

            <!-- Search -->
            <input
                type="text"
                placeholder="Cari nama / email / NISN..."
                class="w-full md:w-1/3 border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                x-model="search"
                @input.debounce.500ms="fetchData"
            />

            <!-- Filter Status -->
            <select
                class="w-full md:w-48 border rounded-lg px-4 py-2 text-sm"
                x-model="status"
                @change="fetchData"
            >
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>

        </div>

        <div class="overflow-x-auto" id="santri-table">
            <table class="min-w-full text-sm border-separate border-spacing-y-2">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">NISN</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Tanggal Daftar</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($santri as $item)
                    <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">
                        <td class="px-4 py-3">{{ $santri->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $item->user->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ $item->user->email }}
                        </td>
                        <td class="px-4 py-3">{{ $item->nisn }}</td>
                        <td class="px-4 py-3">
                            @if ($item->status_pendaftaran === 'pending')
                                <span class="bg-yellow-50 text-yellow-700 border border-yellow-200 px-3 py-1 rounded-full text-xs font-medium">
                                    Pending
                                </span>
                            @elseif ($item->status_pendaftaran === 'verified')
                                <span class="bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-medium">
                                    Verified
                                </span>
                            @else
                                <span class="bg-red-50 text-red-700 border border-red-200 px-3 py-1 rounded-full text-xs font-medium">
                                    Rejected
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            {{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3 text-center">
                            <div class="inline-flex gap-2">

                                {{-- MODAL DETAIL --}}
                                <x-modal title="Detail Data Santri">

                                    <x-slot name="trigger">
                                        <button
                                            @click="open = true"
                                            class="bg-amber-100 text-amber-600 hover:bg-amber-200 px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                        >
                                            Detail
                                        </button>
                                    </x-slot>

                                    <div class="space-y-2 text-sm text-gray-700">
                                        <p><strong>Nama:</strong> {{ $item->user->name }}</p>
                                        <p><strong>Email:</strong> {{ $item->user->email }}</p>
                                        <p><strong>NISN:</strong> {{ $item->nisn }}</p>
                                        <p><strong>Tempat Lahir:</strong> {{ $item->tempat_lahir }}</p>
                                        <p><strong>Tanggal Lahir:</strong>
                                            {{ \Carbon\Carbon::parse($item->tanggal_lahir)->format('d M Y') }}
                                        </p>
                                        <p><strong>Jenis Kelamin:</strong>
                                            {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </p>
                                        <p><strong>No HP:</strong> {{ $item->no_hp }}</p>
                                        <p><strong>Alamat:</strong> {{ $item->alamat }}</p>

                                        <hr class="my-3">

                                        <p><strong>Nama Wali:</strong> {{ $item->nama_wali }}</p>
                                        <p><strong>No HP Wali:</strong> {{ $item->no_hp_wali }}</p>

                                        <hr class="my-3">

                                        <p>
                                            <strong>Status:</strong>

                                            @if ($item->status_pendaftaran === 'pending')
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                    Pending
                                                </span>

                                            @elseif ($item->status_pendaftaran === 'verified')
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    bg-green-50 text-green-700 border border-green-200">
                                                    Verified
                                                </span>

                                            @elseif ($item->status_pendaftaran === 'rejected')
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    bg-red-50 text-red-700 border border-red-200">
                                                    Rejected
                                                </span>
                                            @endif
                                        </p>

                                        <p>
                                            <strong>Tanggal Daftar:</strong>
                                            {{ \Carbon\Carbon::parse($item->tanggal_daftar)->format('d M Y H:i') }}
                                        </p>
                                    </div>

                                </x-modal>

                                @if ($item->status_pendaftaran === 'pending')

                                    {{-- VERIFIKASI --}}
                                    <form action="{{ route('dashboard.santri.verify', $item->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                        >
                                            Verifikasi
                                        </button>
                                    </form>

                                    {{-- REJECT MODAL --}}
                                    <x-modal title="Konfirmasi Penolakan">

                                        <x-slot name="trigger">
                                            <button
                                                @click="open = true"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                            >
                                                Reject
                                            </button>
                                        </x-slot>

                                        <div class="space-y-4 text-sm text-gray-700">

                                            <p class="text-center">
                                                ⚠️ Apakah kamu yakin ingin <strong>menolak</strong> pendaftaran santri ini?
                                            </p>

                                            <div class="bg-gray-50 border rounded-lg p-3">
                                                <p><strong>Nama:</strong> {{ $item->user->name }}</p>
                                                <p><strong>NISN:</strong> {{ $item->nisn }}</p>
                                            </div>

                                            <div class="flex justify-center gap-3 pt-4">
                                                <button
                                                    type="button"
                                                    @click="open = false"
                                                    class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm"
                                                >
                                                    Batal
                                                </button>

                                                <form action="{{ route('dashboard.santri.reject', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button
                                                        type="submit"
                                                        class="px-4 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white text-sm font-medium"
                                                    >
                                                        Ya, Tolak
                                                    </button>
                                                </form>
                                            </div>

                                        </div>

                                    </x-modal>

                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-500">
                            Belum ada pendaftar
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-6">
                {{ $santri->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
