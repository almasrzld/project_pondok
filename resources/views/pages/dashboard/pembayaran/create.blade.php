@extends('layouts.dashboard')

@section('title', 'Tambah Pembayaran')
@section('header-title', 'Tambah Pembayaran')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
    x-data="{
        jenis: '',
        harga: '',
        setHarga() {
            const selected = this.$el.querySelector(
                'select[name=jenis_pembayaran_id] option:checked'
            );
            this.harga = selected?.dataset.harga ?? '';
        }
    }"
>
    <form
        action="{{ route('dashboard.pembayaran.store') }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">
                    Santri
                </label>
                <select
                    name="santri_id"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200 @error('santri_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Santri --</option>
                    @foreach ($santris as $santri)
                        <option value="{{ $santri->id }}">
                            {{ $santri->user->name }} — NISN {{ $santri->nisn }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('santri_id')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Jenis Pembayaran
                </label>
                <select
                    name="jenis_pembayaran_id"
                    x-model="jenis"
                    @change="setHarga()"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200 @error('jenis_pembayaran_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Jenis --</option>
                    @foreach ($jenisPembayaran as $jp)
                        <option value="{{ $jp->id }}" data-harga="{{ $jp->harga }}">
                            {{ $jp->nama }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('jenis_pembayaran_id')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Bulan</label>
                <select name="bulan" class="w-full border rounded-lg px-4 py-2 @error('bulan') border-red-500 @enderror">
                    <option value="">-- Pilih Bulan --</option>
                    @foreach([
                        'Januari','Februari','Maret','April','Mei','Juni',
                        'Juli','Agustus','September','Oktober','November','Desember'
                    ] as $bulan)
                        <option value="{{ $bulan }}">{{ $bulan }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('bulan')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Tahun</label>
                <input
                    type="number"
                    name="tahun"
                    value="{{ date('Y') }}"
                    class="w-full border rounded-lg px-4 py-2 @error('tahun') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('tahun')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">
                    Jumlah Pembayaran
                </label>
                <input
                    type="number"
                    name="jumlah"
                    x-model="harga"
                    readonly
                    class="w-full bg-gray-100 border rounded-lg px-4 py-2 @error('jumlah') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('jumlah')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Tanggal Bayar
                </label>
                <input
                    type="date"
                    name="tanggal_bayar"
                    value="{{ date('Y-m-d') }}"
                    class="w-full border rounded-lg px-4 py-2 @error('tanggal_bayar') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('tanggal_bayar')" />
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a
                href="{{ route('dashboard.pembayaran.index') }}"
                class="px-4 py-2 border rounded-lg text-sm"
            >
                Batal
            </a>
            <button
                type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700
                       text-white rounded-lg text-sm font-medium"
            >
                Simpan Pembayaran
            </button>
        </div>
    </form>
</div>
@endsection
