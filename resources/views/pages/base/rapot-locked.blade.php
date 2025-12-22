@extends('layouts.app')

@section('title','Rapot Saya')

@section('content')
<section class="min-h-[calc(100vh-80px)] bg-linear-to-br from-gray-50 to-gray-100 flex items-center justify-center">
    <div class="container py-16 px-4">
        <div class="bg-white rounded-2xl shadow-xl px-8 py-14 text-center">
            <div class="flex justify-center mb-4">
                <div class="bg-indigo-100 text-indigo-600 p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-8 h-8"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path fill-rule="evenodd"
                            d="M12 1.5a5.25 5.25 0 00-5.25 5.25V9A3 3 0 004.5 12v6a3 3 0 003 3h9a3 3 0 003-3v-6a3 3 0 00-3-3V6.75A5.25 5.25 0 0012 1.5zm-3.75 7.5V6.75a3.75 3.75 0 117.5 0V9h-7.5z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-semibold mb-3 text-gray-800">
                Rapot Terkunci
            </h2>

            <p class="text-gray-600 text-sm mb-8">
                Rapot hanya dapat diakses jika <strong>SPP Bulanan</strong>
                telah dilunasi.
            </p>

            <a href="{{ route('pembayaran') }}"
               class="inline-block bg-indigo-600 hover:bg-indigo-700
                      text-white px-6 py-3 rounded-xl font-medium">
                Ke Halaman Pembayaran
            </a>

        </div>
    </div>
</section>
@endsection
