@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<div class="flex min-h-screen">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex w-1/2 bg-linear-to-br from-indigo-600 to-purple-700 text-white p-12 flex-col justify-between">
        <div class="container">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
            </div>

            <h1 class="text-3xl font-bold mb-4">
                Reset Password Akun Anda
            </h1>

            <p class="text-sm leading-relaxed max-w-md opacity-90">
                Silakan masukkan password baru untuk melanjutkan akses ke Aplikasi
                PonPes Darul Ulum Kabupaten Grobogan.
            </p>
        </div>

        <div class="text-xs opacity-80 container">
            © {{ date('Y') }} Darul Ulum Versi 1.0.0 <br>
            Pondok Pesantren Darul Ulum Kab. Grobogan
        </div>
    </div>

    {{-- RIGHT SIDE --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
        <div class="w-full max-w-md">

            <h2 class="text-2xl font-semibold mb-6 text-gray-800">
                Reset Password
            </h2>

            <div class="bg-indigo-50 text-indigo-600 text-sm p-3 rounded mb-6">
                Masukkan password baru untuk akun Anda.
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <x-input-password
                    name="password"
                    label="Password Baru"
                    placeholder="Password Baru"
                />

                <x-input-password
                    name="password_confirmation"
                    label="Konfirmasi Password"
                    placeholder="Konfirmasi Password"
                />

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg">
                    Reset Password
                </button>

                <p class="text-sm text-gray-600 text-center mt-4">
                    <a href="{{ route('login') }}" class="text-indigo-600 hover:underline">
                        Kembali ke Login
                    </a>
                </p>
            </form>

        </div>
    </div>

</div>
@endsection
