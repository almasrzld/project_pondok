<footer class="bg-slate-900 text-gray-300">
    <div class="container py-12 grid md:grid-cols-3 gap-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                <span class="text-lg font-semibold text-white">
                    Darul Ulum
                </span>
            </div>

            <p class="text-sm leading-relaxed text-gray-400">
                Sistem Informasi Administrasi Pondok Pesantren Darul Ulum
                untuk mendukung pendaftaran dan pengelolaan data santri
                secara digital dan terintegrasi.
            </p>
        </div>

        <div>
            <h4 class="text-white font-semibold mb-4">Menu</h4>
            <ul class="space-y-2 text-sm">

                @guest
                    <li><a href="#hero" class="hover:text-white">Beranda</a></li>
                    <li><a href="#tentang" class="hover:text-white">Tentang</a></li>
                    <li><a href="#layanan" class="hover:text-white">Layanan</a></li>
                    <li><a href="{{ route('login') }}" class="hover:text-white">Masuk</a></li>
                    <li><a href="{{ route('register') }}" class="hover:text-white">Daftar</a></li>
                @endguest

                @auth
                    <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                    <li><a href="#" class="hover:text-white">Galeri</a></li>
                    <li><a href="{{ route('pendaftaran') }}" class="hover:text-white">Pendaftaran</a></li>
                    <li><a href="{{ route('profile') }}" class="hover:text-white">Profil</a></li>

                    @if(auth()->user()->role === 'admin')
                        <li>
                            <a href="{{ route('dashboard') }}" class="hover:text-white">
                                Dashboard Admin
                            </a>
                        </li>
                    @endif
                @endauth

            </ul>
        </div>

        <div>
            <h4 class="text-white font-semibold mb-4">Kontak</h4>
            <ul class="space-y-2 text-sm text-gray-400">
                <li>📍 Desa Bologarang, Kabupaten Grobogan, Jawa Tengah</li>
                <li>📞 08xxxxxxxxxx</li>
                <li>✉️ info@darululum.sch.id</li>
            </ul>
        </div>

    </div>

    <div class="border-t border-gray-800">
        <p class="text-center text-xs py-4 text-gray-500">
            © {{ date('Y') }} Pondok Pesantren Darul Ulum.
            All rights reserved.
        </p>
    </div>
</footer>