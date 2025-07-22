@extends('home.layout')

@section('content')
<div class="px-4 py-8 max-w-7xl mx-auto">
    <!-- Header Utama -->
    <div class="text-center mb-8 border-b border-green-200 pb-6">
        <h1 class="text-3xl font-bold text-green-800 uppercase">Jadwal Posyandu Balita</h1>
        <h2 class="text-2xl text-gray-700 mt-2 font-medium">Desa Talkandang</h2>
    </div>

    <!-- Filter Tahun -->
    <div class="flex justify-center mb-8">
        <div class="flex flex-wrap gap-2 justify-center">
            @foreach ($availableYears as $year)
            <button type="button" onclick="filterYear('{{ $year }}')"
                class="px-4 py-2 text-sm font-medium {{ $selectedYear == $year ? 'bg-green-600 text-white' : 'bg-white text-green-700 hover:bg-green-50' }} border border-green-300 rounded-lg transition-colors">
                Tahun {{ $year }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Navigasi Bulan -->
    <div class="sticky top-0 bg-white z-10 pt-2 pb-2 mb-6 rounded-lg shadow-sm">
        <div class="flex overflow-x-auto scrollbar-hide gap-2 px-2 sm:justify-center">
            @foreach (['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $month)
            <button onclick="scrollToMonth('{{ $selectedYear }}-{{ strtolower($month) }}')"
                class="flex-shrink-0 px-4 py-2 bg-white border border-green-300 rounded-lg text-sm font-medium text-green-700 hover:bg-green-50 hover:border-green-400 transition-all">
                {{ $month }}
            </button>
            @endforeach
        </div>
    </div>

    <!-- Grid Jadwal Per Bulan -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($jadwal as $month => $locations)
        @if ($locations->count() > 0)
        <div id="{{ $selectedYear }}-{{ strtolower($month) }}"
            class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
            <!-- Header Bulan -->
            <div class="bg-gradient-to-r from-green-600 to-green-500 px-5 py-3">
                <div class="flex justify-between items-center">
                    <h3 class="text-xl font-bold text-white">{{ $month }} {{ $selectedYear }}</h3>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white opacity-80" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <!-- Daftar Lokasi -->
            <div class="p-5">
                <ul class="space-y-3">
                    @foreach ($locations as $location)
                    <li class="flex items-start">
                        <div class="flex-shrink-0 h-6 w-6 text-green-500 mt-0.5 mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <span class="text-gray-800 font-medium">
                            {{ $location->tempat->tempat_posyandu ?? '-' }}
                            ({{ \Carbon\Carbon::parse($location->tanggal_posyandu)->format('j M') }})
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
        @endforeach
    </div>
</div>

<!-- Script Navigasi -->
<script>
    function filterYear(year) {
        window.location.href = "{{ url()->current() }}?tahun=" + year;
    }

    function scrollToMonth(monthId) {
        const element = document.getElementById(monthId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start',
                inline: 'nearest'
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const today = new Date();
        const currentMonth = today.toLocaleString('id-ID', {
            month: 'long'
        }).toLowerCase();
        const currentYear = today.getFullYear().toString();

        if ("{{ $selectedYear }}" === currentYear) {
            scrollToMonth(currentYear + "-" + currentMonth);
        }
    });
</script>

<!-- Styling scrollbar -->
<style>
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
@endsection