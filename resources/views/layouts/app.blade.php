<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            Darul Ulum
            @hasSection('title')
                | @yield('title')
            @endif
        </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        @include('partials.base.navbar')
        
        <main class="pt-18 lg:pt-20">
        @yield('content')
        </main>

        @include('partials.base.footer')

        <!-- Scroll To Top -->
    <div
        x-data="{ show: false }"
        x-init="
            window.addEventListener('scroll', () => {
                show = window.scrollY > 100
            })
        "
    >
        <button
            x-show="show"
            x-transition
            x-cloak
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            class="fixed bottom-6 right-6 z-50 bg-linear-to-br from-indigo-600 to-purple-600
                text-white p-3 rounded-full shadow-lg cursor-pointer"
            aria-label="Scroll to top"
            title="Kembali ke atas"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M5 15l7-7 7 7" />
            </svg>
        </button>
    </div>
    </body>
</html>
