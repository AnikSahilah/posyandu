@php $menu = $menu ?? ''; @endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Posyandu</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body class="bg-[#fef9f4] h-screen overflow-hidden">
    <div class="flex h-full" x-data="{ isSidebarOpen: window.innerWidth >= 768 }" @resize.window="isSidebarOpen = window.innerWidth >= 768">

        <!-- Sidebar -->
        <aside
            class="w-64 bg-white text-gray-800 fixed inset-y-0 left-0 transform transition-transform duration-200 ease-in-out z-40 md:relative md:translate-x-0"
            :class="{ '-translate-x-full': !isSidebarOpen }">
            <div class="p-6 h-full overflow-y-auto max-h-screen">
                <h1 class="text-lg font-bold mb-6 flex items-center space-x-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                    <span>Aplikasi Posyandu</span>
                </h1>

                <nav class="space-y-3 text-sm font-semibold">

                    {{-- GENERAL --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">General</div>
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'dashboard') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-tachometer-alt bg-blue-100 text-blue-600 p-2 rounded-full"></i>
                        <span>Dashboard</span>
                    </a>

                    {{-- INFORMASI --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Informasi</div>
                    <a href="{{ route('jadwal.tampil') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'tampil') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-calendar-alt bg-yellow-100 text-yellow-600 p-2 rounded-full"></i>
                        <span>Jadwal Posyandu</span>
                    </a>

                    <a href="{{ route('kegiatan.tampil3') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'kegiatan') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-notes-medical bg-rose-100 text-rose-600 p-2 rounded-full"></i>
                        <span>Kegiatan Posyandu</span>
                    </a>

                    <a href="{{ route('edukasi.tampil1') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'edukasi') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-book-open bg-indigo-100 text-indigo-600 p-2 rounded-full"></i>
                        <span>Edukasi Kesehatan</span>
                    </a>

                    {{-- MASTER DATA --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Master Data</div>
                    <a href="{{ route('petugas.tampil6') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'petugas') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-user-nurse bg-pink-100 text-pink-600 p-2 rounded-full"></i>
                        <span>Data Petugas</span>
                    </a>

                    <a href="{{ route('balita.tampil4') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'tampil4') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-child bg-green-100 text-green-600 p-2 rounded-full"></i>
                        <span>Data Balita</span>
                    </a>

                    <a href="{{ route('jenis.tampil7') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'jenis') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-vial bg-teal-100 text-teal-600 p-2 rounded-full"></i>
                        <span>Data Jenis</span>
                    </a>


                    <a href="{{ route('tempat.tampil12') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'tempat') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-map-marker-alt bg-orange-100 text-orange-600 p-2 rounded-full"></i>
                        <span>Data Tempat</span>
                    </a>


                    {{-- LAYANAN --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Layanan</div>
                    <a href="{{ route('pemeriksaan.tampil5') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'pemeriksaan') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-chart-line bg-fuchsia-100 text-fuchsia-600 p-2 rounded-full"></i>
                        <span>Pemeriksaan Balita</span>
                    </a>

                    <a href="{{ route('imunisasi.tampil2') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'imunisasi') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-syringe bg-cyan-100 text-cyan-600 p-2 rounded-full"></i>
                        <span>Imunisasi Balita</span>
                    </a>

                    <a href="{{ route('clustering.index') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'clustering') bg-green-700 text-white @else hover:bg-green-600 @endif">
                        <i class="fas fa-project-diagram bg-blue-100 text-blue-600 p-2 rounded-full"></i>
                        <span>Clustering Gizi</span>
                    </a>


                    {{-- CETAK --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Cetak</div>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'laporan') bg-green-700 @endif hover:bg-green-600">
                        <i class="fas fa-file-medical bg-gray-100 text-gray-600 p-2 rounded-full"></i>
                        <span>Laporan</span>
                    </a>

                    <!-- AKUN -->
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Pengaturan Akun</div>
                    <div class="space-y-1">
                        <a href="{{ route('admin.edit') }}"
                            class="flex items-center space-x-3 p-2 rounded-lg transition @if ($menu == 'profil') bg-green-100 text-green-800 @endif hover:bg-green-100 group">
                            <div class="relative">
                                <i
                                    class="fas fa-user-circle bg-purple-100 text-purple-600 p-2 rounded-full group-hover:bg-purple-200 transition"></i>
                                @if ($menu == 'profil')
                                    <span class="absolute top-0 right-0 w-2 h-2 bg-green-500 rounded-full"></span>
                                @endif
                            </div>
                            <span>Profil Saya</span>
                            <i class="fas fa-chevron-right ml-auto text-xs text-gray-400"></i>
                        </a>
                    </div>

                    {{-- LOGOUT --}}
                    <div class="text-xs uppercase text-gray-500 mt-4 mb-1">Log Out</div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin logout?')"
                            class="w-full text-left flex items-center space-x-3 p-2 rounded-lg transition hover:bg-red-600 text-gray-800 hover:text-white">
                            <i class="fas fa-sign-out-alt bg-red-100 text-red-600 p-2 rounded-full"></i>
                            <span>Logout</span>
                        </button>
                    </form>



                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            <!-- Mobile Header -->
            <div class="md:hidden bg-green-600 text-white p-4 shadow flex justify-between items-center z-50">
                <h1 class="text-lg font-bold">Aplikasi Posyandu</h1>
                <button @click="isSidebarOpen = !isSidebarOpen">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Page Content -->
            <div class="overflow-y-auto p-4 md:p-6 flex-1 bg-gray-50">
                @yield('konten')
            </div>
        </main>
    </div>
</body>

</html>
