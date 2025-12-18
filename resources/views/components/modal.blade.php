@props([
    'title' => 'Modal',
])

<div x-data="{ open: false }">

    {{ $trigger ?? '' }}

    <div
        x-show="open"
        x-cloak
        x-transition.opacity
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/30 backdrop-blur-xs"
    >
        <div
            @click.away="open = false"
            x-transition.scale
            class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6"
        >

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">{{ $title }}</h2>
                <button @click="open = false">✕</button>
            </div>

            <div class="text-sm">
                {{ $slot }}
            </div>

            <div class="mt-6 text-right">
                <button
                    @click="open = false"
                    class="bg-gray-600 text-white px-4 py-2 rounded text-sm"
                >
                    Tutup
                </button>
            </div>

        </div>
    </div>

</div>
