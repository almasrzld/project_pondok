@extends('layouts.app')

@section('title','Rapot Saya')

@section('content')
<section class="bg-linear-to-br from-gray-50 to-gray-100">
    <div class="container h-screen py-16 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-8">

            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Rapot Saya
                </h1>
                <p class="text-gray-500 text-sm mt-2">
                    Rekap hasil belajar per semester
                </p>
            </div>

            <div class="mb-8 bg-gray-50 border rounded-xl p-4">
                <p class="text-xs uppercase text-blue-600 mb-2">
                    Data Santri
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm">
                    <p><strong>Nama:</strong> {{ auth()->user()->name }}</p>
                    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                </div>
            </div>

            <div class="mb-6 flex justify-between items-center">
                <form method="GET">
                    <select name="semester_id" onchange="this.form.submit()"
                        class="border rounded-lg px-3 py-2 text-sm">
                        <option value="">Semua Semester</option>
                        @foreach($semester as $s)
                            <option value="{{ $s->id }}"
                                {{ request('semester_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }} {{ $s->tahun_ajaran }}
                            </option>
                        @endforeach
                    </select>
                </form>

                <a href="{{ route('rapot.print', ['semester_id' => request('semester_id')]) }}"
                target="_blank"
                class="inline-flex items-center gap-2 bg-indigo-600 text-white
                        px-4 py-2 rounded-lg text-sm hover:bg-indigo-700">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    Print PDF
                </a>
            </div>

            <div class="rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2">Semester</th>
                            <th>Akademik</th>
                            <th>Akhlak</th>
                            <th>Kehadiran</th>
                            <th>Rata-rata</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($rapot as $r)
                        <tr class="border-b">
                            <td class="p-2 text-center">
                                {{ $r->semester->nama }} {{ $r->semester->tahun_ajaran }}
                            </td>
                            <td class="text-center">{{ $r->predikat_akademik }}</td>
                            <td class="text-center">{{ $r->predikat_akhlak }}</td>
                            <td class="text-center">{{ $r->predikat_kehadiran }}</td>
                            <td class="text-center font-semibold">
                                {{ $r->predikat_akhir }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Rapot belum tersedia
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
@endsection
