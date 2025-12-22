@extends('layouts.dashboard')

@section('title', 'Jenis Pembayaran')
@section('header-title', 'Jenis Pembayaran')

@section('content')
<div
    x-data="jenisPembayaranSearch()"
    x-init="init()"
>
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <input
                type="text"
                placeholder="Cari jenis pembayaran..."
                class="w-full md:w-64 border rounded-lg px-4 py-2 text-sm
                    focus:ring focus:ring-indigo-200"
                x-model="search"
                @input.debounce.500ms="fetchData"
            />

            <x-modal title="Tambah Jenis Pembayaran">
                <x-slot name="trigger">
                    <button
                        @click="open = true"
                        x-init="@if($errors->any()) open = true @endif"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white
                            px-4 py-2 rounded-lg text-sm font-medium"
                    >
                        + Tambah Jenis
                    </button>
                </x-slot>

                <form
                    action="{{ route('dashboard.jenis-pembayaran.store') }}"
                    method="POST"
                    class="space-y-4"
                >
                    @csrf

                    <div class="space-y-4">
                        <label class="block text-sm font-medium mb-1">
                            Nama Jenis Pembayaran
                        </label>
                        <input
                            type="text"
                            name="nama"
                            class="w-full border rounded-lg px-4 py-2 text-sm
                                focus:ring focus:ring-indigo-200 @error('nama') border-red-500 @enderror"
                            placeholder="Contoh: SPP Bulanan"
                        >
                        <x-input-error :messages="$errors->get('nama')" />

                        <label class="block text-sm font-medium mb-1">
                            Harga
                        </label>
                        <input
                            type="number"
                            name="harga"
                            class="w-full border rounded-lg px-4 py-2 text-sm
                                focus:ring focus:ring-indigo-200 @error('harga') border-red-500 @enderror"
                            placeholder="Contoh: 500000"
                        >
                        <x-input-error :messages="$errors->get('harga')" />
                    </div>

                    <div class="flex justify-end gap-2">
                        <button
                            type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700
                                text-white px-4 py-2 rounded text-sm"
                        >
                            Simpan
                        </button>
                    </div>
                </form>
            </x-modal>
        </div>

        <div class="overflow-x-auto" id="jenis-pembayaran-table">
            <table class="min-w-full text-sm border-separate border-spacing-y-2">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left w-16">No</th>
                        <th class="px-4 py-3 text-left">Nama Jenis Pembayaran</th>
                        <th class="px-4 py-3 text-left">Harga</th>
                        <th class="px-4 py-3 text-center w-32">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($jenisPembayaran as $item)
                        <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">
                            <td class="px-4 py-3">
                                {{ $loop->index + (($jenisPembayaran->currentPage() - 1) * $jenisPembayaran->perPage()) + 1 }}
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->nama }}
                            </td>

                            <td class="px-4 py-3">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </td>

                            <td class="px-4 py-3 flex justify-center gap-2">

                                {{-- MODAL EDIT --}}
                                <x-modal title="Edit Jenis Pembayaran">
                                    <x-slot name="trigger">
                                        <button
                                            @click="open = true"
                                            class="bg-green-100 text-green-600 hover:bg-green-200
                                                px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                        >
                                            Edit
                                        </button>
                                    </x-slot>

                                    <form
                                        action="{{ route('dashboard.jenis-pembayaran.update', $item->id) }}"
                                        method="POST"
                                        class="space-y-4"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="block text-sm font-medium mb-1">
                                                Nama Jenis Pembayaran
                                            </label>
                                            <input
                                                type="text"
                                                name="nama"
                                                value="{{ $item->nama }}"
                                                class="w-full border rounded-lg px-4 py-2 text-sm
                                                    focus:ring focus:ring-indigo-200 @error('nama') border-red-500 @enderror"
                                            >
                                            <x-input-error :messages="$errors->get('nama')" />
                                            <label class="block text-sm font-medium mb-1">
                                                Harga
                                            </label>
                                            <input
                                                type="number"
                                                name="harga"
                                                value="{{ $item->harga }}"
                                                class="w-full border rounded-lg px-4 py-2 text-sm
                                                    focus:ring focus:ring-indigo-200 @error('harga') border-red-500 @enderror"
                                            >
                                            <x-input-error :messages="$errors->get('harga')" />
                                        </div>

                                        <div class="flex justify-end gap-2">
                                            <button
                                                type="button"
                                                @click="open = false"
                                                class="px-4 py-2 text-sm rounded bg-gray-100 hover:bg-gray-200"
                                            >
                                                Batal
                                            </button>

                                            <button
                                                type="submit"
                                                class="px-4 py-2 text-sm rounded
                                                    bg-indigo-600 hover:bg-indigo-700 text-white"
                                            >
                                                Update
                                            </button>
                                        </div>
                                    </form>
                                </x-modal>

                                <x-modal title="Hapus Jenis Pembayaran">
                                    <x-slot name="trigger">
                                        <button
                                            @click="open = true"
                                            class="bg-red-100 text-red-600 hover:bg-red-200
                                                px-3 py-1.5 rounded-lg text-xs font-medium transition"
                                        >
                                            Hapus
                                        </button>
                                    </x-slot>

                                    <div class="space-y-4">
                                        <p class="text-sm">
                                            Yakin ingin menghapus
                                            <strong>"{{ $item->nama }}"</strong>?
                                        </p>

                                        <form
                                            action="{{ route('dashboard.jenis-pembayaran.destroy', $item->id) }}"
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
                                    </div>
                                </x-modal>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-8 text-gray-500">
                                Belum ada jenis pembayaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-6">
                {{ $jenisPembayaran->links('pagination::tailwind') }}
            </div>
        </div>
    </div>
</div>
@endsection
