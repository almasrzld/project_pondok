<header
    class="fixed top-0 left-0 lg:left-64 right-0
           py-4 bg-white shadow flex items-center justify-between px-6 z-30">

    <div class="flex items-center gap-3">
        <button
            @click="sidebarOpen = true"
            class="lg:hidden text-xl">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
        
        <h1 class="font-semibold">
            @yield('header-title', 'Dashboard')
        </h1>
    </div>

    <div class="flex items-center gap-4 text-sm">
        <p class="hidden lg:block font-semibold truncate">{{ auth()->user()->name }}</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="text-red-600 hover:underline">
                Logout
            </button>
        </form>
    </div>
</header>
