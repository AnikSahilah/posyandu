@extends('layout.admin')

@section('konten')
    <div x-data="{ openTambah: false, openEdit: false, editData: {}, showNotif: {{ session('success') ? 'true' : 'false' }} }" x-init="if (showNotif) setTimeout(() => showNotif = false, 3000)" class="flex-1 p-4 md:p-6">

        <!-- Notifikasi -->
        <div x-show="showNotif" x-cloak x-transition
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div @click.away="showNotif = false" class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-green-700">
                        <i class="fas fa-check-circle text-green-500 mr-2"></i> Notifikasi
                    </h2>
                    <button @click="showNotif = false" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="mt-4 text-gray-700">
                    {{ session('success') }}
                </div>
                <div class="mt-6 flex justify-center">
                    <button @click="showNotif = false" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        Oke
                    </button>
                </div>
            </div>
        </div>

        <!-- Header -->
        <header class="mb-6 text-center md:text-left">
            <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                <i class="fas fa-book-open bg-green-100 text-green-600 p-2 rounded-full"></i>
                Data Edukasi Posyandu
            </h1>
            <p class="text-gray-600">Kelola informasi edukasi untuk warga Posyandu.</p>
        </header>

        <!-- Tombol Tambah -->
        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="openTambah = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Edukasi</span>
            </button>
        </div>

        <!-- Tabel Data -->
        <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-white text-black">
                    <th class="px-4 py-4 text-center">No</th>
                    <th class="px-4 py-4 text-center">Gambar</th>
                    <th class="px-4 py-4 text-center">Judul</th>
                    <th class="px-4 py-4 text-center">Penjelasan</th>
                    <th class="px-4 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 border">
                @forelse ($edukasi as $no => $item)
                    <tr class="hover:bg-gray-200">
                        <td class="px-2 py-3 text-center">{{ $no + 1 }}</td>
                        <td class="px-2 py-3 text-center">
                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="Gambar"
                                class="w-14 h-14 object-cover mx-auto rounded-lg shadow-sm">
                        </td>
                        <td class="px-2 py-3 text-center">{{ $item->judul }}</td>
                        <td class="px-2 py-3 text-center">{{ Str::limit($item->penjelasan, 80) }}</td>
                        <td class="px-2 py-3 text-center space-x-1">
                            <!-- Tombol Edit -->
                            <button @click="editData = {{ json_encode($item) }}, openEdit = true"
                                class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                <i class="fas fa-edit"></i>
                            </button>
                            <!-- Tombol Hapus -->
                            <form action="{{ route('edukasi.delete1', $item->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Yakin hapus data ini?');"
                                    class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center py-8">
                                <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                <p class="text-lg font-medium text-gray-600">Belum ada data edukasi</p>
                                <p class="text-sm text-gray-500 mt-1">Silakan tambahkan edukasi baru untuk memulai</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal Tambah -->
        <div x-show="openTambah" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div @click.away="openTambah = false" class="bg-white w-[90%] sm:w-[500px] p-6 rounded-xl shadow-2xl">
                <h2 class="text-xl font-bold text-green-700 mb-4">➕ Tambah Edukasi Baru</h2>
                <form action="{{ route('edukasi.submit1') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <label class="block text-sm font-semibold mb-1">Judul Edukasi</label>
                    <input type="text" name="judul" placeholder="Masukkan judul..." required
                        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

                    <label class="block text-sm font-semibold mb-1">Penjelasan</label>
                    <textarea name="penjelasan" placeholder="Masukkan penjelasan..." rows="3" required
                        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>

                    <label class="block text-sm font-semibold mb-1">Gambar</label>
                    <input type="file" name="gambar" accept="image/*"
                        class="w-full border border-gray-300 rounded-lg file:py-2 file:px-4 file:border-0 file:bg-green-500 file:text-white hover:file:bg-green-600 transition">

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" @click="openTambah = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow transition">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div x-show="openEdit" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
            <div @click.away="openEdit = false" class="bg-white w-[90%] sm:w-[500px] p-6 rounded-xl shadow-2xl">
                <h2 class="text-xl font-bold text-green-700 mb-4">✏️ Edit Edukasi</h2>
                <form :action="'/edukasi/update1/' + editData.id" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf
                    <label class="block text-sm font-semibold mb-1">Judul Edukasi</label>
                    <input type="text" name="judul" x-model="editData.judul" required
                        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">

                    <label class="block text-sm font-semibold mb-1">Penjelasan</label>
                    <textarea name="penjelasan" x-model="editData.penjelasan" rows="3" required
                        class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>

                    <label class="block text-sm font-semibold mb-1">Gambar Saat Ini</label>
                    <template x-if="editData.gambar">
                        <div class="mb-3">
                            <img :src="`/storage/${editData.gambar}`"
                                class="w-24 h-24 object-cover rounded-lg shadow-sm mx-auto" />
                        </div>
                    </template>

                    <label class="block text-sm font-semibold mb-1">Ganti Gambar (Opsional)</label>
                    <input type="file" name="gambar" accept="image/*"
                        class="w-full border border-gray-300 rounded-lg file:py-2 file:px-4 file:border-0 file:bg-green-500 file:text-white hover:file:bg-green-600 transition">

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" @click="openEdit = false"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
