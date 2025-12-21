@extends('layouts.app')

@section('title', 'Pembayaran Santri')

@section('content')
<section class="bg-linear-to-br from-gray-50 to-gray-100">
    <div class="container py-12 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Pembayaran Santri
                </h1>
                <p class="text-gray-500 text-sm mt-2">
                    Unggah bukti pembayaran sesuai tagihan
                </p>
            </div>

            <div class="mb-8 bg-gray-50 border rounded-xl p-4">
                <p class="text-xs uppercase text-blue-600 mb-2">
                    Data Akun
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                    <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                </div>
            </div>

            @php
                $pending = $pembayaranList->where('status_pembayaran', 'pending')->count();
                $lunas   = $pembayaranList->where('status_pembayaran', 'lunas')->count();
            @endphp

            @if ($pending > 0)
                <div class="mb-6 bg-yellow-50 border border-yellow-300 text-yellow-800 rounded-xl p-4">
                    <p class="font-semibold">⏳ Menunggu Verifikasi</p>
                    <p class="text-sm mt-1">
                        {{ $pending }} pembayaran sedang menunggu verifikasi admin.
                    </p>
                </div>
            @endif

            @if ($pending === 0 && $lunas > 0)
                <div class="mb-6 bg-green-50 border border-green-300 text-green-800 rounded-xl p-4">
                    <p class="font-semibold">✅ Semua Pembayaran Lunas</p>
                    <p class="text-sm mt-1">
                        Terima kasih, seluruh pembayaran Anda telah diverifikasi.
                    </p>
                </div>
            @endif

            <div class="mb-8 border rounded-xl p-5">
                <h2 class="font-semibold mb-4 border-b pb-2">
                    Informasi Tagihan
                </h2>

                @forelse ($pembayaranList as $item)
                    <div class="mb-4 border rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between">
                            <div>
                                <p class="font-medium">
                                    {{ $item->jenisPembayaran->nama }}
                                </p>
                                <p class="text-sm text-gray-600">
                                    Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                </p>
                            </div>

                            <span class="px-3 py-1 text-xs items-center flex justify-center rounded-full font-semibold
                                {{ $item->status_pembayaran === 'lunas'
                                    ? 'bg-green-100 text-green-700'
                                    : ($item->status_pembayaran === 'pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-gray-100 text-gray-700') }}">
                                {{ ucfirst($item->status_pembayaran) }}
                            </span>
                        </div>

                        <p class="text-xs mt-2 text-gray-500">
                            {{ $item->bukti_pembayaran ? 'Bukti sudah diunggah' : 'Belum ada bukti pembayaran' }}
                        </p>
                    </div>
                @empty
                    <p class="text-sm text-gray-500">
                        Belum ada tagihan
                    </p>
                @endforelse
            </div>

            <div class="mb-8 border rounded-xl p-5 bg-white">
                <h2 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                    Metode Pembayaran
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                    <div class="rounded-lg border bg-gray-50 p-4">
                        <ul class="space-y-1">
                            <li>🏦 <strong>Bank BRI</strong></li>
                            <li>No Rekening: <strong>1234567890</strong></li>
                            <li>Atas Nama:</li>
                            <li><strong>Pondok Pesantren Darul Ulum</strong></li>
                        </ul>
                    </div>

                    <div class="rounded-lg border bg-gray-50 p-4">
                        <ul class="space-y-1">
                            <li>🏦 <strong>Bank Mandiri</strong></li>
                            <li>No Rekening: <strong>1234567890</strong></li>
                            <li>Atas Nama:</li>
                            <li><strong>Pondok Pesantren Darul Ulum</strong></li>
                        </ul>
                    </div>

                    <div class="rounded-lg border bg-gray-50 p-4">
                        <ul class="space-y-1">
                            <li>🏦 <strong>Bank BSI</strong></li>
                            <li>No Rekening: <strong>1234567890</strong></li>
                            <li>Atas Nama:</li>
                            <li><strong>Pondok Pesantren Darul Ulum</strong></li>
                        </ul>
                    </div>

                    <div class="rounded-lg border bg-gray-50 p-4">
                        <ul class="space-y-1">
                            <li>💳 <strong>DANA</strong></li>
                            <li>No: <strong>0812-3456-7890</strong></li>
                            <li>Atas Nama:</li>
                            <li><strong>Pondok Pesantren Darul Ulum</strong></li>
                        </ul>
                    </div>
                </div>
            </div>

            @if ($pembayaranList->where('status_pembayaran', '!=', 'lunas')->count())
                <form action="{{ route('pembayaran.store') }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="space-y-6">
                    @csrf

                    <div>
                        <label class="text-sm font-medium">Pilih Tagihan</label>
                        <select name="pembayaran_id"
                                class="w-full border rounded-lg px-3 py-2 text-sm @error('pembayaran_id') border-red-500 @enderror">
                            <option value="">-- Pilih Tagihan --</option>
                            @foreach ($pembayaranList as $item)
                                @if ($item->status_pembayaran !== 'lunas')
                                    <option value="{{ $item->id }}">
                                        {{ $item->jenisPembayaran->nama }} -
                                        Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('pembayaran_id')" />
                    </div>

                    <div>
                        <label class="text-sm font-medium">Upload Bukti</label>
                        <input type="file"
                               name="bukti_pembayaran"
                               class="w-full border rounded-lg px-3 py-2 @error('bukti_pembayaran') border-red-500 @enderror">
                        <x-input-error :messages="$errors->get('bukti_pembayaran')" />
                    </div>

                    <button class="w-full bg-linear-to-r from-blue-600 to-indigo-600
                                   text-white py-3 rounded-xl font-semibold">
                        Kirim Bukti Pembayaran
                    </button>
                </form>
            @endif

        </div>
    </div>
</section>
@endsection
