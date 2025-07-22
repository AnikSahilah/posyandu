@extends('layout.admin')

@section('konten')
    <div class="p-6 bg-gray-50">
        <div class="mx-auto">
            <header class="mb-8">
                <h1 class="text-2xl font-medium text-gray-800">Tambah Data Balita</h1>
                <p class="text-gray-500 mt-2 text-sm">Isi formulir dengan data lengkap balita</p>
            </header>

            <div class="bg-white rounded-lg p-6 shadow-xs border border-gray-100">
                <form action="{{ route('balita.submit4') }}" method="post" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NIK Balita</label>
                                <input type="text" name="nik_balita"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Masukkan NIK" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Nama
                                    Balita</label>
                                <input type="text" name="nama_balita"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Nama lengkap balita" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Anak Ke</label>
                                <input type="number" name="balita_ke"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Urutan anak" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Tanggal
                                    Lahir</label>
                                <input type="date" name="tanggal_lahir"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    required>
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Berat Badan Lahir
                                    (KG)</label>
                                <input type="number" step="0.01" name="berat_badan_lahir"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="2.8" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Tinggi Lahir
                                    (CM)</label>
                                <input type="number" step="0.1" name="tinggi_lahir"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="49.5" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Jenis
                                    Kelamin</label>
                                <select name="jenis_kelamin"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    required>
                                    <option value="">Pilih jenis kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Nama Orang
                                    Tua</label>
                                <input type="text" name="nama_orang_tua"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Nama lengkap orang tua" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NIK Orang
                                    Tua</label>
                                <input type="text" name="nik_orang_tua"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="NIK orang tua" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">No HP</label>
                                <input type="text" name="no_hp"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="08xxxxxxx" required>
                            </div>

                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 my-4"></div>

                    <!-- Second Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Tempat
                                    Posyandu</label>
                                <select name="id_tempat"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    required>
                                    <option value="">Pilih posyandu</option>
                                    @foreach ($tempat as $t)
                                        <option value="{{ $t->id }}">{{ $t->tempat_posyandu }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">RT</label>
                                    <input type="number" name="rt"
                                        class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                        placeholder="001" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">RW</label>
                                    <input type="number" name="rw"
                                        class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                        placeholder="001" required>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Buku KIA</label>
                                <input type="text" name="buku_kia"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Contoh : 1" required>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">Inisiasi Menyusui
                                    Dini (IMD)</label>
                                <input type="text" name="inisiasi_menyusui_dini"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    placeholder="Ya/Tidak">
                            </div>
                        </div>
                    </div>

                    <div class="pt-8">
                        <button type="submit"
                            class="w-full py-3 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-1">
                            Simpan Data Balita
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
