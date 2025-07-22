@extends('layout.admin')

@section('konten')
    <div class="p-6 bg-white rounded-lg shadow max-w-xl mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-center">Edit Data Imunisasi</h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('imunisasi.update2', $imunisasi->id) }}" method="POST">
            @csrf

            {{-- NAMA PETUGAS --}}
            <div class="mb-4">
                <label for="id_petugas" class="block mb-1 font-medium text-gray-700">Nama Petugas</label>
                <select name="id_petugas" id="id_petugas" required
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-green-500">
                    <option value="">-- Pilih Petugas --</option>
                    @foreach ($petugasList as $petugas)
                        <option value="{{ $petugas->id }}" {{ $imunisasi->id_petugas == $petugas->id ? 'selected' : '' }}>
                            {{ $petugas->nama_petugas }} ({{ $petugas->jabatan_petugas }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- PILIH JENIS IMUNISASI --}}
            <div class="mb-4">
                <label for="id_jenis" class="block mb-1 font-medium text-gray-700">Jenis Imunisasi</label>
                <select name="id_jenis" id="id_jenis" required onchange="updateKeterangan()"
                    class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-green-500">
                    <option value="">-- Pilih Jenis Imunisasi --</option>
                    @foreach ($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" data-keterangan="{{ $jenis->keterangan }}"
                            {{ $imunisasi->id_jenis == $jenis->id ? 'selected' : '' }}>
                            {{ $jenis->jenis_imunisasi }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- TAMPILKAN KETERANGAN (AUTO) --}}
            <div class="mb-4">
                <label for="keterangan" class="block mb-1 font-medium text-gray-700">Keterangan</label>
                <textarea id="keterangan" rows="3" class="w-full border-gray-300 rounded px-3 py-2 bg-gray-100" readonly>{{ $imunisasi->jenis->keterangan ?? '' }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('imunisasi.tampil2') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">Perbarui</button>
            </div>
        </form>
    </div>

    <script>
        function updateKeterangan() {
            const select = document.getElementById('id_jenis');
            const selectedOption = select.options[select.selectedIndex];
            const keterangan = selectedOption.getAttribute('data-keterangan') || '';
            document.getElementById('keterangan').value = keterangan;
        }

        // Set keterangan default saat halaman dibuka
        document.addEventListener("DOMContentLoaded", function() {
            updateKeterangan();
        });
    </script>
@endsection
