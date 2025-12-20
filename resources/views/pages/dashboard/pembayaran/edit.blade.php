@extends('layouts.dashboard')

@section('title', 'Edit Pembayaran')
@section('header-title', 'Edit Pembayaran')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    <form
        action="{{ route('dashboard.pembayaran.update', $pembayaran->id) }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Santri</label>
                <input
                    type="text"
                    value="{{ $pembayaran->santri->user->name }}"
                    disabled
                    class="w-full border rounded-lg px-4 py-2 bg-gray-100 text-sm"
                >
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Jenis Pembayaran</label>
                <select
                    name="jenis_pembayaran_id"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200 @error('jenis_pembayaran_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Jenis Pembayaran --</option>
                    @foreach($jenisPembayaran as $jenis)
                        <option
                            value="{{ $jenis->id }}"
                            @selected($pembayaran->jenis_pembayaran_id == $jenis->id)
                        >
                            {{ $jenis->nama }} - Rp {{ number_format($jenis->harga,0,',','.') }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jenis_pembayaran_id')" />
            </div>

            {{-- BULAN & TAHUN --}}
                <div>
                    <label class="block text-sm font-medium mb-1">Bulan</label>
                    <input
                        type="text"
                        name="bulan"
                        value="{{ old('bulan', $pembayaran->bulan) }}"
                        class="w-full border rounded-lg px-4 py-2 text-sm
                            focus:ring focus:ring-indigo-200 @error('bulan') border-red-500 @enderror"
                    >
                    <x-input-error :messages="$errors->get('bulan')" />
                </div>

                <div>
                    <label class="block text-sm font-medium mb-1">Tahun</label>
                    <input
                        type="text"
                        name="tahun"
                        value="{{ old('tahun', $pembayaran->tahun) }}"
                        class="w-full border rounded-lg px-4 py-2 text-sm
                            focus:ring focus:ring-indigo-200 @error('tahun') border-red-500 @enderror"
                    >
                    <x-input-error :messages="$errors->get('tahun')" />
                </div>

            {{-- TANGGAL BAYAR --}}
            <div>
                <label class="block text-sm font-medium mb-1">Tanggal Bayar</label>
                <input
                    type="date"
                    name="tanggal_bayar"
                    value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('Y-m-d') : '') }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200 @error('tanggal_bayar') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('tanggal_bayar')" />
            </div>

            {{-- STATUS --}}
            <div>
                <label class="block text-sm font-medium mb-1">Status Pembayaran</label>
                <select
                    name="status_pembayaran"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200"
                >
                    <option value="pending" @selected($pembayaran->status_pembayaran == 'pending')>
                        Pending
                    </option>
                    <option value="lunas" @selected($pembayaran->status_pembayaran == 'lunas')>
                        Lunas
                    </option>
                </select>
            </div>
        </div>

        {{-- ACTION --}}
        <div class="flex justify-end gap-3">
            <a
                href="{{ route('dashboard.pembayaran.index') }}"
                class="px-4 py-2 rounded-lg text-sm bg-gray-100 hover:bg-gray-200"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-4 py-2 rounded-lg text-sm bg-indigo-600 hover:bg-indigo-700 text-white"
            >
                Update Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection
