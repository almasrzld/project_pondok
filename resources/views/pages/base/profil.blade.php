@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<section class="bg-gray-50 py-10">
    <div class="container max-w-3xl">

        <div class="bg-white rounded-2xl shadow p-8">

            <h1 class="text-2xl font-bold mb-6">Profil Akun</h1>

            {{-- DATA AKUN --}}
            <div class="mb-8">
                <h2 class="font-semibold mb-4 border-b pb-2">Data Akun</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <label class="text-gray-500">Nama</label>
                        <p class="font-medium">{{ $user->name }}</p>
                    </div>

                    <div>
                        <label class="text-gray-500">Email</label>
                        <p class="font-medium">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('profile.edit') }}"
                       class="inline-block bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                        Edit Akun
                    </a>
                </div>
            </div>

            {{-- DATA SANTRI (READ ONLY) --}}
            <div>
                <h2 class="font-semibold mb-4 border-b pb-2">Data Santri</h2>

                @if ($santri)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <label class="text-gray-500">NISN</label>
                            <p class="font-medium">{{ $santri->nisn ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-gray-500">No HP</label>
                            <p class="font-medium">{{ $santri->no_hp ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-gray-500">Tempat Lahir</label>
                            <p class="font-medium">{{ $santri->tempat_lahir ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-gray-500">Tanggal Lahir</label>
                            <p class="font-medium">
                                {{ $santri->tanggal_lahir
                                    ? \Carbon\Carbon::parse($santri->tanggal_lahir)->format('d M Y')
                                    : '-' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-gray-500">Jenis Kelamin</label>
                            <p class="font-medium">
                                {{ $santri->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </p>
                        </div>

                        <div>
                            <label class="text-gray-500">Alamat</label>
                            <p class="font-medium">{{ $santri->alamat ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-gray-500">Nama Wali</label>
                            <p class="font-medium">{{ $santri->nama_wali ?? '-' }}</p>
                        </div>

                        <div>
                            <label class="text-gray-500">No HP Wali</label>
                            <p class="font-medium">{{ $santri->no_hp_wali ?? '-' }}</p>
                        </div>
                    </div>

                    <p class="text-xs text-gray-500 mt-4 italic">
                        Data santri tidak dapat diubah karena berasal dari pendaftaran.
                    </p>
                @else
                    <p class="text-sm text-gray-500">Data santri belum tersedia.</p>
                @endif
            </div>

        </div>
    </div>
</section>
@endsection
