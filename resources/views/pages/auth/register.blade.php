@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="flex min-h-screen">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex w-1/2 bg-linear-to-br from-indigo-600 to-purple-700 text-white p-12 flex-col justify-between">
        <div class="container">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
            </div>

            <h1 class="text-3xl font-bold mb-4">
                Pendaftaran Akun PonPes Darul Ulum
            </h1>

            <h2 class="text-lg mb-4">
                Pemerintah Kab. Grobogan
            </h2>

            <p class="text-sm leading-relaxed max-w-md opacity-90">
                Silakan lengkapi data diri untuk membuat akun dan melanjutkan
                proses pendaftaran Pondok Pesantren Darul Ulum.
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
                Daftar Calon Santri
            </h2>

            <div class="bg-indigo-50 text-indigo-600 text-sm p-3 rounded mb-6">
                Lengkapi form di bawah untuk membuat akun baru
            </div>

            <form method="POST" action="{{ route('register.process') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none @error('name') border-red-500 @enderror">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none @error('email') border-red-500 @enderror">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <x-input-password name="password" label="Password" />

                <x-input-password
                    name="password_confirmation"
                    label="Konfirmasi Password"
                    placeholder="Konfirmasi Password"
                />

                <div class="flex items-center justify-between pt-4">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-sm text-indigo-600 hover:underline cursor-pointer">
                        Login
                    </a>
                    </p>

                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg">
                        Daftar
                    </button>
                </div>
            </form>

        </div>
    </div>

</div>
@endsection
