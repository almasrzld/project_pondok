@extends('layouts.dashboard')

@section('title', 'Edit Rapot')
@section('header-title', 'Edit Rapot')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <form
        action="{{ route('dashboard.rapot.update', $rapot->id) }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Santri</label>
                    <input
                        type="text"
                        class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100"
                        value="{{ $rapot->santri->user->name }} — NISN {{ $rapot->santri->nisn }}"
                        disabled
                    >

                    <input type="hidden" name="santri_id" value="{{ $rapot->santri_id }}">
                <x-input-error :messages="$errors->get('santri_id')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Semester</label>
                <select name="semester_id" 
                        class="w-full border rounded-lg px-4 py-2 text-sm
                        focus:ring focus:ring-indigo-200
                        @error('semester_id') border-red-500 @enderror">
                        <option value="">-- Pilih Semester --</option>
                    @foreach($semester as $s)
                        <option value="{{ $s->id }}"
                            @selected(old('semester_id', $rapot->semester_id) == $s->id)>
                            {{ $s->nama }} {{ $s->tahun_ajaran }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('semester_id')" />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nilai Akademik</label>
                <input
                    type="number"
                    name="nilai_akademik"
                    value="{{ old('nilai_akademik', $rapot->nilai_akademik) }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('nilai_akademik') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('nilai_akademik')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Nilai Akhlak</label>
                <input
                    type="number"
                    name="nilai_akhlak"
                    value="{{ old('nilai_akhlak', $rapot->nilai_akhlak) }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('nilai_akhlak') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('nilai_akhlak')" />
            </div>

            <div>
                <label class="block text-sm font-medium mb-1">Kehadiran (%)</label>
                <input
                    type="number"
                    name="kehadiran"
                    value="{{ old('kehadiran', $rapot->kehadiran) }}"
                    class="w-full border rounded-lg px-4 py-2 text-sm
                        @error('kehadiran') border-red-500 @enderror"
                >
                <x-input-error :messages="$errors->get('kehadiran')" />
            </div>
        </div>

        {{-- CATATAN --}}
        <div>
            <label class="block text-sm font-medium mb-1">Catatan Guru</label>
            <textarea
                name="catatan_guru"
                rows="4"
                class="w-full border rounded-lg px-4 py-2 text-sm
                    @error('catatan_guru') border-red-500 @enderror"
            >{{ old('catatan_guru', $rapot->catatan_guru) }}</textarea>
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
                Update Rapot
            </button>
        </div>
    </form>
</div>
@endsection
