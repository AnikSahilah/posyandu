@extends('layout.admin')

@section('konten')
    <div class="bg-gradient-to-r from-green-600 to-green-700 text-white rounded-2xl p-8 shadow-lg relative overflow-hidden">
        <div class="relative z-10 max-w-2xl">
            <h1 class="text-3xl md:text-4xl font-bold mb-3 leading-tight">Selamat Datang di Dashboard Posyandu</h1>
            <p class="text-emerald-100 text-lg opacity-90">Kelola data balita dan aktivitas posyandu dengan mudah menggunakan
                sistem terintegrasi</p>
        </div>
        <div class="absolute -bottom-8 -right-8 opacity-10">
            <i class="fas fa-heartbeat text-[180px]"></i>
        </div>
    </div>


    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 mt-6">
        <!-- Total Balita -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-blue-500 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Total Balita Terdaftar</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ number_format($totalBalita) }}</h3>
                </div>
                <div class="p-3 bg-blue-100 rounded-full text-blue-600">
                    <i class="fas fa-baby text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm font-medium">
                @if ($growth >= 0)
                    <div class="text-green-600">
                        <i class="fas fa-arrow-up"></i> {{ number_format($growth, 1) }}% dari bulan lalu
                    </div>
                @else
                    <div class="text-red-600">
                        <i class="fas fa-arrow-down"></i> {{ number_format(abs($growth), 1) }}% dari bulan lalu
                    </div>
                @endif
            </div>
        </div>

        <!-- Jenis Imunisasi -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-pink-500 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Jenis Imunisasi</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalJenis }}</h3>
                </div>
                <div class="p-3 bg-pink-100 rounded-full text-pink-600">
                    <i class="fas fa-vial text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm text-green-600 font-medium">
                <i class="fas fa-clipboard-list"></i> Total jenis imunisasi terdaftar
            </div>
        </div>

        <!-- Imunisasi Terbaru -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-purple-500 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Imunisasi Terbaru</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $imunisasiTerbaruCount }}</h3>
                </div>
                <div class="p-3 bg-purple-100 rounded-full text-purple-600">
                    <i class="fas fa-syringe text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm text-green-600 font-medium">
                <i class="fas fa-calendar-check"></i> 30 hari terakhir
            </div>
        </div>

        <!-- Edukasi Diterbitkan -->
        <div class="bg-white rounded-xl shadow-md p-6 border-l-4 border-yellow-500 hover:shadow-lg transition-shadow">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-gray-500 font-medium">Edukasi Diterbitkan</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalEdukasi }}</h3>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full text-yellow-600">
                    <i class="fas fa-book-reader text-xl"></i>
                </div>
            </div>
            <div class="mt-2 text-sm text-green-600 font-medium">
                <i class="fas fa-eye"></i> {{ $totalEdukasi * 50 }} diperkirakan dibaca
            </div>
        </div>
    </div>

    <!-- Quick Actions - Posyandu Services -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @php
            $services = [
                [
                    'route' => 'jadwal.tampil',
                    'icon' => 'calendar-check',
                    'title' => 'Jadwal Posyandu',
                    'color' => 'emerald',
                    'desc' => 'Atur jadwal kunjungan bulanan',
                ],
                [
                    'route' => 'kegiatan.tampil3',
                    'icon' => 'hands-helping',
                    'title' => 'Kegiatan Posyandu',
                    'color' => 'sky',
                    'desc' => 'Pantau program kesehatan',
                ],
                [
                    'route' => 'edukasi.tampil1',
                    'icon' => 'book-medical',
                    'title' => 'Edukasi Ibu & Balita',
                    'color' => 'violet',
                    'desc' => 'Materi kesehatan keluarga',
                ],
                [
                    'route' => 'imunisasi.tampil2',
                    'icon' => 'syringe',
                    'title' => 'Catatan Imunisasi',
                    'color' => 'blue',
                    'desc' => 'Lengkapi vaksinasi balita',
                ],
                [
                    'route' => 'balita.tampil4',
                    'icon' => 'baby',
                    'title' => 'Data Balita',
                    'color' => 'pink',
                    'desc' => 'Kelola data peserta',
                ],
                [
                    'route' => 'pemeriksaan.tampil5',
                    'icon' => 'weight',
                    'title' => 'Pemantauan Gizi',
                    'color' => 'amber',
                    'desc' => 'Pantau perkembangan balita',
                ],
            ];
        @endphp

        @foreach ($services as $service)
            <a href="{{ route($service['route']) }}" class="group transform transition hover:scale-[1.02]">
                <div
                    class="h-full bg-white rounded-lg border border-gray-100 p-5 shadow-sm hover:shadow-md transition-all hover:border-{{ $service['color'] }}-300">
                    <div class="flex items-center">
                        <div
                            class="mr-4 p-3 rounded-xl bg-{{ $service['color'] }}-50 text-{{ $service['color'] }}-600 group-hover:bg-{{ $service['color'] }}-100 transition-colors">
                            <i class="fas fa-{{ $service['icon'] }} text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-800 group-hover:text-{{ $service['color'] }}-700">
                                {{ $service['title'] }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $service['desc'] }}</p>
                        </div>
                        <div class="text-gray-300 group-hover:text-{{ $service['color'] }}-400">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <!-- Aktivitas Terkini -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-10">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Aktivitas Terkini</h3>
        </div>
        <div class="space-y-4">
            @forelse ($activities as $activity)
                <div class="flex items-start pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="p-2 rounded-lg {{ $activity['color'] }} mr-4 mt-1">
                        <i class="fas fa-{{ $activity['icon'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-gray-800">{{ $activity['title'] }}</h4>
                        <p class="text-gray-600 text-sm">{{ $activity['desc'] }}</p>
                    </div>
                    <div class="text-gray-400 text-sm whitespace-nowrap ml-4">
                        {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                    </div>
                </div>
            @empty
                <p class="text-gray-500 text-sm">Belum ada aktivitas terbaru.</p>
            @endforelse
        </div>
    </div>
@endsection
