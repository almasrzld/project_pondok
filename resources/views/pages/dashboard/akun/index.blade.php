@extends('layouts.dashboard')

@section('title', 'Akun')
@section('header-title', 'Manajemen Akun')

@section('content')
<div x-data="akunSearch()" x-init="init()" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <form class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <input
            type="text"
            name="search"
            placeholder="Cari nama / email..."
            class="w-full md:w-1/3 border rounded-lg px-4 py-2 text-sm
                   focus:ring focus:ring-indigo-200"
            x-model="search"
            @input.debounce.500ms="fetchData"
        />

        <a
            href="{{ route('dashboard.akun.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700
                   text-white px-4 py-2 rounded-lg text-sm font-medium"
        >
            + Tambah Akun
        </a>
    </form>

    <div class="overflow-x-auto" id="akun-table">
        <table class="min-w-full text-sm border-separate border-spacing-y-2">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">Role</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($users as $user)
                <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">
                    <td class="px-4 py-3">
                        {{ $users->firstItem() + $loop->index }}
                    </td>

                    <td class="px-4 py-3 font-medium text-gray-800">
                        {{ $user->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $user->email }}
                    </td>

                    <td class="px-4 py-3">
                        @if ($user->role === 'admin')
                            <span class="bg-red-50 text-red-700 border px-3 py-1 rounded-full text-xs">
                                Admin
                            </span>
                        @else
                            <span class="bg-green-50 text-green-700 border px-3 py-1 rounded-full text-xs">
                                Santri
                            </span>
                        @endif
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">

                            <a
                                href="{{ route('dashboard.akun.edit', $user) }}"
                                class="bg-green-100 text-green-700 hover:bg-green-200
                                       px-3 py-1.5 rounded-lg text-xs font-medium"
                            >
                                Edit
                            </a>

                            @if($user->role !== 'admin')
                            <x-modal title="Hapus Akun">
                                <x-slot name="trigger">
                                    <button
                                        @click="open = true"
                                        class="bg-red-100 text-red-700 hover:bg-red-200
                                               px-3 py-1.5 rounded-lg text-xs font-medium"
                                    >
                                        Hapus
                                    </button>
                                </x-slot>

                                <p class="text-sm mb-4">
                                    Yakin ingin menghapus akun
                                    <strong>{{ $user->name }}</strong>
                                    (<strong>{{ $user->email }}</strong>)?
                                </p>

                                <form
                                    action="{{ route('dashboard.akun.destroy', $user) }}"
                                    method="POST"
                                    class="flex justify-end gap-2"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="button"
                                        @click="open = false"
                                        class="px-4 py-2 text-sm rounded bg-gray-100"
                                    >
                                        Batal
                                    </button>

                                    <button
                                        type="submit"
                                        class="px-4 py-2 text-sm rounded bg-red-600 text-white"
                                    >
                                        Hapus
                                    </button>
                                </form>
                            </x-modal>
                            @endif

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        Belum ada data akun
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $users->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
