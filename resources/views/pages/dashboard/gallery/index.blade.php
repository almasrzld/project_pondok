@extends('layouts.dashboard')

@section('title', 'Galeri')
@section('header-title', 'Galeri')

@section('content')
<div class="space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <h2 class="text-lg font-semibold mb-4">Tambah Galeri</h2>

        <form
            method="POST"
            action="{{ route('dashboard.gallery.store') }}"
            enctype="multipart/form-data"
            class="grid grid-cols-1 md:grid-cols-3 gap-4"
        >
            @csrf

            <input
                type="text"
                name="title"
                placeholder="Judul"
                class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                required
            >

            <input
                type="text"
                name="category"
                placeholder="Kategori (opsional)"
                class="border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
            >

            <input
                type="file"
                name="image"
                accept="image/*"
                class="border rounded-lg px-4 py-2 text-sm"
                required
            >

            <div class="md:col-span-3">
                <button
                    class="bg-indigo-600 hover:bg-indigo-700 text-white
                           px-5 py-2 rounded-lg text-sm font-medium transition"
                >
                    Upload
                </button>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700
                        p-4 rounded-xl mb-6 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border-separate border-spacing-y-2">

                <thead class="bg-gray-50 text-gray-600 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Preview</th>
                        <th class="px-4 py-3 text-left">Judul</th>
                        <th class="px-4 py-3 text-left">Kategori</th>
                        <th class="px-4 py-3 text-left">Tanggal</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($galleries as $item)
                        <tr class="bg-white shadow-sm rounded-xl hover:shadow-md transition">

                            <td class="px-4 py-3">
                                {{ $loop->index + (($galleries->currentPage() - 1) * $galleries->perPage()) + 1 }}
                            </td>

                            <td class="px-4 py-3">
                                <img
                                    src="{{ asset('storage/' . $item->image) }}"
                                    class="h-14 w-20 object-cover rounded-lg border"
                                >
                            </td>

                            <td class="px-4 py-3 font-medium text-gray-800">
                                {{ $item->title }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->category ?? '-' }}
                            </td>

                            <td class="px-4 py-3 text-gray-600">
                                {{ $item->created_at->format('d M Y') }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <div class="inline-flex gap-2">

                                    <x-modal title="Edit Galeri">

                                        <x-slot name="trigger">
                                            <button
                                                @click="open = true"
                                                class="bg-green-100 text-green-600 hover:bg-green-200
                                                    px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                                Edit
                                            </button>
                                        </x-slot>

                                        <form
                                            action="{{ route('dashboard.gallery.update', $item->id) }}"
                                            method="POST"
                                            enctype="multipart/form-data"
                                            class="space-y-4"
                                        >
                                            @csrf
                                            @method('PUT')

                                            <div>
                                                <label class="text-sm text-gray-600">Foto Saat Ini</label>
                                                <img
                                                    src="{{ asset('storage/' . $item->image) }}"
                                                    loading="lazy"
                                                    class="h-32 w-full object-cover rounded-lg border mt-2"
                                                >
                                            </div>

                                            <input
                                                type="text"
                                                name="title"
                                                value="{{ $item->title }}"
                                                class="w-full border rounded-lg px-4 py-2 text-sm"
                                                required
                                            >

                                            <input
                                                type="text"
                                                name="category"
                                                value="{{ $item->category }}"
                                                class="w-full border rounded-lg px-4 py-2 text-sm"
                                            >

                                            <input
                                                type="file"
                                                name="image"
                                                accept="image/*"
                                                class="w-full border rounded-lg px-4 py-2 text-sm"
                                            >

                                            <p class="text-xs text-gray-500">
                                                Kosongkan jika tidak ingin mengganti foto
                                            </p>

                                            <div class="flex justify-end gap-2 pt-2">
                                                <button
                                                    type="submit"
                                                    class="bg-indigo-600 hover:bg-indigo-700
                                                        text-white px-4 py-2 rounded-lg text-sm"
                                                >
                                                    Simpan
                                                </button>
                                            </div>
                                        </form>
                                    </x-modal>

                                    <x-modal title="Hapus Galeri">
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
                                            Yakin ingin menghapus galeri
                                            <strong>{{ $item->title }}</strong>?
                                        </p>

                                        <form
                                            action="{{ route('dashboard.gallery.destroy', $item->id) }}"
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
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                Belum ada galeri
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-6">
                {{ $galleries->links('pagination::tailwind') }}
            </div>
        </div>
    </div>

</div>
@endsection
