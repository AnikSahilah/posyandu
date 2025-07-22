@extends('home.layout')

@section('content')
    <div class="flex flex-col min-h-screen">
        <main class="flex-grow">
            {{-- Slider Kegiatan --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="relative overflow-hidden rounded-xl shadow-xl" x-data="{ currentSlide: 0 }" x-init="setInterval(() => { currentSlide = (currentSlide + 1) % {{ count($kegiatan) }} }, 5000)">
                    <div class="relative h-64 sm:h-80 md:h-96 lg:h-[500px]">
                        @foreach ($kegiatan as $index => $item)
                            <div x-show="currentSlide === {{ $index }}"
                                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
                                x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="absolute inset-0 w-full h-full">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}"
                                    class="w-full h-full object-cover rounded-xl">
                                <div
                                    class="absolute bottom-0 left-0 w-full bg-gradient-to-t from-black/70 to-transparent text-white p-4 md:p-6 rounded-b-xl">
                                    <h2 class="text-lg sm:text-xl md:text-2xl font-bold">{{ $item->judul }}</h2>
                                    <p class="text-xs sm:text-sm md:text-base mt-1 line-clamp-2">
                                        {{ \Illuminate\Support\Str::limit($item->keterangan, 120) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Navigasi Slider --}}
                    <button @click="currentSlide=(currentSlide - 1 + {{ count($kegiatan) }}) % {{ count($kegiatan) }}"
                        class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-1 sm:p-2 shadow-lg z-10 transition-all"
                        aria-label="Previous slide">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </button>
                    <button @click="currentSlide = (currentSlide + 1) % {{ count($kegiatan) }}"
                        class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-1 sm:p-2 shadow-lg z-10 transition-all"
                        aria-label="Next slide">
                        <svg class="h-4 w-4 sm:h-5 sm:w-5" viewBox="0 0 24 24" stroke="currentColor" fill="none">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>

                    {{-- Dot Indicators --}}
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        @foreach ($kegiatan as $index => $item)
                            <button @click="currentSlide = {{ $index }}"
                                class="w-2 h-2 sm:w-3 sm:h-3 rounded-full transition-all"
                                :class="currentSlide === {{ $index }} ? 'bg-white w-4 sm:w-6' : 'bg-white/50'"
                                aria-label="Go to slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sambutan --}}
            <div class="max-w-4xl mx-auto px-4 sm:px-6 mt-10">
                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-green-700 text-center leading-tight">
                    Selamat Datang di Posyandu Desa Talkandang
                </h1>
                <p class="mt-4 text-gray-700 text-sm sm:text-base md:text-lg text-center">
                    Posyandu adalah pilar layanan kesehatan desa yang mengintegrasikan pemantauan, imunisasi, dan
                    edukasi untuk memastikan
                    tumbuh kembang balita berjalan optimal serta mencegah stunting. Mari dukung bersama generasi
                    sehat dan cerdas.
                </p>
                <p class="mt-2 text-gray-700 text-sm sm:text-base md:text-lg text-center">
                    Layanan kesehatan terpadu untuk tumbuh kembang balita optimal melalui pemantauan berkala, imunisasi,
                    dan edukasi orang tua.
                </p>

                <div class="mt-8 space-y-8 text-gray-700  text-justify text-sm sm:text-base leading-relaxed">
                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-green-700 mb-2">1. Layanan Kesehatan Terpadu</h3>
                        <p>
                            Layanan kesehatan terpadu menyatukan berbagai layanan medis dan non-medis dalam satu tempat
                            seperti Posyandu. Kegiatan ini melibatkan tenaga medis (bidan, dokter), kader kesehatan, dan
                            masyarakat
                            untuk memberikan:
                        </p>
                        <ul class="list-disc pl-5 mt-2">
                            <li>Pemeriksaan pertumbuhan dan perkembangan balita</li>
                            <li>Imunisasi dasar lengkap</li>
                            <li>Penyuluhan gizi dan pola asuh anak</li>
                            <li>Pemberian makanan tambahan bila diperlukan</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-green-700 mb-2">2. Pemantauan Berkala</h3>
                        <p>
                            Pemantauan dilakukan secara rutin (setiap bulan) untuk mencatat tumbuh kembang balita:
                        </p>
                        <ul class="list-disc pl-5 mt-2">
                            <li>Mengukur berat dan tinggi badan anak</li>
                            <li>Memantau perkembangan motorik, bahasa, dan sosial</li>
                            <li>Membandingkan dengan standar KMS atau WHO</li>
                            <li>Mendeteksi dini masalah gizi atau tumbuh kembang</li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-green-700 mb-2">3. Imunisasi</h3>
                        <p>
                            Imunisasi melindungi balita dari penyakit menular berbahaya. Jenis imunisasi dasar meliputi:
                        </p>
                        <ul class="list-disc pl-5 mt-2">
                            <li>HB-0, BCG, DPT-HB-Hib</li>
                            <li>Polio tetes dan suntik</li>
                            <li>Campak dan Rubella (MR)</li>
                        </ul>
                        <p class="mt-2">
                            Manfaat imunisasi antara lain meningkatkan kekebalan tubuh dan menurunkan angka kematian bayi.
                        </p>
                    </div>

                    <div>
                        <h3 class="text-lg sm:text-xl font-semibold text-green-700 mb-2">4. Edukasi Orang Tua</h3>
                        <p>
                            Orang tua menjadi aktor utama dalam perawatan balita. Edukasi mencakup:
                        </p>
                        <ul class="list-disc pl-5 mt-2">
                            <li>ASI eksklusif dan pemberian MP-ASI yang tepat</li>
                            <li>Pola asuh yang mendukung tumbuh kembang</li>
                            <li>Menjaga kebersihan lingkungan dan sanitasi</li>
                            <li>Mengenal tanda bahaya pada anak</li>
                        </ul>
                    </div>
                </div>
            </div>


            {{-- Layanan Posyandu --}}
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-green-700 text-center mb-8">Layanan Utama Posyandu</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                    <div
                        class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="text-3xl mb-3 text-green-600">📌</div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Pemeriksaan Balita</h3>
                        <p class="text-sm text-gray-600">Pantau berat badan, tinggi, dan perkembangan balita setiap bulan.
                        </p>
                    </div>
                    <div
                        class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="text-3xl mb-3 text-green-600">💉</div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Imunisasi</h3>
                        <p class="text-sm text-gray-600">Lindungi anak dengan vaksinasi dasar dan lanjutan.</p>
                    </div>
                    <div
                        class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="text-3xl mb-3 text-green-600">⚖️</div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Pemantauan Gizi</h3>
                        <p class="text-sm text-gray-600">Deteksi dini stunting dan gizi buruk secara berkala.</p>
                    </div>
                    <div
                        class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="text-3xl mb-3 text-green-600">🧠</div>
                        <h3 class="font-semibold text-lg mb-2 text-gray-800">Edukasi Orang Tua</h3>
                        <p class="text-sm text-gray-600">Penyuluhan tentang ASI, MPASI, dan perawatan balita.</p>
                    </div>
                </div>
            </section>

            {{-- Jenis Imunisasi (Sebagian) --}}
            <div class="py-12 mt-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="lg:text-center">
                        <h2 class="text-2xl sm:text-3xl font-bold text-green-700">
                            Jenis Imunisasi Dasar
                        </h2>
                        <p class="mt-3 max-w-2xl mx-auto text-gray-500 sm:mt-4">
                            Perlindungan terbaik untuk buah hati Anda dari berbagai penyakit berbahaya
                        </p>
                    </div>

                    @if ($jenis->isEmpty())
                        <div class="mt-8 text-center py-12 bg-white rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-3 text-gray-600">Data imunisasi sedang dalam persiapan</p>
                        </div>
                    @else
                        <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach ($jenis as $item)
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="px-4 py-5 sm:p-6">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 bg-green-100 rounded-md p-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div class="ml-4">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $item->jenis_imunisasi }}
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-500">
                                                {{ $item->keterangan }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-8 text-center">
                            <a href="{{ route('home.jenis') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                                Lihat Semua Jenis Imunisasi
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 -mr-1 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>


            {{-- Materi Edukasi Terbaru --}}
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 mb-12">
                <h2 class="text-2xl sm:text-3xl font-bold text-green-700 text-center mb-8">
                    Materi Edukasi Terbaru
                </h2>

                @if ($edukasi->isEmpty())
                    <div class="text-center text-gray-500 italic">Belum ada materi edukasi saat ini.</div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($edukasi as $item)
                            <div
                                class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->judul }}"
                                    class="w-full h-48 object-cover">
                                <div class="p-6">
                                    <div class="flex items-center text-sm text-gray-500 mb-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->judul }}</h3>
                                    <p class="text-gray-600 text-sm mb-4">
                                        {{ \Illuminate\Support\Str::limit($item->penjelasan, 100) }}</p>
                                    <a href="{{ route('home.edukasi') }}"
                                        class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center transition duration-200">
                                        Lihat semua
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>


            {{-- Data Petugas --}}
            <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-green-700 text-center mb-8">
                    Data Petugas Posyandu
                </h2>

                {{-- Desktop View --}}
                <div class="hidden md:block overflow-x-auto rounded-lg shadow-sm border border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-green-50">
                            <tr>
                                <th class="px-4 py-3 text-center font-medium text-green-700">No</th>
                                <th class="px-4 py-3 text-left font-medium text-green-700">Nama</th>
                                <th class="px-4 py-3 text-left font-medium text-green-700">Jabatan</th>
                                <th class="px-4 py-3 text-center font-medium text-green-700">Jenis Kelamin</th>
                                <th class="px-4 py-3 text-left font-medium text-green-700">Status</th>
                                <th class="px-4 py-3 text-center font-medium text-green-700">No HP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($petugas as $no => $item)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-gray-500">{{ $no + 1 }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap font-medium text-gray-900">
                                        {{ $item->nama_petugas }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-gray-500">{{ $item->jabatan_petugas }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-gray-500">
                                        {{ $item->jenis_kelamin }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap">
                                        <span
                                            class="px-2 inline-flex text-xs font-semibold rounded-full 
                                            {{ $item->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-center text-gray-500">
                                        {{ $item->nomer_hp ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Mobile View --}}
                <div class="md:hidden space-y-4">
                    @foreach ($petugas as $item)
                        <div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-base font-medium text-gray-900">{{ $item->nama_petugas }}</h3>
                                    <p class="text-sm text-gray-500 mt-1">{{ $item->jabatan_petugas }}</p>
                                </div>
                                <span
                                    class="px-2 inline-flex text-xs font-semibold rounded-full 
                                    {{ $item->status == 'aktif' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </div>
                            <div class="mt-3 pt-3 border-t border-gray-100 grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <p class="text-gray-500">Jenis Kelamin</p>
                                    <p class="text-gray-800">{{ $item->jenis_kelamin }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">No HP</p>
                                    <p class="text-gray-800">{{ $item->nomer_hp ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- Jadwal Posyandu Bulan Ini --}}
            <div class="py-12" id="jadwal">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-2xl sm:text-3xl font-bold text-green-700">
                            Jadwal Posyandu Bulan Ini
                        </h2>
                        <p class="mt-3 max-w-2xl mx-auto text-gray-500 sm:mt-4">
                            {{ \Carbon\Carbon::now()->translatedFormat('F Y') }}
                        </p>
                    </div>

                    @if ($jadwalBulanIni->isEmpty())
                        <div class="mt-8 text-center py-12 bg-gray-50 rounded-lg shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-3 text-gray-600">Belum ada jadwal posyandu untuk bulan ini</p>
                        </div>
                    @else
                        <div class="mt-10 bg-white shadow overflow-hidden sm:rounded-lg">
                            <ul class="divide-y divide-gray-200">
                                @foreach ($jadwalBulanIni as $jadwal)
                                    <li>
                                        <div class="px-4 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <p class="text-sm font-medium text-green-600 truncate">
                                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_posyandu)->translatedFormat('l, d F Y') }}
                                                </p>
                                                <div class="ml-2 flex-shrink-0 flex">
                                                    <p
                                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        {{ $jadwal->waktu_mulai }} - {{ $jadwal->waktu_selesai }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-2 sm:flex sm:justify-between">
                                                <div class="sm:flex">
                                                    <p class="flex items-center text-sm text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        </svg>
                                                        {{ $jadwal->tempat->tempat_posyandu ?? 'Lokasi belum ditentukan' }}
                                                    </p>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p>
                                                        Sesi {{ $loop->iteration }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </main>

        {{-- Live Chat --}}
        <script type="text/javascript">
            var Tawk_API = Tawk_API || {},
                Tawk_LoadStart = new Date();
            (function() {
                var s1 = document.createElement("script"),
                    s0 = document.getElementsByTagName("script")[0];
                s1.async = true;
                s1.src = 'https://embed.tawk.to/67c411e1737286190ae91965/1ilaubm9i';
                s1.charset = 'UTF-8';
                s1.setAttribute('crossorigin', '*');
                s0.parentNode.insertBefore(s1, s0);
            })();
        </script>
    </div>
@endsection
