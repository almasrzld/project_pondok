@extends('layouts.dashboard')

@section('title', 'Tambah Akun')
@section('header-title', 'Tambah Akun')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <form
        action="{{ route('dashboard.akun.store') }}"
        method="POST"
        class="space-y-6"
    >
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">
                    Nama
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('name') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('email') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('email')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">
                    Role
                </label>
                <select
                    name="role"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('role') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="santri">Santri</option>
                </select>
                <x-input-error :messages="$errors->get('role')" />
            </div>

            <div>
                <x-input-password-profil
                    name="password"
                    label="Password"
                />
            </div>
        </div>

        <div>
            <x-input-password-profil
                name="password_confirmation"
                label="Konfirmasi Password"
            />
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a
                href="{{ route('dashboard.akun.index') }}"
                class="px-4 py-2 border rounded-lg text-sm"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700
                       text-white rounded-lg text-sm font-medium"
            >
                Simpan Akun
            </button>
        </div>
    </form>
</div>
@endsection
