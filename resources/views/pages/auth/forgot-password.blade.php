@extends('layouts.auth')

@section('title', 'Lupa Password')

@section('content')
<div class="flex min-h-screen">

    {{-- LEFT SIDE --}}
    <div class="hidden lg:flex w-1/2 bg-linear-to-br from-indigo-600 to-purple-700 text-white p-12 flex-col justify-between">
        <div class="container">
            <div class="flex items-center gap-3 mb-8">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12">
            </div>

            <h1 class="text-3xl font-bold mb-4">
                Lupa Kata Sandi?
            </h1>

            <p class="text-sm leading-relaxed max-w-md opacity-90">
                Masukkan alamat email yang terdaftar untuk menerima tautan
                reset password Aplikasi PonPes Darul Ulum Kabupaten Grobogan.
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
                Lupa Kata Sandi
            </h2>

            @if (session('status'))
                <div class="bg-green-50 text-green-600 text-sm p-3 rounded mb-6">
                    {{ session('status') }}
                </div>
            @else
                <div class="bg-indigo-50 text-indigo-600 text-sm p-3 rounded mb-6">
                    Masukkan email Anda untuk mendapatkan link reset password.
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none @error('email') border-red-500 @enderror">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg">
                    Kirim Link Reset
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
