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
    <div x-data="{ sidebarOpen: false }" x-cloak class="relative min-h-screen bg-gray-50">

    @include('partials.dashboard.sidebar')

    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-30 lg:hidden">
    </div>

    @include('partials.dashboard.navbar')

    <main class="lg:ml-64 min-h-screen pt-16">
        <div class="p-6">
            @yield('content')
        </div>
    </main>

</div>
</body>
</html>
