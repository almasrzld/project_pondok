<div>
    <label class="text-sm text-gray-600">{{ $label }}</label>

    <div class="relative mt-1">
        <input
            type="password"
            name="{{ $name }}"
            id="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $attributes->merge([
                'class' =>
                    'w-full px-4 py-2 pr-11 border rounded-lg focus:ring focus:ring-indigo-200 focus:outline-none ' .
                    (
                        $errors->has($name) ||
                        ($name === 'password_confirmation' && $errors->has('password'))
                            ? 'border-red-500'
                            : ''
                    )
            ]) }}
        >

        <button
            type="button"
            onclick="togglePassword('{{ $name }}')"
            class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-500 hover:text-indigo-600"
            aria-label="Toggle password visibility"
        >
            <svg id="{{ $name }}-eye" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5 hidden" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.036 12.322a1.012 1.012 0 010-.639
                    C3.423 7.51 7.36 4.5 12 4.5
                    c4.638 0 8.573 3.007 9.963 7.178
                    .07.207.07.431 0 .639
                    C20.573 16.49 16.638 19.5 12 19.5
                    c-4.64 0-8.577-3.007-9.964-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>

            <svg id="{{ $name }}-eye-slash" xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5" fill="none"
                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.223A10.477 10.477 0 002.036 12.322
                    C3.423 16.49 7.36 19.5 12 19.5
                    c1.618 0 3.156-.39 4.518-1.078" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6.228 6.228A10.45 10.45 0 0112 4.5
                    c4.638 0 8.573 3.007 9.963 7.178" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 12a3 3 0 00-3-3" />
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 3l18 18" />
            </svg>
        </button>
    </div>

    @php
        $errorKey = $name === 'password_confirmation'
            ? 'password'
            : $name;
    @endphp

    <x-input-error :messages="$errors->get($errorKey)" />
</div>
