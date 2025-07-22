<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda - E-Posyandu</title>

    <!-- Tailwind & Alpine -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }

        .min-h-screen-80 {
            min-height: calc(100vh - 80px);
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-green-600 shadow-lg" x-data="{ open: false }">
        <div class="max-w-8xl px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo kiri -->
                <a href="/" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                    <span class="text-white font-bold text-xl">Aplikasi Posyandu</span>
                </a>

                <!-- Menu kanan (desktop) -->
                <div class="hidden md:flex items-center space-x-6 ml-10">
                    <a href="/"
                        class="text-sm font-semibold text-white hover:text-green-200 transition-colors px-3 py-2 rounded-md {{ request()->is('/') ? 'bg-green-700' : '' }}">Beranda</a>
                    <a href="{{ route('home.jadwal') }}"
                        class="text-sm font-semibold text-white hover:text-green-200 transition-colors px-3 py-2 rounded-md ">Jadwal</a>
                    <a href="{{ route('home.edukasi') }}"
                        class="text-sm font-semibold text-white hover:text-green-200 transition-colors px-3 py-2 rounded-md">Edukasi</a>
                    <a href="{{ route('home.jenis') }}"
                        class="text-sm font-semibold text-white hover:text-green-200 transition-colors px-3 py-2 rounded-md">Jenis
                        Imunisasi</a>
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold bg-white text-green-600 hover:bg-green-50 transition-colors px-4 py-2 rounded-md ml-4">
                        <i class="fas fa-sign-in-alt mr-2"></i>Login
                    </a>
                </div>

                <!-- Mobile hamburger -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-white hover:text-green-200 focus:outline-none p-2">
                        <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Menu mobile -->
        <div class="md:hidden" x-show="open" x-transition x-cloak>
            <div class="bg-white px-4 pt-2 pb-6 space-y-2 shadow-md">
                <a href="/"
                    class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-green-50 px-3 py-2 rounded-md transition-colors">
                    <i class="fa-solid fa-house text-green-600 w-6 text-center"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('home.jadwal') }}"
                    class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-yellow-50 px-3 py-2 rounded-md transition-colors">
                    <i class="fa-solid fa-calendar-days text-yellow-600 w-6 text-center"></i>
                    <span>Jadwal</span>
                </a>
                <a href="{{ route('home.edukasi') }}"
                    class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-indigo-50 px-3 py-2 rounded-md transition-colors">
                    <i class="fa-solid fa-book-open text-indigo-600 w-6 text-center"></i>
                    <span>Edukasi</span>
                </a>
                <a href="{{ route('home.jenis') }}"
                    class="flex items-center space-x-3 text-sm font-semibold text-gray-700 hover:bg-teal-50 px-3 py-2 rounded-md transition-colors">
                    <i class="fa-solid fa-syringe text-teal-600 w-6 text-center"></i>
                    <span>Jenis Imunisasi</span>
                </a>
                <div class="border-t border-gray-100 pt-2 mt-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center space-x-3 text-sm font-semibold text-green-600 hover:bg-green-50 px-3 py-2 rounded-md transition-colors">
                        <i class="fa-solid fa-right-to-bracket w-6 text-center"></i>
                        <span>Login</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
            @yield('content') <!-- Perhatikan penulisan yang benar adalah 'content' bukan 'kontent' -->
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-green-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Tentang Posyandu -->
            <div>
                <h2 class="font-bold text-lg mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Tentang Apikasi Posyandu
                </h2>
                <p class="text-sm text-green-100">
                    Aplikasi Posyandu adalah sistem informasi kesehatan balita di Desa Talkandang yang memudahkan
                    pencatatan jadwal, edukasi, imunisasi, dan pemeriksaan balita secara digital.
                </p>
            </div>

            <!-- Navigasi -->
            <div>
                <h2 class="font-bold text-lg mb-4 flex items-center">
                    <i class="fas fa-sitemap mr-2"></i>
                    Navigasi
                </h2>
                <ul class="space-y-2 text-sm text-green-100">
                    <li><a href="/" class="hover:underline flex items-center"><i
                                class="fas fa-chevron-right text-xs mr-2"></i> Beranda</a></li>
                    <li><a href="#" class="hover:underline flex items-center"><i
                                class="fas fa-chevron-right text-xs mr-2"></i> Jadwal Posyandu</a></li>
                    <li><a href="#" class="hover:underline flex items-center"><i
                                class="fas fa-chevron-right text-xs mr-2"></i> Edukasi Kesehatan</a></li>
                    <li><a href="#" class="hover:underline flex items-center"><i
                                class="fas fa-chevron-right text-xs mr-2"></i> Jenis Imunisasi</a></li>
                    <li><a href="{{ route('login') }}" class="hover:underline flex items-center"><i
                                class="fas fa-chevron-right text-xs mr-2"></i> Login</a></li>
                </ul>
            </div>

            <!-- Kontak -->
            <div>
                <h2 class="font-bold text-lg mb-4 flex items-center">
                    <i class="fas fa-envelope mr-2"></i>
                    Kontak
                </h2>
                <ul class="text-sm text-green-100 space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-green-200"></i>
                        <span>Desa Talkandang, Kec. Kotaanyar, Kab. Probolinggo</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-green-200"></i>
                        <span>0812-3456-7890</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-green-200"></i>
                        <span>posyandu.talkandang@gmail.com</span>
                    </li>
                </ul>
            </div>

            <!-- Jam Layanan -->
            <div>
                <h2 class="font-bold text-lg mb-4 flex items-center">
                    <i class="fas fa-clock mr-2"></i>
                    Jam Layanan
                </h2>
                <p class="text-sm text-green-100">
                    <i class="fas fa-calendar-alt mr-2 text-green-200"></i> Setiap bulan<br>
                    <i class="fas fa-clock mr-2 text-green-200"></i> <span class="font-semibold text-white">08.00 -
                        11.00 WIB</span><br>
                    <i class="fas fa-map-marked-alt mr-2 text-green-200"></i> 4 Lokasi di Desa Talkandang
                </p>
            </div>
        </div>

        <div class="border-t border-green-600 py-4 text-center text-sm text-green-100 bg-green-800">
            <div class="max-w-7xl mx-auto px-4">
                &copy; 2025 E-Posyandu Desa Talkandang. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>
