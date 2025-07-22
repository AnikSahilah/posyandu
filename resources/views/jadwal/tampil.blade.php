@extends('layout.admin')

@section('konten')
    @php
        $successMessage = session('success');
        $tahunIni = \Carbon\Carbon::now()->year;
        $minDate = \Carbon\Carbon::create($tahunIni, 1, 1)->format('Y-m-d');
        $maxDate = \Carbon\Carbon::create($tahunIni + 1, 12, 31)->format('Y-m-d');
    @endphp

    <div x-data="{ tambahModal: false, editModal: null, showNotif: {{ $successMessage ? 'true' : 'false' }} }" class="flex-1 p-4 md:p-6">

        {{-- Modal Notifikasi --}}
        <div x-show="showNotif" x-transition x-init="setTimeout(() => showNotif = false, 3000)" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 text-center">
                <h2 class="text-xl font-semibold text-green-700 mb-2">
                    <i class="fas fa-check-circle text-green-600 text-3xl mb-2"></i><br>
                    Berhasil!
                </h2>
                <p class="text-gray-700">{{ $successMessage }}</p>
                <div class="mt-4">
                    <button @click="showNotif = false" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Oke
                    </button>
                </div>
            </div>
        </div>

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-calendar-alt bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Data Jadwal Posyandu
                </h1>
                <p class="text-gray-600">Kelola jadwal Posyandu berdasarkan tempat & tahun</p>
            </div>
        </div>

        {{-- Filter Tahun --}}
        <div class="mb-6 flex flex-col md:flex-row items-start md:items-center gap-4">
            <form method="GET" action="{{ route('jadwal.tampil') }}" class="flex gap-2">
                <select name="tahun" onchange="this.form.submit()" class="border rounded px-3 py-2">
                    @foreach ($listTahun as $tahun)
                        <option value="{{ $tahun }}" {{ $tahun == $tahunDipilih ? 'selected' : '' }}>
                            Tahun {{ $tahun }}
                        </option>
                    @endforeach
                </select>
            </form>
            <p>Filter Tahun Jadwal Posyandu</p>
        </div>

        {{-- Tombol Tambah Jadwal --}}
        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="tambahModal = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all">
                <i class="fas fa-plus-circle"></i> Tambah Jadwal
            </button>
        </div>

        {{-- Tabel Jadwal --}}
        <div>
            <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white text-black">
                        <th class="px-4 py-4 text-center ">No</th>
                        <th class="px-4 py-4 text-center ">Tempat Posyandu</th>
                        <th class="px-4 py-4 text-center ">Tanggal Posyandu</th>
                        <th class="px-4 py-4 text-center ">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 border">
                    @forelse ($jadwal as $no => $data)
                        <tr class="hover:bg-gray-200">
                            <td class="px-2 py-3 text-center">{{ $jadwal->firstItem() + $no }}</td>
                            <td class="px-2 py-3 text-center">{{ $data->tempat->tempat_posyandu ?? '-' }}</td>
                            <td class="px-2 py-3 text-center">
                                {{ \Carbon\Carbon::parse($data->tanggal_posyandu)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-2 py-3 text-center space-x-1">
                                <button @click="editModal = {{ $data->id }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('jadwal.delete', $data->id) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                        title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-600">Belum ada jadwal posyandu</p>
                                    <p class="text-sm text-gray-500 mt-1">Silakan tambahkan jadwal untuk ditampilkan di
                                        sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $jadwal->links() }}
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div x-show="tambahModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="tambahModal = false" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <h2 class="text-xl font-semibold text-green-700 mb-4">Tambah Jadwal Posyandu</h2>
                <form action="{{ route('jadwal.submit') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Tempat Posyandu</label>
                        <select name="id_tempat" required class="w-full border rounded px-3 py-2">
                            <option value="" disabled selected>- Pilih Tempat -</option>
                            @foreach ($tempat as $t)
                                <option value="{{ $t->id }}">{{ $t->tempat_posyandu }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">Tanggal</label>
                        <input type="date" name="tanggal_posyandu" required class="w-full border rounded px-3 py-2"
                            min="{{ $minDate }}" max="{{ $maxDate }}">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="tambahModal = false" class="px-4 py-2 border rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        @foreach ($jadwal as $data)
            <div x-show="editModal === {{ $data->id }}" x-cloak
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div @click.away="editModal = null" class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                    <h2 class="text-xl font-semibold text-blue-700 mb-4">Edit Jadwal Posyandu</h2>
                    <form action="{{ route('jadwal.update', $data->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Tempat Posyandu</label>
                            <select name="id_tempat" required class="w-full border rounded px-3 py-2">
                                @foreach ($tempat as $t)
                                    <option value="{{ $t->id }}"
                                        {{ $data->id_tempat == $t->id ? 'selected' : '' }}>
                                        {{ $t->tempat_posyandu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-1 font-medium">Tanggal</label>
                            <input type="date" name="tanggal_posyandu" value="{{ $data->tanggal_posyandu }}" required
                                class="w-full border rounded px-3 py-2" min="{{ $minDate }}"
                                max="{{ $maxDate }}">
                        </div>
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="editModal = null"
                                class="px-4 py-2 border rounded">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

    </div>
@endsection
