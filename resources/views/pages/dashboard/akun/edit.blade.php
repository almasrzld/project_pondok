@extends('layouts.dashboard')

@section('title', 'Edit Akun')
@section('header-title', 'Edit Akun')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    <form
        action="{{ route('dashboard.akun.update', $akun) }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">
                    Nama
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name', $akun->name) }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('name') border-red-500 @enderror"
                    required
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
                    value="{{ old('email', $akun->email) }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('email') border-red-500 @enderror"
                    required
                >
                <x-input-error :messages="$errors->get('email')" />
            </div>
        </div>

        @if($akun->role === 'admin')
        <div>
            <label class="block text-sm font-medium mb-1">
                Role
            </label>
            <select
                name="role"
                class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 cursor-not-allowed"
                disabled
            >
                <option value="admin" selected>Admin</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">
                Role admin tidak dapat diubah
            </p>

            <input type="hidden" name="role" value="admin">
        </div>
        @endif

        @if($akun->role === 'santri')
            <input type="hidden" name="role" value="santri">
        @endif

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
                Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
