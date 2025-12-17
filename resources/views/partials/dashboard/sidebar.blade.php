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
{{--
        <a href="{{ route('pembayaran.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('pembayaran*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Pembayaran
        </a>

        <a href="{{ route('rapot.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('rapot*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Rapot
        </a>

        <a href="{{ route('akun.index') }}"
           class="block px-3 py-2 rounded
           {{ request()->routeIs('akun*') 
                ? 'bg-indigo-50 text-indigo-600 font-semibold' 
                : 'hover:bg-indigo-50 hover:text-indigo-600' }}">
            Akun
        </a>
--}}
    </nav>
</aside>
