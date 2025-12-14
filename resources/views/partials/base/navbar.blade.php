<header x-data="{ open: false }" class="w-full bg-white shadow-md">
  <div class="container">
    <div class="flex justify-between items-center py-4">
      <div class="shrink-0">
        <a href="/" class="text-xl font-bold text-gray-800">MyApp</a>
      </div>

      <div class="lg:hidden">
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

      <nav class="hidden lg:flex gap-6 text-sm">
        <a href="/" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Home</a>
        <a href="/about" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">About</a>
        <a href="/contact" class="text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Contact</a>
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
      <a href="/" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Home</a>
      <a href="/about" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">About</a>
      <a href="/contact" class="block text-gray-700 hover:text-gray-900 hover:underline hover:underline-offset-4">Contact</a>
    </div>
  </div>
</header>
