@extends('layouts.app')

@section('title', 'Beranda')

@section('content')
<div class="bg-gray-50 min-h-[calc(100vh-80px)]">
    <section class="bg-linear-to-br from-indigo-600 to-purple-700 text-white">
        <div class="container py-16">
            <h1 class="text-3xl md:text-4xl font-bold mb-3">
                Assalamu’alaikum, {{ auth()->user()->name }} 👋
            </h1>

            <p class="text-white/90 max-w-2xl">
                Selamat datang di Sistem Informasi Pondok Pesantren Darul Ulum.
                Silakan lanjutkan aktivitas administrasi Anda melalui menu di bawah ini.
            </p>
        </div>
    </section>

    <section class="container py-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            Akses Cepat
        </h2>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <a href="{{ route('pendaftaran') }}"
               class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
                <h3 class="font-semibold text-lg mb-2">Pendaftaran</h3>
                <p class="text-sm text-gray-600">
                    Isi dan lengkapi formulir pendaftaran santri.
                </p>
            </a>

            <a href="{{ route('profile.index') }}"
               class="bg-white rounded-xl shadow hover:shadow-lg transition p-6">
                <h3 class="font-semibold text-lg mb-2">Profil Saya</h3>
                <p class="text-sm text-gray-600">
                    Kelola data akun dan informasi pribadi.
                </p>
            </a>

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-lg mb-2">Status Akun</h3>
                <p class="text-sm text-gray-600">
                    Akun aktif & siap digunakan.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="font-semibold text-lg mb-2">Informasi</h3>
                <p class="text-sm text-gray-600">
                    Pengumuman dan informasi terbaru pesantren.
                </p>
            </div>

        </div>
    </section>

    <section class="container pb-12">
        <div class="bg-white rounded-xl shadow p-8 flex flex-col md:flex-row gap-6 justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold mb-1">
                    Status Pendaftaran
                </h3>
                <p class="text-gray-600 text-sm">
                    Silakan lengkapi pendaftaran jika belum selesai.
                </p>
            </div>

            <a href="{{ route('pendaftaran') }}"
               class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Lihat Pendaftaran
            </a>
        </div>
    </section>

    <section class="container pb-16">
        <div class="bg-white rounded-xl shadow p-8 flex flex-col md:flex-row gap-6 justify-between items-center">
            <div>
                <h3 class="text-xl font-semibold mb-1">
                    Status Pembayaran
                </h3>
                <p class="text-gray-600 text-sm">
                    Silakan unggah bukti pembayaran jika belum selesai.
                </p>
            </div>

            <a href="{{ route('pembayaran') }}"
               class="bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Lihat Pembayaran
            </a>
        </div>
    </section>

</div>
@endsection
