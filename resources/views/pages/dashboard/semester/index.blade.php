@extends('layouts.dashboard')

@section('title', 'Semester')
@section('header-title', 'Semester')

@section('content')
<div class="space-y-6">

    {{-- ===== FORM TAMBAH SEMESTER ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-semibold mb-4">Tambah Semester</h2>

        <form
            method="POST"
            action="{{ route('dashboard.semester.store') }}"
            class="flex flex-col gap-4"
        >
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <select
                    name="nama"
                    class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                    required
                >
                    <option value="">Pilih Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>
                </select>

                <input
                    type="text"
                    name="tahun_ajaran"
                    placeholder="Tahun Ajaran (contoh: 2024/2025)"
                    class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                    required
                >

                <label class="flex items-center gap-2 text-sm text-gray-600">
                    <input type="checkbox" name="is_active" class="rounded">
                    Jadikan Aktif
                </label>
            </div>

            <div>
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white
                           px-5 py-2 rounded-lg text-sm font-medium transition w-full md:w-auto"
                >
                    Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- ===== TABEL SEMESTER ===== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700
                        p-4 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 border border-red-200 text-red-700
                        p-4 rounded-xl mb-6 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-separate border-spacing-y-2">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Semester</th>
                        <th class="px-4 py-3 text-left">Tahun Ajaran</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($semester as $item)
                        <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">

                            <td class="px-4 py-3">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-4 py-3 font-medium">
                                {{ $item->nama }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $item->tahun_ajaran }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($item->is_active)
                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                        Aktif
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex gap-2">

                                    {{-- EDIT --}}
                                    <x-modal title="Edit Semester">
                                        <x-slot name="trigger">
                                            <button
                                                @click="open = true"
                                                class="bg-green-100 text-green-600 hover:bg-green-200
                                                    px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                                Edit
                                            </button>
                                        </x-slot>

                                        <form
                                            action="{{ route('dashboard.semester.update', $item->id) }}"
                                            method="POST"
                                            class="space-y-4"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <select
                                                name="nama"
                                                class="w-full border rounded-lg px-4 py-2 text-sm"
                                                required
                                            >
                                                <option value="Ganjil" {{ $item->nama == 'Ganjil' ? 'selected' : '' }}>
                                                    Ganjil
                                                </option>
                                                <option value="Genap" {{ $item->nama == 'Genap' ? 'selected' : '' }}>
                                                    Genap
                                                </option>
                                            </select>

                                            <input
                                                type="text"
                                                name="tahun_ajaran"
                                                value="{{ $item->tahun_ajaran }}"
                                                class="w-full border rounded-lg px-4 py-2 text-sm"
                                                required
                                            >

                                            <label class="flex items-center gap-2 text-sm">
                                                <input type="checkbox" name="is_active"
                                                    {{ $item->is_active ? 'checked' : '' }}>
                                                Jadikan Aktif
                                            </label>

                                            <div class="flex justify-end">
                                                <button
                                                    class="bg-indigo-600 hover:bg-indigo-700
                                                        text-white px-4 py-2 rounded-lg text-sm"
                                                >
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    {{-- HAPUS --}}
                                    <x-modal title="Hapus Semester">
                                        <x-slot name="trigger">
                                            <button
                                                @click="open = true"
                                                class="bg-red-100 text-red-700 hover:bg-red-200
                                                    px-3 py-1.5 rounded-lg text-xs font-medium">
                                                Hapus
                                            </button>
                                        </x-slot>

                                        <p class="text-sm mb-4">
                                            Yakin ingin menghapus semester
                                            <strong>{{ $item->nama }} {{ $item->tahun_ajaran }}</strong>?
                                        </p>

                                        <form
                                            action="{{ route('dashboard.semester.destroy', $item->id) }}"
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

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-10 text-gray-500">
                                Belum ada data semester
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>

</div>
@endsection
