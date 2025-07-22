@extends('layout.admin')

@section('konten')
    <div class="p-6" x-data="{ tambahModal: false, editModal: false, selected: {} }">
        @if (session('success'))
            <div x-data="{ showFlash: true }" x-show="showFlash" x-transition
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm text-center"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90">
                    <h2 class="text-xl font-bold text-green-700 mb-2">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i> Berhasil
                    </h2>
                    <p class="text-gray-700">{{ session('success') }}</p>
                    <button @click="showFlash = false"
                        class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Tutup
                    </button>
                </div>
            </div>
        @endif


        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-map-marker-alt bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Data Tempat Posyandu
                </h1>
                <p class="text-gray-600">Kelola Data Tempat Posyandu Desa Talkandang</p>
            </div>
        </div>

        <!-- Tombol Tambah -->
        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="tambahModal = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Tempat Posyandu</span>
            </button>
        </div>

        <!-- Tabel Data -->
        <div>
            <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white text-black">
                        <th class="px-4 py-4 text-center">No</th>
                        <th class="px-4 py-4 text-center">Tempat Posyandu</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 border">
                    @forelse($tempat as $no => $row)
                        <tr class="hover:bg-gray-200">
                            <td class="px-2 py-3 text-center">{{ $no + 1 }}</td>
                            <td class="px-2 py-3 text-center">{{ $row->tempat_posyandu }}</td>
                            <td class="px-2 py-3 text-center space-x-1">
                                <button @click="editModal = true; selected = {{ Js::from($row) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('tempat.delete12', $row->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                        title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-600">Belum ada data tempat</p>
                                    <p class="text-sm text-gray-500 mt-1">Silakan tambahkan tempat untuk ditampilkan di
                                        sini.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Modal Tambah -->
        <div x-show="tambahModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
            x-cloak>
            <div class="bg-white p-6 rounded shadow w-96">
                <h2 class="text-xl font-semibold mb-4">Tambah Tempat</h2>
                <form action="{{ route('tempat.submit12') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tempat_posyandu" class="block mb-1">Tempat Posyandu</label>
                        <input type="text" name="tempat_posyandu" required
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="tambahModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="editModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" x-cloak>
            <div class="bg-white p-6 rounded shadow w-96">
                <h2 class="text-xl font-semibold mb-4">Edit Tempat</h2>
                <form :action="`/tempat/update12/${selected.id}`" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="tempat_posyandu" class="block mb-2">Tempat Posyandu :</label>
                        <input type="text" name="tempat_posyandu" :value="selected.tempat_posyandu"
                            class="w-full px-3 py-2 border rounded focus:outline-none focus:ring" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="editModal = false"
                            class="px-4 py-2 bg-gray-400 text-white rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
