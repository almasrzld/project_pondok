@extends('layouts.app')

@section('title', 'Selamat Datang!')

@section('content')
<div class="bg-white">
    <section id="hero"
    class="min-h-[calc(100vh-80px)] bg-linear-to-br from-indigo-600 to-purple-700 text-white flex items-center"
>
    <div class="container grid grid-cols-1 md:grid-cols-2 gap-12 items-center py-16">

        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                Sistem Informasi Administrasi <br>
                PonPes Darul Ulum
            </h1>

            <p class="max-w-xl text-lg text-white/90 mb-8">
                Platform digital resmi untuk mendukung proses pendaftaran,
                pendataan, dan administrasi santri secara transparan dan terintegrasi.
            </p>

            <div class="flex flex-wrap gap-4">
                <a href="{{ route('login') }}"
                   class="bg-white text-indigo-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Login
                </a>

                <a href="{{ route('register') }}"
                   class="border border-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-indigo-700 transition">
                    Daftar Akun
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end">
            <img
                src="{{ asset('images/hero.png') }}"
                alt="Ilustrasi Sistem Informasi"
                class="w-full max-w-md md:max-w-lg drop-shadow-xl"
            >
        </div>

    </div>
</section>


    <section id="tentang" class="py-16 bg-gray-50">
        <div class="container px-6 grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-800 mb-4">
                    Tentang Darul Ulum
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Pondok Pesantren Darul Ulum merupakan lembaga pendidikan
                    berbasis keislaman yang berkomitmen mencetak generasi
                    berakhlak mulia, berilmu, dan berdaya saing.
                    Sistem ini dikembangkan sebagai bagian dari transformasi
                    digital administrasi pesantren.
                </p>
            </div>

            <div class="bg-white rounded-xl shadow p-8">
                <ul class="space-y-4 text-gray-700">
                    <li>✔ Sistem pendaftaran santri online</li>
                    <li>✔ Pendataan santri terpusat</li>
                    <li>✔ Administrasi terstruktur</li>
                    <li>✔ Akses aman dan transparan</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-16">
        <div class="container px-6">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
                Layanan Sistem
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="border rounded-xl p-6 text-center">
                    <h3 class="font-semibold text-lg mb-2">Pendaftaran Online</h3>
                    <p class="text-sm text-gray-600">
                        Pendaftaran santri baru secara online dan efisien.
                    </p>
                </div>

                <div class="border rounded-xl p-6 text-center">
                    <h3 class="font-semibold text-lg mb-2">Manajemen Data</h3>
                    <p class="text-sm text-gray-600">
                        Pengelolaan data santri yang rapi dan terintegrasi.
                    </p>
                </div>

                <div class="border rounded-xl p-6 text-center">
                    <h3 class="font-semibold text-lg mb-2">Administrasi Digital</h3>
                    <p class="text-sm text-gray-600">
                        Mendukung proses administrasi pesantren berbasis digital.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- VISI MISI --}}
    <section class="py-16 bg-gray-50">
        <div class="container px-6 grid md:grid-cols-2 gap-10">
            <div>
                <h3 class="text-2xl font-bold mb-3">Visi</h3>
                <p class="text-gray-600">
                    Menjadi pesantren unggulan yang berlandaskan nilai keislaman
                    dan teknologi informasi.
                </p>
            </div>

            <div>
                <h3 class="text-2xl font-bold mb-3">Misi</h3>
                <ul class="list-disc pl-5 text-gray-600 space-y-2">
                    <li>Meningkatkan mutu pendidikan santri</li>
                    <li>Mengembangkan sistem administrasi modern</li>
                    <li>Mewujudkan pelayanan yang transparan</li>
                </ul>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="bg-indigo-600 text-white">
        <div class="container px-6 py-16 text-center">
            <h2 class="text-3xl font-bold mb-4">
                Siap Bergabung Bersama Darul Ulum?
            </h2>
            <p class="opacity-90 mb-6">
                Daftarkan diri Anda dan mulai proses pendaftaran santri sekarang.
            </p>
            <a href="{{ route('register') }}"
               class="bg-white text-indigo-700 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100">
                Daftar Sekarang
            </a>
        </div>
    </section>
</div>
@endsection
