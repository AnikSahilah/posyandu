<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Data Balita - E-Posyandu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Alpine.js (Diperlukan agar navbar mobile berfungsi) -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">

    <style>
        [x-cloak] {
            display: none !important;
        }

        .card-shadow {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .hover-scale {
            transition: transform 0.2s ease;
        }

        .hover-scale:hover {
            transform: translateY(-2px);
        }

        .badge {
            @apply inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased flex flex-col min-h-screen">

    <!-- Navbar -->
    <nav class="bg-primary-700 shadow-lg" x-data="{ open: false }">
        <div class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 hover:opacity-90 transition-opacity">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10">
                    <span class="text-white font-bold text-xl">Aplikasi Posyandu</span>
                </a>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    <div class="flex items-center space-x-4">
                        <span class="text-white text-sm font-medium">
                            <i class="fas fa-user-circle mr-1"></i>
                            <a href="{{ route('profile.edit') }}" class="text-white text-sm font-medium">
                                {{ Auth::user()->name ?? 'Pengguna' }}
                            </a>
                        </span>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center text-white hover:text-primary-200 transition-colors text-sm font-medium">
                                <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button @click="open = !open" class="text-white hover:text-primary-200 focus:outline-none p-2">
                        <svg class="h-6 w-6" x-show="!open" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="h-6 w-6" x-show="open" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            x-cloak>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        
        <!-- Mobile Menu -->
<div class="md:hidden" x-show="open" x-transition x-cloak>
    <div class="bg-white px-4 pt-4 pb-6 space-y-4 shadow-md rounded-b-lg">
        <a href="{{ route('profile.edit') }}"
            class="flex items-center text-gray-700 hover:bg-gray-100 px-3 py-2 rounded-md text-sm font-medium">
            <i class="fas fa-user-circle mr-3 text-primary-600"></i> {{ Auth::user()->name ?? 'Pengguna' }}
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full flex items-center text-red-600 hover:bg-red-50 px-3 py-2 rounded-md text-sm font-medium">
                <i class="fas fa-sign-out-alt mr-3"></i> Keluar
            </button>
        </form>
    </div>
</div>

    </nav>

    <!-- Main Content -->
    <main class="flex-1 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800">Data Balita</h1>
                <p class="text-gray-600 mt-2">Informasi lengkap balita dan riwayat pemeriksaan</p>
            </div>

            <!-- Profile Card -->
            <div class="bg-white rounded-xl card-shadow overflow-hidden hover-scale transition-all mb-8">
                <div class="bg-primary-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-white">Profil Balita</h2>
                        <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-xs font-semibold text-white">
                            {{ $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    @if ($balita)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom 1 -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-id-card text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">NIK Balita</p>
                                    <p class="font-medium">{{ $balita->nik_balita }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-baby text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Nama Balita</p>
                                    <p class="font-medium">{{ $balita->nama_balita }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-calendar-day text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Tanggal Lahir</p>
                                    <p class="font-medium">{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->format('d F                                                                                                                                                                                                                                                                                                                Y') }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-weight text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Berat/Tinggi Lahir</p>
                                    <p class="font-medium">{{ $balita->berat_badan_lahir }} kg / {{ $balita->tinggi_lahir }} cm</p>
                                </div>
                            </div>
                        </div>

                        <!-- Kolom 2 -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-home text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Posyandu</p>
                                    <p class="font-medium">{{ $balita->tempat->tempat_posyandu }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-users text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Orang Tua</p>
                                    <p class="font-medium">{{ $balita->nama_orang_tua }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-map-marker-alt text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Alamat</p>
                                    <p class="font-medium">RT {{ $balita->rt }} / RW {{ $balita->rw }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-primary-100 p-2 rounded-lg text-primary-600 mr-4">
                                    <i class="fas fa-book-medical text-lg"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Buku KIA & IMD</p>
                                    <p class="font-medium">
                                        {{ $balita->buku_kia ? 'Memiliki Buku KIA' : 'Tidak memiliki Buku KIA' }},
                                        {{ $balita->inisiasi_menyusui_dini ? 'IMD Ya' : 'IMD Tidak' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-center py-8 bg-red-50 rounded-lg">
                        <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-3"></i>
                        <h3 class="text-lg font-medium text-red-800">Data balita tidak ditemukan</h3>
                        <p class="text-red-600 mt-1">Silakan hubungi administrator posyandu</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Riwayat Pemeriksaan -->
            <div class="bg-white rounded-xl card-shadow overflow-hidden hover-scale">
                <div class="bg-primary-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Riwayat Pemeriksaan</h2>
                </div>

                <div class="p-6">
                    @if ($riwayat->isEmpty())
                    <div class="text-center py-12">
                        <i class="fas fa-clipboard-list text-gray-400 text-5xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-600">Belum ada riwayat pemeriksaan</h3>
                        <p class="text-gray-500 mt-1">Data pemeriksaan akan muncul setelah dilakukan pemeriksaan di
                            posyandu</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Umur</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Berat Badan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tinggi Badan</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status Gizi</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Imunisasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($riwayat as $r)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($r['tanggal'])->format('d M Y') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                        {{ $r['umur'] ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                            {{ $r['berat_badan'] ?? '-' }} kg
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span
                                            class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                            {{ $r['tinggi_badan'] ?? '-' }} cm
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                        $status = $r['status'] ?? '-';
                                        $bgColor = match ($status) {
                                        'Gizi Baik' => 'bg-green-100 text-green-800',
                                        'Gizi Kurang' => 'bg-yellow-100 text-yellow-800',
                                        'Gizi Buruk' => 'bg-red-100 text-red-800',
                                        'Stunting' => 'bg-orange-100 text-orange-800',
                                        default => 'bg-gray-100 text-gray-800',
                                        };
                                        @endphp
                                        <span class="badge {{ $bgColor }}">{{ $status }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-center">
                                            <div class="text-sm font-medium text-gray-900">{{ $r['jenis_imunisasi'] ?? '-' }}</div>
                                            @if ($r['keterangan_imunisasi'] ?? false)
                                            <div class="text-xs text-gray-500 mt-1">{{ $r['keterangan_imunisasi'] }}
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr> @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination (optional) -->
                    <div class="mt-6
        flex items-center justify-between">
    <div class="text-sm text-gray-500"> Menampilkan <span class="font-medium">1</span> sampai <span
            class="font-medium">{{ count($riwayat) }}</span> dari <span class="font-medium">{{ count($riwayat) }}</span>
        hasil
    </div>
    <!-- Jika ingin menambahkan pagination -->
    <div class="flex space-x-2">
        <button
            class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Sebelumnya</button>
        <button
            class="px-3 py-1 border rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Selanjutnya</button>
    </div>
    </div>
    @endif
    </div>
    </div>
    </div>

    <!-- Tambahkan di bawah Riwayat Pemeriksaan pada view user -->

    <!-- Grafik Pemeriksaan -->
    <div class="mt-10 p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Grafik Pemeriksaan (Umur vs Berat/Tinggi)</h3>
        <canvas id="grafikPemeriksaan" height="100"></canvas>
    </div>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const riwayatData = @json($riwayat);

        const labels = riwayatData.map(item => item.umur + ' bln');
        const bbData = riwayatData.map(item => item.berat_badan);
        const tbData = riwayatData.map(item => item.tinggi_badan);

        const ctx = document.getElementById('grafikPemeriksaan').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Berat Badan (kg)',
                        data: bbData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Tinggi Badan (cm)',
                        data: tbData,
                        borderColor: 'rgb(255, 159, 64)',
                        backgroundColor: 'rgba(255, 159, 64, 0.2)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>

    </main>

    <!-- Footer -->
    <footer class="bg-green-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Tentang Posyandu -->
            <div>
                <h2 class="font-bold text-lg mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Tentang E-Posyandu
                </h2>
                <p class="text-sm text-green-100">
                    E-Posyandu adalah sistem informasi kesehatan balita di Desa Talkandang yang memudahkan
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
