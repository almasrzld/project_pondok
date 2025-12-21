@extends('layouts.app')

@section('title', 'Galeri')

@section('content')
<section class="bg-gray-50 py-12">
    <div class="container px-4">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Galeri Kegiatan</h1>
            <p class="text-gray-500 text-sm mt-2">
                Dokumentasi kegiatan santri
            </p>
        </div>

        <div x-data="galleryLoader()" x-init="init()" class="relative">
            <template x-if="loading">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                    <template x-for="i in skeletonCount" :key="i">
                        <div class="animate-pulse">
                            <div class="bg-gray-200 rounded-xl overflow-hidden aspect-4/3"></div>
                            <div class="mt-3">
                                <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-3 bg-gray-200 rounded w-1/2 mt-2"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <div :class="{ 'opacity-0': loading, 'opacity-100': !loading }" class="transition-opacity duration-300">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">

                    @forelse ($galleries as $item)
                        <div
                            x-data="{ open: false }"
                            class="group relative bg-white rounded-xl overflow-hidden shadow-sm hover:shadow-lg transition"
                        >
                            <img
                                src="{{ asset('storage/' . $item->image) }}"
                                alt="{{ $item->title }}"
                                class="w-full aspect-4/3 object-cover"
                                loading="lazy"
                                @load="itemLoaded()"
                            >

                            <div
                                class="absolute inset-0 bg-black/50 opacity-0
                                       group-hover:opacity-100 transition
                                       flex items-center justify-center text-center p-4"
                            >
                                <div class="text-white">
                                    <h3 class="font-semibold text-sm">
                                        {{ $item->title }}
                                    </h3>
                                    @if($item->category)
                                        <p class="text-xs text-gray-200 mt-1">
                                            {{ $item->category }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-500">
                            Galeri belum tersedia
                        </p>
                    @endforelse

                </div>
                <div class="mt-10">
                    {{ $galleries->links('pagination::tailwind') }}
                </div>

            </div>

        </div>

    </div>
</section>
@endsection