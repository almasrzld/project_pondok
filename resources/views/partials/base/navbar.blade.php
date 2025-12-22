<header x-data="{ open: false, section: 'hero' }" @scroll.window="const y = window.scrollY; section = y < 500 ? 'hero' : y < 1200 ? 'tentang' : 'layanan'" class="fixed top-0 left-0 w-full bg-white shadow-md z-50">
  <div class="container">
    <div class="flex justify-between items-center py-4">

      <div class="flex items-center gap-3 shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 sm:h-12">
        <a
          href="{{ auth()->check() ? route('home') : route('landing') }}"
          class="text-xl font-bold text-gray-800"
        >
          Darul Ulum
        </a>
      </div>

      <div class="lg:hidden flex items-center justify-center h-10 w-10">
        <button @click="open = !open" class="text-gray-600 focus:outline-none">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </button>
      </div>

      <nav class="hidden lg:flex items-center gap-6 text-sm">
        @guest
          <a
            href="#hero"
            :class="section === 'hero'
              ? 'text-indigo-600 font-semibold'
              : 'nav-link'"
          >
            Beranda
          </a>
          <a
            href="#tentang"
            :class="section === 'tentang'
              ? 'text-indigo-600 font-semibold'
              : 'nav-link'"
          >
            Tentang
          </a>
          <a
            href="#layanan"
            :class="section === 'layanan'
              ? 'text-indigo-600 font-semibold'
              : 'nav-link'"
          >
            Layanan
          </a>
          <a href="{{ route('login') }}" class="nav-link font-semibold">
            Masuk / Daftar
          </a>
        @endguest

        @auth
          <x-nav-link
              href="{{ route('home') }}"
              :active="request()->routeIs('home')"
          >
              Beranda
          </x-nav-link>
          <x-nav-link
              href="{{ route('gallery') }}"
              :active="request()->routeIs('gallery')"
          >
              Galeri
          </x-nav-link>
          <x-nav-link
              href="{{ route('pendaftaran') }}"
              :active="request()->routeIs('pendaftaran')"
          >
              Pendaftaran
          </x-nav-link>
          <x-nav-link
              href="{{ route('pembayaran') }}"
              :active="request()->routeIs('pembayaran')"
          >
              Pembayaran
          </x-nav-link>
          <x-nav-link
              href="{{ route('rapot') }}"
              :active="request()->routeIs('rapot')"
          >
              Rapot
          </x-nav-link>

          <div x-data="{ openProfile: false }" class="relative">
            <button @click="openProfile = !openProfile"
              class="flex items-center gap-2 focus:outline-none">
              <img
                src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                class="w-9 h-9 rounded-full border">
              <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 9l-7 7-7-7" />
              </svg>
            </button>

            <div
              x-show="openProfile"
              @click.outside="openProfile = false"
              x-transition
              x-cloak
              class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-md text-sm"
            >
              <div class="px-4 py-3 border-b">
                <p class="font-semibold truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
              </div>

              <x-nav-link href="{{ route('profile.index') }}" :active="request()->routeIs('profile.index')" class="block px-4 py-2 hover:bg-gray-100">
                Profil
              </x-nav-link>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                  Logout
                </button>
              </form>
            </div>
          </div>
        @endauth

      </nav>
    </div>

    <div
      x-show="open"
      x-cloak
      x-transition
      class="absolute top-full left-0 w-full bg-white shadow-md lg:hidden space-y-2"
    >

      @guest
      <div class="container">
        <a
          href="#hero"
          @click="open = false"
          :class="section === 'hero'
            ? 'text-indigo-600 font-semibold block'
            : 'mobile-link'"
        >
          Beranda
        </a>
        <a
          href="#tentang"
          @click="open = false"
          :class="section === 'tentang'
            ? 'text-indigo-600 font-semibold block'
            : 'mobile-link'"
        >
          Tentang
        </a>
        <a
          href="#layanan"
          @click="open = false"
          :class="section === 'layanan'
            ? 'text-indigo-600 font-semibold block'
            : 'mobile-link'"
        >
          Layanan
        </a>
        <a href="{{ route('login') }}" class="mobile-link font-semibold">
          Masuk / Daftar
        </a>
      </div>
      @endguest

      @auth
      <div class="container">
        <x-nav-link
            href="{{ route('home') }}"
            :active="request()->routeIs('home')"
            variant="mobile"
            class="block"
        >
            Beranda
        </x-nav-link>
        <x-nav-link
            href="{{ route('gallery') }}"
            :active="request()->routeIs('gallery')"
            variant="mobile"
            class="block"
        >
            Galeri
        </x-nav-link>
        <x-nav-link
            href="{{ route('pendaftaran') }}"
            :active="request()->routeIs('pendaftaran')"
            variant="mobile"
            class="block"
        >
            Pendaftaran
        </x-nav-link>
        <x-nav-link
            href="{{ route('pembayaran') }}"
            :active="request()->routeIs('pembayaran')"
            variant="mobile"
            class="block"
        >
            Pembayaran
        </x-nav-link>
        <x-nav-link
            href="{{ route('rapot') }}"
            :active="request()->routeIs('rapot')"
            variant="mobile"
            class="block"
        >
            Rapot
        </x-nav-link>
      </div>

        <div class="pt-3 border-t">
          <div class="container">
            <p class="text-sm font-semibold">{{ auth()->user()->name }}</p>

            <x-nav-link href="{{ route('profile.index') }}" :active="request()->routeIs('profile.index')" variant="mobile" class="block text-sm hover:underline">
              Profil
            </x-nav-link>

            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="text-sm text-red-600 hover:underline">
                Logout
              </button>
            </form>
          </div>
        </div>
      @endauth

    </div>
  </div>
</header>
