@props([
    'label' => null,
    'name',
    'hint' => null,
])

<div x-data="{ show: false }" class="space-y-1">
    @if ($label)
        <label class="text-sm font-medium flex items-center gap-1">
            <span>{{ $label }}</span>

            @if ($hint)
                <span class="text-xs text-gray-400">{{ $hint }}</span>
            @endif
        </label>
    @endif

    <div class="relative">
        <input
            :type="show ? 'text' : 'password'"
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'w-full border rounded-lg px-3 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500'
            ]) }}
        >

        <button
            type="button"
            @click="show = !show"
            class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500"
        >
            <svg
                x-show="show"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                         c4.478 0 8.268 2.943 9.542 7
                         -1.274 4.057-5.064 7-9.542 7
                         -4.477 0-8.268-2.943-9.542-7z"/>
            </svg>

            <svg
                x-show="!show"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19
                         c-4.478 0-8.268-2.943-9.543-7
                         a9.97 9.97 0 012.636-4.243"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M6.223 6.223A9.969 9.969 0 0112 5
                         c4.478 0 8.268 2.943 9.543 7
                         a9.97 9.97 0 01-4.043 5.132"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3l18 18"/>
            </svg>
        </button>
    </div>

    <x-input-error :messages="$errors->get($name)" />
</div>
