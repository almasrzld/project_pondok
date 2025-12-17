@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="flex min-h-screen">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex w-1/2 bg-linear-to-br from-indigo-600 to-purple-700 text-white p-12 flex-col justify-between">
        <div class="container">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
            </div>

            <h1 class="text-3xl font-bold mb-4">
                Selamat Datang di Aplikasi PonPes Darul Ulum
            </h1>

            <h2 class="text-lg mb-4">
                Pemerintah Kab. Grobogan
            </h2>

            <p class="text-sm leading-relaxed max-w-md opacity-90">
                Darul Ulum App adalah sistem informasi berbasis digital yang digunakan untuk mengelola proses pendaftaran,
                pendataan, dan administrasi santri baru di Kabupaten Grobogan secara terstruktur dan transparan.
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
                Login PonPes Darul Ulum
            </h2>

            <div class="bg-indigo-50 text-indigo-600 text-sm p-3 rounded mb-6">
                Masukan Email dan Password untuk mengakses Aplikasi PonPes Darul Ulum.
            </div>

            <form method="POST" action="{{ route('login.process') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none @error('email') border-red-500 @enderror">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <x-input-password name="password" label="Password" />

                <div class="flex items-center justify-between pt-4">
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:underline">
                        Lupa Kata Sandi
                    </a>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                        Login
                    </button>
                </div>

                <p class="text-sm text-gray-600 mt-6">
                    Belum punya akun? <a href="{{ route('register') }}"
                    class="text-sm text-indigo-600 hover:underline cursor-pointer">
                    Daftar disini
                </a>
                </p>
            </form>

        </div>
    </div>

</div>
@endsection
