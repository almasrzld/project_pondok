@extends('layouts.dashboard')

@section('title', 'Tambah Rapot')
@section('header-title', 'Tambah Rapot')

@section('content')
<div
    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6"
>
    <form
        action="{{ route('dashboard.rapot.store') }}"
        method="POST"
        class="space-y-6"
    >
        @csrf

        {{-- SANTRI & SEMESTER --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Santri
                </label>
                <select
                    name="santri_id"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('santri_id') border-red-500 @enderror"
                >
                    <option value="">-- Pilih Santri --</option>
                    @foreach ($santri as $item)
                        <option value="{{ $item->id }}" {{ old('santri_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->user->name }} — NISN {{ $item->nisn }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('santri_id')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Semester
                </label>
                <select name="semester_id"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                    focus:ring focus:ring-indigo-200
                    @error('semester_id') border-red-500 @enderror">

                    <option value="">-- Pilih Semester --</option>

                    @foreach($semester as $s)
                        <option value="{{ $s->id }}"
                            @selected(old('semester_id') == $s->id)>
                            {{ $s->nama }} {{ $s->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('semester_id')" />
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div>
                <label class="block text-sm font-medium mb-1">
                    Nilai Akademik
                </label>
                <input
                    type="number"
                    name="nilai_akademik"
                    value="{{ old('nilai_akademik') }}"
                    placeholder="0 - 100"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('nilai_akademik') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('nilai_akademik')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Nilai Akhlak
                </label>
                <input
                    type="number"
                    name="nilai_akhlak"
                    value="{{ old('nilai_akhlak') }}"
                    placeholder="0 - 100"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('nilai_akhlak') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('nilai_akhlak')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">
                    Kehadiran (%)
                </label>
                <input
                    type="number"
                    name="kehadiran"
                    value="{{ old('kehadiran') }}"
                    placeholder="0 - 100"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('kehadiran') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('kehadiran')" />
            </div>

        </div>

        <div>
            <label class="block text-sm font-medium mb-1">
                Catatan Guru
            </label>
            <textarea
                name="catatan_guru"
                rows="4"
                placeholder="Catatan tambahan untuk santri..."
                class="w-full border rounded-lg px-4 py-2 text-sm
                    focus:ring focus:ring-indigo-200
                    @error('catatan_guru') border-red-500 @enderror"
            >{{ old('catatan_guru') }}</textarea>
            <x-input-error :messages="$errors->get('catatan_guru')" />
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a
                href="{{ route('dashboard.rapot.index') }}"
                class="px-4 py-2 border rounded-lg text-sm"
            >
                Batal
            </a>

            <button
                type="submit"
                class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700
                       text-white rounded-lg text-sm font-medium"
            >
                Simpan Rapot
            </button>
        </div>

    </form>
</div>
@endsection
