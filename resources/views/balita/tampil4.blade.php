@extends('layout.admin')

@section('konten')
<div class="p-4 md:p-6 transition-all duration-200 ease-in-out">

    <!-- Header -->
    <header class="mb-6 text-center md:text-left">
        <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
            <i class="fas fa-child bg-green-100 text-green-600 p-2 rounded-full"></i>
            Data Balita Posyandu
        </h1>
        <p class="text-gray-600">Kelola Data Master Balita Posyandu</p>
    </header>
    {{-- Notifikasi sukses --}}
    @if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"
        x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif


    <!-- Filter Tempat -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 mb-4 gap-4">
        <form method="GET" action="{{ route('balita.tampil4') }}"
            class="bg-white p-3 rounded shadow text-sm border w-full md:w-auto">
            <div class="flex flex-wrap items-center gap-4">
                <div class="font-semibold text-gray-800">Filter Tempat:</div>
                <label class="flex items-center gap-1">
                    <input type="radio" name="filter_tempat" value=""
                        {{ request('filter_tempat') == '' ? 'checked' : '' }} onchange="this.form.submit()" />
                    <span>Semua</span>
                </label>
                @foreach ($tempat as $t)
                <label class="flex items-center gap-1">
                    <input type="radio" name="filter_tempat" value="{{ $t->id }}"
                        {{ request('filter_tempat') == $t->id ? 'checked' : '' }} onchange="this.form.submit()" />
                    <span>{{ $t->tempat_posyandu }}</span>
                </label>
                @endforeach

                @if (request('cari'))
                <input type="hidden" name="cari" value="{{ request('cari') }}">
                @endif
            </div>
        </form>
    </div>

    <!-- Import Excel -->
    <!-- <div class="bg-white p-4 rounded-xl shadow border border-gray-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-file-excel text-green-600 mr-2"></i>
                Import Data Excel
            </h3>
            <form action="{{ route('balita.import') }}" method="POST" enctype="multipart/form-data" class="space-y-3"
                x-data="{ file: null }">
                @csrf
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File</label>
                        <div class="flex items-center gap-2">
                            <label class="flex-1 cursor-pointer">
                                <div
                                    class="flex items-center px-3 py-2 bg-gray-50 rounded-lg border border-gray-300 hover:border-green-500">
                                    <i class="fas fa-file-excel text-green-600 mr-2"></i>
                                    <span x-text="file ? file.name : 'Pilih file...'"
                                        class="text-sm text-gray-600 truncate"></span>
                                    <input type="file" name="file" class="hidden" x-ref="fileInput"
                                        @change="file = $refs.fileInput.files[0]" accept=".xlsx,.xls,.csv">
                                </div>
                            </label>
                            <button type="button" @click="$refs.fileInput.click()"
                                class="px-3 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm">
                                <i class="fas fa-search mr-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit"
                            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg shadow">
                            <i class="fas fa-upload"></i>
                            <span class="hidden sm:inline">Import</span>
                        </button>
                    </div>
                </div>
                @if ($errors->any())
                    <div class="mt-2 p-2 bg-red-50 border-l-4 border-red-500 text-red-700 rounded text-sm">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ $errors->first() }}
                    </div>
                @endif
                @if (session('import_success'))
                    <div class="mt-2 p-2 bg-green-50 border-l-4 border-green-500 text-green-700 rounded text-sm">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('import_success') }}
                    </div>
                @endif
            </form>
        </div> -->

    <!-- Tambah & Pencarian -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mt-6 mb-4 gap-4">
        <a href="{{ route('balita.tambah4') }}"
            class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all transform hover:scale-105">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Balita</span>
        </a>

        <form method="GET" action="{{ route('balita.tampil4') }}"
            class="flex flex-col sm:flex-row sm:items-center gap-2">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari Nama Balita..."
                class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm w-full sm:w-64" />
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">Cari</button>
            @if (request('cari'))
            <a href="{{ route('balita.tampil4', ['filter_tempat' => request('filter_tempat')]) }}"
                class="text-sm text-gray-500 hover:underline">Reset</a>
            @endif
            <input type="hidden" name="filter_tempat" value="{{ request('filter_tempat') }}">
        </form>
    </div>

    <!-- Tabel Data -->
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-white text-black">
                    <th class="px-4 py-4 text-center">No</th>
                    <th class="px-4 py-4 text-center">NIK Balita</th>
                    <th class="px-4 py-4 text-center">Nama Balita</th>
                    <th class="px-4 py-4 text-center">Jenis Kelamin</th>
                    <th class="px-4 py-4 text-center">Tempat Posyandu</th>
                    <th class="px-4 py-4 text-center">RT / RW</th>
                    <th class="px-4 py-4 text-center">Buku KIA</th>
                    <th class="px-4 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 border">
                @forelse ($balita as $no => $b)
                <tr class="hover:bg-gray-100">
                    <td class="px-2 py-3 text-center">{{ $balita->firstItem() + $no }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->nik_balita }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->nama_balita }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->jenis_kelamin }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->tempat->tempat_posyandu ?? '-' }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->rt }} / {{ $b->rw }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->buku_kia }}</td>
                    <td class="px-2 py-3 text-center space-x-1">
                        <a href="{{ route('balita.lihat4', $b->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                            title="Lihat Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('balita.edit4', $b->id) }}" title="Edit"
                            class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('balita.delete4', $b->id) }}" method="post" class="inline">
                            @csrf
                            <button type="submit" onclick="return confirm('Hapus data ini?');" title="Hapus"
                                class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                            <p class="text-lg font-medium text-gray-600">Belum ada data balita</p>
                            <p class="text-sm text-gray-500 mt-1">Silakan tambahkan balita untuk ditampilkan di
                                sini.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $balita->links('pagination::tailwind') }}
    </div>
</div>
@endsection