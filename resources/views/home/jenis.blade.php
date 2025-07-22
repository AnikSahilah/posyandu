@extends('home.layout')

@section('content')
    <div class="px-4 py-8 max-w-5xl mx-auto">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-xl p-6 mb-8 text-white">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-2/3">
                    <h1 class="text-3xl font-bold mb-3">Informasi Imunisasi Posyandu</h1>
                    <p class="text-lg mb-4">Daftar lengkap vaksin yang diberikan untuk melindungi buah hati Anda</p>
                    <div class="flex items-center text-sm bg-white/20 rounded-full px-4 py-1 w-fit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Terakhir diperbarui: {{ now()->format('d F Y') }}
                    </div>
                </div>
                <div class="md:w-1/3 mt-4 md:mt-0">
                    <img src="{{ asset('images/imunisasi.jpg') }}" alt="Anak diimunisasi" class="w-full h-auto rounded-lg">
                </div>
            </div>
        </div>

        <!-- Immunization Cards -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Jenis Imunisasi yang Tersedia
            </h2>

            @if ($jenis->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach ($jenis as $item)
                        <div
                            class="bg-white rounded-lg shadow-md border-l-4 border-green-500 hover:shadow-lg transition duration-300">
                            <div class="p-5">
                                <div class="flex items-start">
                                    <div class="bg-green-100 p-2 rounded-full mr-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-800 mb-1">{{ $item->jenis_imunisasi }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $item->keterangan }}</p>
                                        <div class="mt-3 flex items-center text-sm text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Diberikan sesuai jadwal posyandu
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-lg shadow p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="text-xl font-medium text-gray-700 mb-2">Belum ada data imunisasi</h3>
                    <p class="text-gray-500">Informasi jenis imunisasi akan segera tersedia.</p>
                </div>
            @endif
        </div>

        <!-- Additional Information -->
        <div class="bg-blue-50 rounded-xl p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-3/4">
                    <h2 class="text-xl font-semibold text-blue-800 mb-2">Pentingnya Imunisasi untuk Anak</h2>
                    <p class="text-gray-700 mb-4">Imunisasi adalah cara terbaik untuk melindungi anak dari penyakit
                        berbahaya. Pastikan buah hati Anda mendapatkan vaksinasi lengkap sesuai jadwal.</p>
                </div>
                <div class="md:w-1/4 mt-4 md:mt-0">
                    <img src="{{ asset('images/anak.jpg') }}" alt="Anak sehat" class="w-full h-auto rounded-xl">
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Pertanyaan Umum
            </h2>
            <div class="space-y-3">
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-medium text-gray-800 flex items-center">
                        <span
                            class="bg-green-100 text-green-800 rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm">1</span>
                        Apakah imunisasi di posyandu aman untuk anak saya?
                    </h3>
                    <p class="text-gray-600 text-sm mt-2 pl-9">Ya, semua vaksin yang diberikan di posyandu telah lolos uji
                        keamanan dan efektivitas oleh badan kesehatan terkait.</p>
                </div>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="font-medium text-gray-800 flex items-center">
                        <span
                            class="bg-green-100 text-green-800 rounded-full w-6 h-6 flex items-center justify-center mr-3 text-sm">2</span>
                        Bagaimana jika anak saya demam setelah imunisasi?
                    </h3>
                    <p class="text-gray-600 text-sm mt-2 pl-9">Demam ringan adalah reaksi normal yang akan hilang dalam 1-2
                        hari. Berikan kompres hangat dan obat penurun panas jika diperlukan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
