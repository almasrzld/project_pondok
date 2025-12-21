@extends('layouts.app')

@section('title', 'Pendaftaran Calon Santri')

@section('content')
<section class="bg-linear-to-br from-gray-50 to-gray-100">
    <div class="container flex items-center justify-center py-12 px-4">
        <div class="w-full bg-white rounded-2xl shadow-xl p-8">

            {{-- HEADER --}}
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Pendaftaran Calon Santri
                </h1>
                <p class="text-gray-500 text-sm mt-2">
                    Silakan lengkapi data dengan benar dan sesuai dokumen resmi
                </p>
            </div>

            {{-- INFO AKUN --}}
            <div class="mb-8 bg-gray-50 border border-indigo-100 rounded-xl p-4">
                <p class="text-xs uppercase tracking-wide text-blue-600 mb-2">
                    Data Akun
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-700">
                    <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                </div>
            </div>

            @php
                $santri = auth()->user()->santriDetail;
            @endphp

            @if ($santri)
                @if ($santri->status_pendaftaran === 'pending')
                    <div class="mb-6 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-xl p-4">
                        <p class="font-semibold">⏳ Berkas sedang diverifikasi</p>
                        <p class="text-sm mt-1">
                            Silakan cek email secara berkala untuk menerima update terbaru.
                        </p>
                    </div>

                @elseif ($santri->status_pendaftaran === 'verified')
                    <div class="mb-6 bg-green-50 border border-green-300 text-green-800 rounded-xl p-4">
                        <p class="font-semibold">✅ Berkas diterima</p>
                        <p class="text-sm mt-1">
                            Silakan lanjutkan ke proses pembayaran untuk menyelesaikan pendaftaran.
                        </p>
                    </div>

                @elseif ($santri->status_pendaftaran === 'rejected')
                    <div class="mb-6 bg-red-50 border border-red-300 text-red-800 rounded-xl p-4">
                        <p class="font-semibold">❌ Berkas ditolak</p>
                        <p class="text-sm mt-1">
                            Silakan perbaiki data dan lakukan pendaftaran ulang.
                        </p>
                    </div>
                @endif
            @endif

            <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-8">
                @csrf
                @php
                    $disableForm = $santri && in_array($santri->status_pendaftaran, ['pending', 'verified']);
                @endphp

                {{-- DATA SANTRI --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        Data Santri
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">NISN</label>
                            <input type="text" name="nisn" value="{{ old('nisn') }}" {{ $disableForm ? 'disabled' : '' }}
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('nisn') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('nisn')" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="{{ old('tempat_lahir') }}"
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('tempat_lahir') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('tempat_lahir')" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('tanggal_lahir') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('tanggal_lahir')" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin"
                                    class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('jenis_kelamin') border-red-500 @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_kelamin')" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No HP</label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('no_hp') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('no_hp')" />
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-600 mb-1">Alamat</label>
                            <textarea name="alamat" rows="3"
                                    class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('alamat') border-red-500 @enderror"></textarea>
                            <x-input-error :messages="$errors->get('alamat')" />
                        </div>
                    </div>
                </div>

                {{-- DATA WALI --}}
                <div>
                    <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                        Data Wali
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Nama Wali</label>
                            <input type="text" name="nama_wali" value="{{ old('nama_wali') }}"
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('nama_wali') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('nama_wali')" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">No HP Wali</label>
                            <input type="text" name="no_hp_wali" value="{{ old('no_hp_wali') }}"
                                class="w-full rounded-lg border focus:border-blue-500 focus:ring-blue-500 px-3 py-2 @error('no_hp_wali') border-red-500 @enderror">
                            <x-input-error :messages="$errors->get('no_hp_wali')" />
                        </div>
                    </div>
                </div>

                {{-- SUBMIT --}}
                <div class="pt-6">
                    @if (!$disableForm)
                        <button type="submit"
                                class="w-full bg-linear-to-r from-blue-600 to-indigo-600
                                    text-white font-semibold py-3 rounded-xl
                                    hover:from-blue-700 hover:to-indigo-700
                                    transition duration-200 shadow-lg">
                            Kirim Pendaftaran
                        </button>
                    @endif
                </div>

            </form>
        </div>
    </div>
</section>
@endsection
