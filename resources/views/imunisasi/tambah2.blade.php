@extends('layout.admin')

@section('konten')
    <div class="p-6 bg-white rounded-lg shadow max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-center">Tambah Data Imunisasi</h2>

        {{-- TAMPILKAN ERROR --}}
        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('imunisasi.submit2') }}" method="POST">
            @csrf

            

            

            {{-- NAMA BALITA --}}
            <div class="mb-4">
                <label for="id_balita" class="block mb-1 font-medium text-gray-700">Nama Balita</label>
                <select name="id_balita" id="id_balita" required
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                    <option value="">-- Pilih Balita --</option>
                    @foreach ($balitaList as $balita)
                        <option value="{{ $balita->id }}" {{ old('id_balita') == $balita->id ? 'selected' : '' }}>
                            {{ $balita->nama_balita }} ({{ $balita->tempat->tempat_posyandu ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TANGGAL IMUNISASI --}}
            <div class="mb-4">
                <label for="tanggal_imunisasi" class="block mb-1 font-medium text-gray-700">Tanggal Imunisasi</label>
                <input type="date" name="tanggal_imunisasi" id="tanggal_imunisasi"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500"
                    value="{{ old('tanggal_imunisasi') }}" required>
            </div>

            {{-- JENIS IMUNISASI --}}
            <div class="mb-4">
                <label for="id_jenis" class="block mb-1 font-medium text-gray-700">Jenis Imunisasi</label>
                <select name="id_jenis" id="id_jenis" required onchange="updateKeterangan()"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                    <option value="">-- Pilih Jenis Imunisasi --</option>
                    @foreach ($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" data-keterangan="{{ $jenis->keterangan }}"
                            {{ old('id_jenis') == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->jenis_imunisasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- KETERANGAN --}}
            <div class="mb-4">
                <label for="keterangan" class="block mb-1 font-medium text-gray-700">Keterangan</label>
                <textarea id="keterangan" rows="3" class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100" readonly></textarea>
            </div>

            {{-- TOMBOL --}}
            <div class="flex justify-end gap-2">
                <a href="{{ route('imunisasi.tampil2') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>

    {{-- SCRIPT --}}
    <script>
        function updateKeterangan() {
            const select = document.getElementById('id_jenis');
            const selectedOption = select.options[select.selectedIndex];
            const keterangan = selectedOption.getAttribute('data-keterangan') || '';
            document.getElementById('keterangan').value = keterangan;
        }

        // Set keterangan saat halaman dimuat (misal saat error & kembali)
        window.addEventListener('DOMContentLoaded', () => {
            updateKeterangan();
        });
    </script>
@endsection
