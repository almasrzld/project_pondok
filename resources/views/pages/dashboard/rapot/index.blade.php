@extends('layouts.dashboard')

@section('title','Data Rapot')
@section('header-title','Data Rapot')

@section('content')
<div x-data="rapotSearch('{{ route('dashboard.rapot.print') }}')" x-init="init()" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div class="flex flex-col md:flex-row md:items-center gap-4 w-full">
            <input
                type="text"
                placeholder="Cari nama santri..."
                class="w-full md:w-1/3 border rounded-lg px-4 py-2 text-sm focus:ring focus:ring-indigo-200"
                x-model="search"
                @input.debounce.500ms="fetchData"
            />

            <select
                class="w-full md:w-48 border rounded-lg px-4 py-2 text-sm"
                x-model="semester_id"
                @change="fetchData"
                name="semester_id"
            >
                <option value="">Semua Semester</option>
                @foreach($semester as $s)
                    <option value="{{ $s->id }}">
                        {{ $s->nama }} {{ $s->tahun_ajaran }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-between md:justify-end items-center gap-4">
            <a
                :href="printUrl"
                target="_blank"
                class="inline-flex items-center gap-2 bg-gray-800 text-white
                    px-4 py-2 rounded-lg text-sm hover:bg-gray-900 transition whitespace-nowrap"
            >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>
                Print PDF
            </a>
            <a href="{{ route('dashboard.rapot.create') }}"
            class="inline-flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition whitespace-nowrap">
                + Tambah Rapot
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto" id="rapot-table">
        <table class="min-w-full border-separate border-spacing-y-2 text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">No</th>
                    <th class="px-4 py-3 text-left">Santri</th>
                    <th class="px-4 py-3 text-left">Semester</th>
                    <th class="px-4 py-3">Akademik</th>
                    <th class="px-4 py-3">Akhlak</th>
                    <th class="px-4 py-3">Kehadiran</th>
                    <th class="px-4 py-3">Rata-rata</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($rapot as $item)
                <tr class="bg-white shadow rounded-xl">
                    <td class="px-4 py-3">{{ $rapot->firstItem() + $loop->index }}</td>

                    <td class="px-4 py-3 font-medium">
                        {{ $item->santri->user->name ?? 'Akun Dihapus' }} | {{ $item->santri->nisn ?? '-' }}
                    </td>

                    <td class="px-4 py-3">{{ $item->semester->nama }} {{ $item->semester->tahun_ajaran }}</td>

                    <td class="px-4 py-3 text-center">{{ $item->predikat_akademik }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->predikat_akhlak }}</td>
                    <td class="px-4 py-3 text-center">{{ $item->predikat_kehadiran }}</td>
                    <td class="px-4 py-3 text-center font-semibold">
                        {{ $item->predikat_akhir }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <div class="flex justify-center gap-2">
                            <x-modal title="Detail Rapot">
                                <x-slot name="trigger">
                                    <button
                                        @click="open = true"
                                        class="bg-amber-100 text-amber-600 hover:bg-amber-200
                                            px-3 py-1.5 rounded-lg text-xs font-medium transition">
                                        Detail
                                    </button>
                                </x-slot>

                                <div class="space-y-3 text-sm text-gray-700">
                                    <p><strong>Nama Santri:</strong> {{ $item->santri->user->name ?? 'Akun Dihapus' }}</p>
                                    <p><strong>NISN:</strong> {{ $item->santri->nisn ?? '-' }}</p>

                                    <hr>

                                    <p><strong>Semester:</strong> {{ $item->semester->nama }}</p>
                                    <p><strong>Akademik:</strong>
                                        {{ $item->nilai_akademik }} ({{ $item->predikat_akademik }})
                                    </p>
                                    <p><strong>Akhlak:</strong>
                                        {{ $item->nilai_akhlak }} ({{ $item->predikat_akhlak }})
                                    </p>
                                    <p><strong>Kehadiran:</strong>
                                        {{ $item->kehadiran }}% ({{ $item->predikat_kehadiran }})
                                    </p>
                                    <p><strong>Rata-rata:</strong>
                                        {{ $item->nilai_rata_rata }} ({{ $item->predikat_akhir }})
                                    </p>

                                    <hr>

                                    <p><strong>Catatan Guru:</strong> {{ $item->catatan_guru }}</p>
                                    <p><strong>Tanggal Input:</strong> {{ $item->tanggal_input->format('d M Y H:i') }}</p>
                                </div>
                            </x-modal>

                            <a href="{{ route('dashboard.rapot.edit',$item->id) }}"
                            class="bg-green-100 text-green-600 px-3 py-1.5 rounded-lg text-xs">
                                Edit
                            </a>

                            <x-modal title="Hapus Rapot">
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
                                    Yakin ingin menghapus rapot
                                    <strong>{{ $item->santri->user->name ?? 'Akun Dihapus' }}</strong>
                                    untuk
                                    <strong>{{ $item->semester->nama }} {{ $item->semester->tahun_ajaran }}</strong>?
                                </p>

                                <form
                                    action="{{ route('dashboard.rapot.destroy', $item->id) }}"
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
                    <td colspan="8" class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0
                                    01-2-2V5a2 2 0 012-2h5.586
                                    a1 1 0 01.707.293l5.414 5.414
                                    a1 1 0 01.293.707V19a2 2 0
                                    01-2 2z"/>
                        </svg>
                        <p class="text-lg font-medium">Belum ada data rapot</p>
                        <p class="text-sm mt-1">
                            Klik <strong>Tambah Rapot</strong> untuk menambahkan data pertama
                        </p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-6">
            {{ $rapot->links('pagination::tailwind') }}
        </div>
    </div>
</div>
@endsection
