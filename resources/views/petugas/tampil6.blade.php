@extends('layout.admin')

@section('konten')
    {{-- Pastikan Alpine.js dimuat di layout.admin --}}
    <div class="p-6" x-data="{ tambahModal: false, editModal: false, selectedPetugas: {} }">

        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white px-6 py-4 rounded shadow-lg max-w-sm text-center">
                    <h2 class="text-lg font-semibold text-green-700 mb-2">Sukses!</h2>
                    <p class="text-gray-700 mb-4">{{ session('success') }}</p>
                    <button @click="show = false"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                        Oke
                    </button>
                </div>
            </div>
        @endif

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-user-nurse bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Data Petugas Posyandu
                </h1>
                <p class="text-gray-600">Kelola Petugas Layanan Kegiatan Posyandu</p>
            </div>
        </div>


        {{-- Tombol Tambah --}}
        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="tambahModal = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Petugas</span>
            </button>
        </div>

        {{-- Tabel Data --}}
        <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-white text-black">
                    <th class="px-4 py-4 text-center">No</th>
                    <th class="px-4 py-4 text-center">Nama</th>
                    <th class="px-4 py-4 text-center">Jabatan</th>
                    <th class="px-4 py-4 text-center">Jenis Kelamin</th>
                    <th class="px-4 py-4 text-center">Status</th>
                    <th class="px-4 py-4 text-center">No HP</th>
                    <th class="px-4 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 border">
                @forelse ($data as $no => $item)
                    <tr class="hover:bg-gray-200">
                        <td class="px-2 py-3 text-center">{{ $no + 1 }}</td>
                        <td class="px-2 py-3 text-center">{{ $item->nama_petugas }}</td>
                        <td class="px-2 py-3 text-center">{{ $item->jabatan_petugas }}</td>
                        <td class="px-2 py-3 text-center">{{ $item->jenis_kelamin }}</td>
                        <td class="px-2 py-3 text-center">{{ $item->status }}</td>
                        <td class="px-2 py-3 text-center">{{ $item->nomer_hp }}</td>
                        <td class="px-2 py-3 text-center space-x-1">
                            <button @click="editModal = true; selectedPetugas = {{ $item }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                <i class="fas fa-edit"></i></button>
                            <form action="{{ route('petugas.delete6', $item->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                    <i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                <p class="text-lg font-medium text-gray-600">Belum ada data petugas</p>
                                <p class="text-sm text-gray-500 mt-1">Silakan tambahkan petugas untuk ditampilkan di sini.
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        {{-- Modal Tambah --}}
        <div x-show="tambahModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Tambah Petugas</h2>
                <form action="{{ route('petugas.submit6') }}" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Petugas</label>
                    <input type="text" name="nama_petugas" placeholder="Nama" class="w-full mb-2 p-2 border rounded">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Petugas</label>
                    <input type="text" name="jabatan_petugas" placeholder="Jabatan"
                        class="w-full mb-2 p-2 border rounded">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="w-full mb-2 p-2 border rounded">
                        <option value="">Pilih Jenis Kelamin</option>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full mb-2 p-2 border rounded">
                        <option value="">Pilih Status</option>
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>

                    <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" name="nomer_hp" placeholder="Nomor HP" class="w-full mb-4 p-2 border rounded">

                    <div class="flex justify-center">
                        <button type="button" @click="tambahModal = false"
                            class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div x-show="editModal" x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
            <div class="bg-white p-6 rounded w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Edit Petugas</h2>
                <form :action="'/petugas/update6/' + selectedPetugas.id" method="POST">
                    @csrf
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Petugas</label>
                    <input type="text" name="nama_petugas" x-model="selectedPetugas.nama_petugas"
                        class="w-full mb-2 p-2 border rounded">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jabatan Petugas</label>
                    <input type="text" name="jabatan_petugas" x-model="selectedPetugas.jabatan_petugas"
                        class="w-full mb-2 p-2 border rounded">

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                    <select name="jenis_kelamin" x-model="selectedPetugas.jenis_kelamin"
                        class="w-full mb-2 p-2 border rounded">
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" x-model="selectedPetugas.status" class="w-full mb-2 p-2 border rounded">
                        <option value="aktif">Aktif</option>
                        <option value="tidak aktif">Tidak Aktif</option>
                    </select>

                    <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
                    <input type="text" name="nomer_hp" x-model="selectedPetugas.nomer_hp"
                        class="w-full mb-4 p-2 border rounded">

                    <div class="flex justify-end">
                        <button type="button" @click="editModal = false"
                            class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
