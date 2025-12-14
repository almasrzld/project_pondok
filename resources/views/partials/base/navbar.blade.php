<header x-data="{ open: false }" class="w-full bg-white shadow-md">
  <div class="container">
    <div class="flex justify-between items-center py-4">
      <div class="flex items-center gap-3 shrink-0">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 sm:h-12">
        <a href="/" class="text-xl font-bold text-gray-800">Darul Ulum</a>
      </div>

      <div class="lg:hidden flex items-center justify-center h-10 w-10">
        <button
          @click="open = !open"
          class="text-gray-600 focus:outline-none cursor-pointer"
        >
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16"
            />
          </svg>
        </button>
      </div>

      <nav class="hidden lg:flex items-center gap-6 text-sm">
        <a href="/" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Beranda</a>
        @auth
        <a href="#" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Tentang</a>
        @endauth
        <a href="/pendaftaran" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Pendaftaran</a>
        <a href="#" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Kontak</a>
        @guest
        <a href="/auth/login" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Masuk/Daftar</a>
        @endguest
        @auth
        <div x-data="{ openProfile: false }" class="relative">
            <!-- Avatar -->
            <button
                @click="openProfile = !openProfile"
                class="flex items-center gap-2 focus:outline-none"
            >
                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}"
                    alt="Avatar"
                    class="w-9 h-9 rounded-full border"
                >
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div
                x-show="openProfile"
                @click.outside="openProfile = false"
                x-transition
                x-cloak
                class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-md text-sm"
            >
                <div class="px-4 py-3 border-b">
                    <p class="font-semibold text-gray-800 truncate">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 truncate">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <a href="{{ route('profile') }}"
                    class="block px-4 py-2 hover:bg-gray-100">
                    Profil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
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
      x-transition:enter="transition-all ease-out duration-200"
      x-transition:enter-start="opacity-0 -translate-y-2"
      x-transition:enter-end="opacity-100 translate-y-0"
      x-transition:leave="transition ease-in duration-150"
      x-transition:leave-start="opacity-100 translate-y-0"
      x-transition:leave-end="opacity-0 -translate-y-2"
      class="lg:hidden pb-4 space-y-2"
    >
      <a href="/" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Beranda</a>
      @auth
      <a href="#" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Tentang</a>
      @endauth
      <a href="/pendaftaran" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Pendaftaran</a>
      <a href="#" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Kontak</a>
      @guest
      <a href="/auth/login" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Masuk/Daftar</a>
      @endguest
      @auth
      <div class="pt-3 border-t space-y-2">
          <p class="text-sm font-semibold text-gray-800">
              {{ auth()->user()->name }}
          </p>

          <a
              href="{{ route('profile') }}"
              class="block text-sm text-gray-700 hover:underline"
          >
              Profil
          </a>

          <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button
                  type="submit"
                  class="text-red-600 text-sm hover:underline"
              >
                  Logout
              </button>
          </form>
      </div>
      @endauth
    </div>
  </div>
</header>
