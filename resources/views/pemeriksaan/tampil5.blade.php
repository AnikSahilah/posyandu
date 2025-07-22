@extends('layout.admin')

@section('konten')
    <div class="flex-1 p-6 transition-all duration-200 ease-in-out">
        <header class="mb-6 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                <i class="fas fa-chart-line bg-green-100 text-green-600 p-2 rounded-full"></i>
                Data Pemeriksaan Balita
            </h1>
            <p class="text-gray-600">Kelola Hasil Pemeriksaan Balita Posyandu.</p>
        </header>

        <!-- === FILTER TEMPAT === -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 mb-4 gap-4">
            <form method="GET" action="{{ route('pemeriksaan.tampil5') }}"
                class="bg-white p-3 rounded shadow text-sm border w-full md:w-auto">
                <div class="text-sm">
                    <div class="flex flex-col md:flex-row md:items-center gap-4">
                        <span class="font-semibold text-gray-800">Filter Tempat:</span>
                        <div class="flex flex-wrap gap-4">
                            <label class="flex items-center gap-1">
                                <input type="radio" name="filter_tempat" value=""
                                    {{ request('filter_tempat') == '' ? 'checked' : '' }} onchange="this.form.submit()" />
                                <span>Semua</span>
                            </label>
                            @foreach ($tempat as $t)
                                <label class="flex items-center gap-1">
                                    <input type="radio" name="filter_tempat" value="{{ $t->id }}"
                                        {{ request('filter_tempat') == $t->id ? 'checked' : '' }}
                                        onchange="this.form.submit()" />
                                    <span>{{ $t->tempat_posyandu }}</span>
                                </label>
                            @endforeach
                        </div>

                        @if (request('cari'))
                            <input type="hidden" name="cari" value="{{ request('cari') }}">
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <!-- === FITUR SEARCH === -->
        <form method="GET" action="{{ route('pemeriksaan.tampil5') }}" class="mb-4">
            <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
                <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Nama Balita..."
                    class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm w-full sm:w-64" />
                @if (request('filter_tempat'))
                    <input type="hidden" name="filter_tempat" value="{{ request('filter_tempat') }}">
                @endif
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">
                    Cari
                </button>
                @if (request('cari'))
                    <a href="{{ route('pemeriksaan.tampil5', ['filter_tempat' => request('filter_tempat')]) }}"
                        class="text-sm text-gray-500 hover:underline">
                        Reset
                    </a>
                @endif
            </div>
        </form>

        @if (session('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" x-transition
                class="mb-4 px-4 py-3 rounded-md bg-red-100 text-red-800 border border-red-300 shadow">
                <div class="flex justify-between items-center">
                    <span class="font-semibold">
                        <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                    </span>
                    <button @click="show = false" class="text-red-700 hover:text-red-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        @endif

        <!-- === TABEL BALITA === -->
        <div class="rounded-lg border">
            <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white text-black">
                        <th class="px-4 py-4 text-center">NO</th>
                        <th class="px-4 py-4 text-center">Nama Balita</th>
                        <th class="px-4 py-4 text-center">Jenis Kelamin</th>
                        <th class="px-4 py-4 text-center">Tempat</th>
                        <th class="px-4 py-4 text-center">Petugas</th>
                        <th class="px-4 py-4 text-center">Tanggal</th>
                        <th class="px-4 py-4 text-center">Umur</th>
                        <th class="px-4 py-4 text-center">BB</th>
                        <th class="px-4 py-4 text-center">TB</th>
                        <th class="px-4 py-4 text-center">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 border">
                    @forelse ($balita as $no => $data)
                        @php
                            $pemeriksaan = $data->pemeriksaan_balita->first();
                            $status = $pemeriksaan?->status ?? '-';
                            $warna = match ($status) {
                                'Gizi Baik' => 'text-green-600',
                                'Gizi Kurang' => 'text-yellow-500',
                                'Gizi Buruk' => 'text-red-600',
                                'Stunting' => 'text-orange-500',
                                'Perlu Pemeriksaan Lanjut' => 'text-blue-500',
                                'Umur tidak valid' => 'text-gray-400',
                                default => 'text-gray-500',
                            };
                        @endphp

                        <tr class="hover:bg-gray-100 text-center">
                            <td class="px-2 py-3 ">{{ $balita->firstItem() + $no }}</td>
                            <td class="px-2 py-3 ">{{ $data->nama_balita }}</td>
                            <td class="px-2 py-3 ">{{ $data->jenis_kelamin }}</td>
                            <td class="px-2 py-3 ">{{ $data->tempat->tempat_posyandu ?? '-' }}</td>
                            <td class="px-2 py-3 ">
                                {{ $pemeriksaan?->petugas?->nama_petugas ?? '-' }}
                            </td>
                            <td class="px-2 py-3 ">
                                {{ $pemeriksaan?->tanggal_pemeriksaan
                                    ? \Carbon\Carbon::parse($pemeriksaan->tanggal_pemeriksaan)->translatedFormat('d F Y')
                                    : '-' }}
                            </td>
                            <td class="px-2 py-3 ">{{ $pemeriksaan?->umur ?? '-' }}</td>
                            <td class="px-2 py-3 ">{{ $pemeriksaan?->berat_badan ?? '-' }}</td>
                            <td class="px-2 py-3 ">{{ $pemeriksaan?->tinggi_badan ?? '-' }}</td>
                            <td class="px-2 py-3  font-semibold">
                                <span class="{{ $warna }}">{{ $status }}</span>
                            </td>
                            <td class="px-2 py-3  space-x-2">
                                <a href="{{ route('pemeriksaan.tambah5', ['id_balita' => $data->id, 'page' => request('page')]) }}"
                                    title="Tambah Pemeriksaan" class="text-green-500 hover:text-green-700">
                                    <i class="fas fa-plus-circle text-xl"></i>
                                </a>

                                <a href="{{ route('pemeriksaan.lihat5', $data->id) }}" title="Lihat Detail"
                                    class="text-yellow-500 hover:text-yellow-700">
                                    <i class="fas fa-eye text-xl"></i>
                                </a>
                                @if ($pemeriksaan)
                                    <a href="{{ route('pemeriksaan.edit5', $pemeriksaan->id) }}" title="Edit Pemeriksaan"
                                        class="text-blue-500 hover:text-blue-700">
                                        <i class="fas fa-edit text-xl"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-600">Belum ada data pemeriksaan balita</p>
                                    <p class="text-sm text-gray-500 mt-1">Silakan tambahkan pemeriksaan balita untuk
                                        ditampilkan di
                                        sini.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if ($balita->hasPages())
                <div class="p-4">
                    {{ $balita->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection
