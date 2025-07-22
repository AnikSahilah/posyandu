@extends('layout.admin')

@section('konten')
    <div x-data="{
        tambahModal: false,
        editModal: null,
        showNotif: {{ session('success') ? 'true' : 'false' }}
    }" x-init="if (showNotif) setTimeout(() => showNotif = false, 3000)" class="flex-1 p-4 md:p-6">

        {{-- Modal Notifikasi Sukses --}}
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


        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-notes-medical bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Data Kegiatan Posyandu
                </h1>
                <p class="text-gray-600">Kelola kegiatan dalam pelaksanaan posyandu</p>
            </div>
        </div>

        <div class="mb-6 flex justify-center md:justify-start">
            <button @click="tambahModal = true"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2.5 rounded-lg shadow-md transition-all transform hover:scale-105">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Kegiatan</span>
            </button>
        </div>

        {{-- Table Container --}}
        <div>
            <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-white text-black">
                        <th class="px-4 py-4 text-center">No</th>
                        <th class="px-4 py-4 text-center">Gambar</th>
                        <th class="px-4 py-4 text-center">Judul</th>
                        <th class="px-4 py-4 text-center">Keterangan</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300 border">
                    @forelse($kegiatan as $no => $data)
                        <tr class="hover:bg-gray-200">
                            <td class="px-2 py-3 text-center">{{ $no + 1 }}
                            </td>
                            <td class="px-2 py-3 text-center">
                                <div class="flex justify-center">
                                    <img src="{{ asset('storage/' . $data->foto) }}"
                                        class="w-16 h-16 object-cover rounded-lg shadow-sm border border-gray-200">
                                </div>
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ $data->judul }}
                            </td>
                            <td class="px-2 py-3 text-center">
                                {{ Str::limit($data->keterangan, 50) }}
                            </td>
                            <td class="px-2 py-3 text-center space-x-1">
                                <div class="flex justify-center space-x-2">
                                    <button @click="editModal = {{ $data->id }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('kegiatan.delete3', $data->id) }}" method="post"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini?');">
                                        @csrf
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white text-sm px-3 py-1.5 rounded-md shadow transition">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center py-8">
                                    <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                                    <p class="text-lg font-medium text-gray-600">Belum ada kegiatan</p>
                                    <p class="text-sm text-gray-500 mt-1">Tambahkan kegiatan baru untuk memulai</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal Tambah Kegiatan --}}
        <div x-show="tambahModal" x-cloak x-transition class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="tambahModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity" @click="tambahModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="tambahModal" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-calendar-plus text-green-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Tambah Kegiatan Posyandu
                                </h3>
                                <div class="mt-4">
                                    <form action="{{ route('kegiatan.submit3') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Judul
                                                    Kegiatan</label>
                                                <input type="text" name="judul" placeholder="Judul Kegiatan"
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md"
                                                    required>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                                <textarea name="keterangan" placeholder="Deskripsi kegiatan" rows="3"
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-green-500 focus:border-green-500 sm:text-sm rounded-md"
                                                    required></textarea>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Gambar
                                                    Kegiatan</label>
                                                <div
                                                    class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                    <div class="space-y-1 text-center">
                                                        <div class="flex text-sm text-gray-600">
                                                            <label
                                                                class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
                                                                <span>Upload file</span>
                                                                <input type="file" name="foto" class="sr-only"
                                                                    required>
                                                            </label>
                                                            <p class="pl-1">atau drag and drop</p>
                                                        </div>
                                                        <p class="text-xs text-gray-500">
                                                            PNG, JPG, JPEG maksimal 2MB
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                            <button type="button" @click="tambahModal = false"
                                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                Batal
                                            </button>
                                            <button type="submit"
                                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:col-start-2 sm:text-sm">
                                                Simpan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit Kegiatan --}}
        @foreach ($kegiatan as $data)
            <div x-show="editModal === {{ $data->id }}" x-cloak x-transition
                class="fixed inset-0 z-50 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="editModal === {{ $data->id }}" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity"
                        @click="editModal = null">
                        <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                    </div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                    <div x-show="editModal === {{ $data->id }}" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div
                                    class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <i class="fas fa-edit text-green-600"></i>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Edit Kegiatan Posyandu
                                    </h3>
                                    <div class="mt-4">
                                        <form action="{{ route('kegiatan.update3', $data->id) }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Judul
                                                        Kegiatan</label>
                                                    <input type="text" name="judul" value="{{ $data->judul }}"
                                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                        required>
                                                </div>
                                                <div>
                                                    <label
                                                        class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                                                    <textarea name="keterangan" rows="3"
                                                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
                                                        required>{{ $data->keterangan }}</textarea>
                                                </div>
                                                <div>
                                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar
                                                        Kegiatan</label>
                                                    @if ($data->foto)
                                                        <div class="mb-3">
                                                            <img src="{{ asset('storage/' . $data->foto) }}"
                                                                class="w-32 h-32 object-cover rounded-lg shadow border border-gray-200">
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                                        <div class="space-y-1 text-center">
                                                            <div class="flex text-sm text-gray-600">
                                                                <label
                                                                    class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none">
                                                                    <span>Ubah gambar</span>
                                                                    <input type="file" name="foto" class="sr-only">
                                                                </label>
                                                            </div>
                                                            <p class="text-xs text-gray-500">
                                                                PNG, JPG, JPEG maksimal 2MB
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:grid-flow-row-dense">
                                                <button type="button" @click="editModal = null"
                                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:col-start-1 sm:text-sm">
                                                    Batal
                                                </button>
                                                <button type="submit"
                                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:col-start-2 sm:text-sm">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
