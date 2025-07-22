@extends('layout.admin')

@section('konten')
    <div class="p-6 min-h-screen bg-gray-50">
        <div class=" mx-auto">
            <header class="mb-6">
                <h1 class="text-2xl font-medium text-gray-800">Edit Data Balita</h1>
                <p class="text-gray-500 mt-1 text-sm">Posyandu Desa Talkandang</p>
            </header>

            <div class="bg-white rounded-lg p-6 shadow-xs border border-gray-100">
                <form action="{{ route('balita.update4', $balita->id) }}" method="post" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Column 1 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NIK BALITA</label>
                                <input type="text" name="nik_balita" value="{{ $balita->nik_balita }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NAMA
                                    BALITA</label>
                                <input type="text" name="nama_balita" value="{{ $balita->nama_balita }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">BALITA KE</label>
                                <input type="number" name="balita_ke" value="{{ $balita->balita_ke }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">TANGGAL
                                    LAHIR</label>
                                <input type="date" name="tanggal_lahir" value="{{ $balita->tanggal_lahir }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>
                        </div>

                        <!-- Column 2 -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">BERAT BADAN LAHIR
                                    (KG)</label>
                                <input type="number" step="0.01" name="berat_badan_lahir"
                                    value="{{ $balita->berat_badan_lahir }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">TINGGI LAHIR
                                    (CM)</label>
                                <input type="number" step="0.1" name="tinggi_lahir" value="{{ $balita->tinggi_lahir }}"
                                    required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">JENIS
                                    KELAMIN</label>
                                <select name="jenis_kelamin"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    required>
                                    <option value="L" {{ $balita->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki
                                    </option>
                                    <option value="P" {{ $balita->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan
                                    </option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NAMA ORANG
                                    TUA</label>
                                <input type="text" name="nama_orang_tua" value="{{ $balita->nama_orang_tua }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <!-- TAMBAHAN FIELD -->
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">NIK Orang
                                    Tua</label>
                                <input type="text" name="nik_orang_tua" value="{{ $balita->nik_orang_tua }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">No HP</label>
                                <input type="text" name="no_hp" value="{{ $balita->no_hp }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                        </div>
                    </div>

                    <!-- Divider -->
                    <div class="border-t border-gray-100 my-4"></div>

                    <!-- Second Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">TEMPAT
                                    POSYANDU</label>
                                <select name="id_tempat"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                    required>
                                    @foreach ($tempat as $t)
                                        <option value="{{ $t->id }}"
                                            {{ $balita->id_tempat == $t->id ? 'selected' : '' }}>
                                            {{ $t->tempat_posyandu }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">RT</label>
                                    <input type="number" name="rt" value="{{ $balita->rt }}" required
                                        class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">RW</label>
                                    <input type="number" name="rw" value="{{ $balita->rw }}" required
                                        class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">BUKU KIA</label>
                                <input type="text" name="buku_kia" value="{{ $balita->buku_kia }}" required
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>

                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1 tracking-wide">INISIASI MENYUSUI
                                    DINI</label>
                                <input type="text" name="inisiasi_menyusui_dini"
                                    value="{{ $balita->inisiasi_menyusui_dini }}"
                                    class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition">
                            </div>
                        </div>
                    </div>

                    <div class="pt-6 flex justify-end space-x-3">
                        <a href="{{ route('balita.tampil4') }}"
                            class="px-5 py-2 text-sm border border-gray-300 rounded hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-blue-500 text-white text-sm font-medium rounded hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
