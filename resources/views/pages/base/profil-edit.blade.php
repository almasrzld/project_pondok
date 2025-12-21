@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<section class="bg-gray-50 py-10">
    <div class="container max-w-xl">

        <div class="bg-white rounded-2xl shadow p-8">

            <h1 class="text-2xl font-bold mb-6">Edit Akun</h1>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-medium">Nama</label>
                    <input type="text" name="name"
                           value="{{ old('name', $user->name) }}"
                           class="w-full border rounded-lg px-3 py-2">
                    <x-input-error :messages="$errors->get('name')" />
                </div>

                <div>
                    <label class="text-sm font-medium">Email</label>
                    <input type="email" name="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full border rounded-lg px-3 py-2">
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <div>
                    <x-input-password-profil
                        name="password"
                        label="Password Baru"
                        hint="(opsional)"
                    />
                </div>

                <div>
                    <x-input-password-profil
                        name="password_confirmation"
                        label="Konfirmasi Password Baru"
                    />
                </div>

                <div class="flex gap-3">
                    <button class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                        Simpan
                    </button>

                    <a href="{{ route('profile.index') }}"
                       class="px-5 py-2 rounded-lg border">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</section>
@endsection
