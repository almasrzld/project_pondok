<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-40 w-64
           bg-white shadow transform transition-transform
           lg:translate-x-0">

    <div class="py-4 flex items-center gap-3 px-6 font-bold">
        <img src="{{ asset('images/logo.png') }}" alt="logo" class="w-8 h-8">
        <h1>Darul Ulum</h1>
    </div>

    <div class="lg:hidden px-6 py-2">
        <p class="font-semibold truncate">Halo, {{ auth()->user()->name }}</p>
        <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
    </div>

    <nav class="p-4 space-y-2 text-sm">
        <a href="{{ route('dashboard.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard.index') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Dashboard
        </a>

        <a href="{{ route('dashboard.santri.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard.santri.*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Santri
        </a>

        <div
            x-data="{ open: {{ request()->routeIs('dashboard.pembayaran*') || request()->routeIs('dashboard.jenis-pembayaran*') ? 'true' : 'false' }} }"
        >
            <button
                @click="open = !open"
                class="w-full flex items-center justify-between px-3 py-2 rounded
                {{ request()->routeIs('dashboard.pembayaran*') || request()->routeIs('dashboard.jenis-pembayaran*')
                    ? 'bg-indigo-50 text-indigo-600 font-semibold'
                    : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
                <span>Pembayaran</span>
                <svg class="w-4 h-4 transform transition-transform"
                     :class="open && 'rotate-180'"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-show="open" x-collapse class="mt-1 ml-4 space-y-1">
                <a href="{{ route('dashboard.pembayaran.index') }}"
                   class="block px-3 py-2 rounded text-sm
                   {{ request()->routeIs('dashboard.pembayaran.*')
                        ? 'bg-indigo-100 text-indigo-600 font-semibold'
                        : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
                    Data Pembayaran
                </a>

                <a href="{{ route('dashboard.jenis-pembayaran.index') }}"
                   class="block px-3 py-2 rounded text-sm
                   {{ request()->routeIs('dashboard.jenis-pembayaran.*')
                        ? 'bg-indigo-100 text-indigo-600 font-semibold'
                        : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
                    Jenis Pembayaran
                </a>
            </div>
        </div>

        <a href="{{ route('dashboard.gallery.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard.gallery*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Galeri
        </a>

        <a href="{{ route('dashboard.rapot.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard.rapot*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Rapot
        </a>

        <a href="{{ route('dashboard.akun.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('dashboard.akun*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Akun
        </a>

    </nav>
</aside>
