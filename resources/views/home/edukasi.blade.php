@extends('home.layout')

@section('content')
    <div class="container mx-auto px-4 py-8" x-data="edukasiFilter()">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-green-500 to-teal-600 rounded-xl p-8 mb-8 text-white">
            <div class="max-w-3xl">
                <h1 class="text-4xl font-bold mb-4">Edukasi Kesehatan Posyandu</h1>
                <p class="text-xl mb-6">Informasi terpercaya untuk kesehatan ibu dan anak dari tenaga kesehatan profesional
                </p>
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Terakhir diperbarui: {{ now()->format('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Artikel Unggulan -->
        @if ($edukasi->count() > 0)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                    Artikel Unggulan
                </h2>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0 md:w-1/3">
                            <img class="h-full w-full object-cover" src="{{ asset('storage/' . $edukasi[0]->gambar) }}"
                                alt="{{ $edukasi[0]->judul }}">
                        </div>
                        <div class="p-8">
                            <div class="uppercase tracking-wide text-sm text-green-600 font-semibold">Artikel Terbaru</div>
                            <h3 class="mt-2 text-2xl font-semibold text-gray-800 leading-tight">{{ $edukasi[0]->judul }}
                            </h3>
                            <p class="mt-3 text-gray-600">{{ Str::limit($edukasi[0]->penjelasan, 200) }}</p>
                            <div class="mt-4">
                                <button @click="bukaModal(@js($edukasi[0]))"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition duration-200">
                                    Baca Selengkapnya
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Semua Artikel -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-green-600" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                </svg>
                Semua Materi Edukasi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="item in filteredEdukasi" :key="item.id">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-300">
                        <img :src="'/storage/' + item.gambar" :alt="item.judul" class="w-full h-48 object-cover">
                        <div class="p-6">
                            <div class="flex items-center text-sm text-gray-500 mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span
                                    x-text="new Date(item.created_at).toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })"></span>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2" x-text="item.judul"></h3>
                            <p class="text-gray-600 text-sm mb-4" x-text="item.penjelasan.substring(0, 100) + '...'"></p>
                            <button @click="bukaModal(item)"
                                class="text-green-600 hover:text-green-800 text-sm font-medium flex items-center transition duration-200">
                                Baca selengkapnya
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Modal Edukasi -->
        <div x-show="modalOpen" x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="modalOpen = false"
                class="bg-white rounded-lg p-6 max-w-xl w-full max-h-[90vh] overflow-y-auto">
                <h2 class="text-xl font-bold mb-4 text-green-700" x-text="modalData.judul"></h2>
                <img :src="'/storage/' + modalData.gambar" class="w-full h-64 object-cover rounded mb-4">
                <p x-text="modalData.penjelasan" class="text-gray-700 whitespace-pre-line"></p>
                <div class="mt-4 text-right">
                    <button @click="modalOpen = false"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg transition">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- AlpineJS Script -->
    <script>
        function edukasiFilter() {
            return {
                search: '',
                modalOpen: false,
                modalData: {},
                edukasi: @json($edukasi->slice(1)),
                get filteredEdukasi() {
                    if (!this.search) return this.edukasi;
                    return this.edukasi.filter(item => item.judul.toLowerCase().includes(this.search.toLowerCase()));
                },
                bukaModal(item) {
                    this.modalData = item;
                    this.modalOpen = true;
                }
            }
        }
    </script>
@endsection
