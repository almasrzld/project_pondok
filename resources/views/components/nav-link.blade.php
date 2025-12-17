@props([
    'href',
    'active' => false,
    'variant' => 'desktop',
])

@php
    $base = 'transition-colors duration-200';

    $desktopActive = 'text-indigo-600 font-semibold border-b-2 border-indigo-600';
    $mobileActive  = 'text-indigo-600 font-semibold';

    $activeClass = $variant === 'mobile'
        ? $mobileActive
        : $desktopActive;

    $inactiveClass = 'text-gray-700 hover:text-indigo-600';
@endphp

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            $base . ' ' .
            ($active ? $activeClass : $inactiveClass)
    ]) }}
>
    {{ $slot }}
</a>
