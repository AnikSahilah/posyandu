@extends('layout.admin')

@section('konten')
    <div class="p-6" x-data="{ tambahModal: false, editModal: false, selectedJenis: {} }">

        @if (session('success'))
            <div x-data="{ showModal: true }" x-show="showModal" x-transition
                class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 text-center">
                    <h2 class="text-xl font-semibold text-green-700 mb-2">
                        <i class="fas fa-check-circle text-green-500 mr-1"></i> Berhasil!
                    </h2>
                    <p class="text-gray-700">{{ session('success') }}</p>
                    <button @click="showModal = false"
                        class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Oke
                    </button>
                </div>
            </div>
        @endif


        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-vial bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Data Jenis Imunisasi
                </h1>
                <p class="text-gray-600">Kelola Data Jenis Imunisasi Balita</p>
            </div>
        </div>

        {{-- Tombol Tambah --}}
        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="tambahModal = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all">
                <i class="fas fa-plus-circle"></i> Tambah Jenis
            </button>
        </div>

        {{-- Tabel --}}
        <div>
            <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white text-black">
                        <th class="px-4 py-4 text-center">No</th>
                        <th class="px-4 py-4 text-center">Jenis Imunisasi</th>
                        <th class="px-4 py-4 text-center">Keterangan</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 border">
                    @forelse ($data as $i => $item)
                        <tr class="hover:bg-gray-200">
                            <td class="px-2 py-3 text-center">{{ $data->firstItem() + $i }}</td>
                            <td class="px-2 py-3 text-center">{{ $item->jenis_imunisasi }}</td>
                            <td class="px-2 py-3 text-center">{{ $item->keterangan }}</td>

                            <td class="px-2 py-3 text-center space-x-1">
                                <button @click="editModal = true; selectedJenis = {{ Js::from($item) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                    title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <form action="{{ route('jenis.delete7', $item->id) }}" method="POST" class="inline-block"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition"
                                        title="Hapus">
                                        <i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-600">Belum ada data jenis</p>
                                    <p class="text-sm text-gray-500 mt-1">Silakan tambahkan jenis untuk ditampilkan di
                                        sini.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{-- Navigasi Pagination --}}
            <div class="mt-6">
                {{ $data->links('pagination::tailwind') }}
            </div>
        </div>

        {{-- Modal Tambah --}}
        <div x-show="tambahModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Tambah Jenis Imunisasi</h2>
                <form action="{{ route('jenis.submit7') }}" method="POST">
                    @csrf

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Imunisasi :</label>
                    <input type="text" name="jenis_imunisasi" placeholder="Masukkan Jenis Imunisasi"
                        class="w-full mb-2 p-2 border rounded" required>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan :</label>
                    <textarea name="keterangan" placeholder="Masukkan Keterangan Jenis Imunisasi" class="w-full mb-4 p-2 border rounded"
                        required></textarea>

                    <div class="flex justify-end">
                        <button type="button" @click="tambahModal = false"
                            class="mr-2 px-4 py-2 bg-gray-300 rounded">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Modal Edit --}}
        <div x-show="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg w-full max-w-md">
                <h2 class="text-xl font-bold mb-4">Edit Jenis Imunisasi</h2>
                <form :action="'/jenis/update7/' + selectedJenis.id" method="POST">
                    @csrf

                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Imunisasi :</label>
                    <input type="text" name="jenis_imunisasi" x-model="selectedJenis.jenis_imunisasi"
                        class="w-full mb-2 p-2 border rounded" required>

                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan :</label>
                    <textarea name="keterangan" x-model="selectedJenis.keterangan" class="w-full mb-4 p-2 border rounded" required></textarea>

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
