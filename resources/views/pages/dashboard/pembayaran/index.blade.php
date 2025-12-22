@extends('layouts.dashboard')

@section('title', 'Data Pembayaran')
@section('header-title', 'Data Pembayaran')

@section('content')
<div x-data="pembayaranSearch()" x-init="init()" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4 w-full">
            <input
                type="text"
                placeholder="Cari nama santri..."
                class="w-full md:w-1/3 border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                x-model="search"
                @input.debounce.500ms="fetchData"
            />

            <select
                class="w-full md:w-48 border rounded-lg px-4 py-2 text-sm"
                x-model="status"
                @change="fetchData"
            >
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
            </select>
        </div>

        <a
            href="{{ route('dashboard.pembayaran.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap"
        >
            + Tambah Pembayaran
        </a>
    </div>

    <div class="overflow-x-auto" id="pembayaran-table">
        <table class="min-w-full text-sm border-separate border-spacing-y-2">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama Santri</th>
                    <th class="px-4 py-3 text-left">NISN</th>
                    <th class="px-4 py-3 text-left">Pembayaran</th>
                    <th class="px-4 py-3 text-left">Total</th>
                    <th class="px-4 py-3 text-left">Bukti Bayar</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($pembayaran as $item)
                <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">
                    <td class="px-4 py-3">
                        {{ $pembayaran->firstItem() + $loop->index }}
                    </td>

                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $item->santri->user->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->santri->nisn }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $item->jenisPembayaran->nama ?? '-' }} -
                        {{ $item->bulan }} {{ $item->tahun }}
                    </td>

                    <td class="px-4 py-3">
                        Rp {{ number_format($item->jenisPembayaran->harga ?? 0, 0, ',', '.') }}
                    </td>

                    <td class="px-4 py-3">
                        @if ($item->bukti_pembayaran)
                            <a
                                href="{{ route('dashboard.pembayaran.download', $item->id) }}"
                                class="text-indigo-600 hover:text-indigo-800 text-xs font-medium underline"
                            >
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </td>

                    <td class="px-4 py-3">
                        @if($item->status_pembayaran === 'lunas')
                            <span class="bg-green-50 text-green-700 border px-3 py-1 rounded-full text-xs">
                                Lunas
                            </span>
                        @else
                            <span class="bg-yellow-50 text-yellow-700 border px-3 py-1 rounded-full text-xs">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <x-modal title="Detail Pembayaran">
                                <x-slot name="trigger">
                                    <button
                                        @click="open = true"
                                        class="bg-amber-100 text-amber-600 hover:bg-amber-200
                                            px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                    >
                                        Detail
                                    </button>
                                </x-slot>

                                <div class="space-y-3 text-sm text-gray-700">

                                    <p><strong>Nama Santri:</strong> {{ $item->santri->user->name }}</p>
                                    <p><strong>NISN:</strong> {{ $item->santri->nisn }}</p>

                                    <hr>

                                    <p><strong>Jenis Pembayaran:</strong>
                                        {{ $item->jenisPembayaran->nama ?? '-' }}
                                    </p>

                                    <p><strong>Bulan / Tahun:</strong>
                                        {{ $item->bulan }} {{ $item->tahun }}
                                    </p>

                                    <p><strong>Nominal:</strong>
                                        Rp {{ number_format($item->jenisPembayaran->harga ?? 0, 0, ',', '.') }}
                                    </p>

                                    <p>
                                        <strong>Status:</strong>
                                        @if ($item->status_pembayaran === 'lunas')
                                            <span class="px-2 py-1 rounded-full text-xs
                                                bg-green-50 text-green-700 border border-green-200">
                                                Lunas
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded-full text-xs
                                                bg-yellow-50 text-yellow-700 border border-yellow-200">
                                                Pending
                                            </span>
                                        @endif
                                    </p>

                                    <p>
                                        <strong>Batas Bayar:</strong>
                                        {{ $item->tanggal_bayar
                                            ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d M Y H:i')
                                            : '-' }}
                                    </p>

                                    <hr>

                                    <p><strong>Bukti Pembayaran:</strong></p>

                                    @if ($item->bukti_pembayaran)
                                        <a
                                            href="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                            target="_blank"
                                            class="block"
                                        >
                                            <img
                                                src="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                                alt="Bukti Pembayaran"
                                                class="w-full max-h-64 object-contain rounded-lg border"
                                            >
                                        </a>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Klik gambar untuk memperbesar
                                        </p>
                                    @else
                                        <p class="text-gray-400 text-sm">
                                            Bukti pembayaran belum diunggah
                                        </p>
                                    @endif

                                </div>
                            </x-modal>

                            <a
                                href="{{ route('dashboard.pembayaran.edit', $item->id) }}"
                                class="bg-green-100 text-green-700 hover:bg-green-200
                                    px-3 py-1.5 rounded-lg text-xs font-medium transition"
                            >
                                Edit
                            </a>

                            <x-modal title="Hapus Pembayaran">
                                <x-slot name="trigger">
                                    <button
                                        @click="open = true"
                                        class="bg-red-100 text-red-700 hover:bg-red-200
                                            px-3 py-1.5 rounded-lg text-xs font-medium"
                                    >
                                        Hapus
                                    </button>
                                </x-slot>

                                <p class="text-sm mb-4">
                                    Yakin ingin menghapus pembayaran
                                    <strong>{{ $item->santri->user->name }}</strong>
                                    untuk
                                    <strong>{{ $item->jenisPembayaran->nama ?? '-' }}</strong>
                                    ({{ $item->bulan }} {{ $item->tahun }})?
                                </p>

                                <form
                                    action="{{ route('dashboard.pembayaran.destroy', $item->id) }}"
                                    method="POST"
                                    class="flex justify-end gap-2"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-4 py-2 text-sm rounded bg-gray-100"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="px-4 py-2 text-sm rounded bg-red-600 text-white"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </x-modal>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-8 text-gray-500">
                        Belum ada data pembayaran
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $pembayaran->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection