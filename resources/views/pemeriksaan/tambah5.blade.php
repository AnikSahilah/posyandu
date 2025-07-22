@extends('layout.admin')

@section('konten')
    <div class="p-6 mx-auto">
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
            <h2 class="text-xl font-semibold text-gray-800 mb-6">Tambah Data Pemeriksaan Balita</h2>
            <p class="text-gray-500 text-sm mb-6">Posyandu Desa Talkandang</p>

            <form action="{{ route('pemeriksaan.simpan5') }}" method="POST">
                @csrf

                <!-- Hidden ID Balita -->
                <input type="hidden" name="id_balita" value="{{ $balita->id }}">
                <input type="hidden" name="page" value="{{ request('page') }}">

                {{-- Informasi Balita --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">NIK BALITA</label>
                        <div class="text-sm text-gray-800">{{ $balita->nik_balita }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">BALITA KE</label>
                        <div class="text-sm text-gray-800">{{ $balita->balita_ke }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">NAMA BALITA</label>
                        <div class="text-sm text-gray-800">{{ $balita->nama_balita }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">JENIS KELAMIN</label>
                        <div class="text-sm text-gray-800">{{ $balita->jenis_kelamin }}</div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">TEMPAT POSYANDU</label>
                        <div class="text-sm text-gray-800">{{ optional($balita->tempat)->tempat_posyandu ?? '-' }}</div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">PETUGAS PEMERIKSA</label>
                    <select name="id_petugas"
                        class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                        required>
                        <option value="" disabled selected>-- Pilih Petugas --</option>
                        @foreach ($petugas as $p)
                            <option value="{{ $p->id }}">{{ $p->nama_petugas }} - {{ $p->jabatan_petugas }}</option>
                        @endforeach
                    </select>
                </div>


                {{-- Form Input Pemeriksaan --}}
                <div class="space-y-5 mt-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">TANGGAL PEMERIKSAAN</label>
                        <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan"
                            data-tanggal-lahir="{{ $balita->tanggal_lahir }}"
                            class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">UMUR (BULAN)</label>
                        <input type="number" name="umur" id="umur"
                            class="w-full px-3 py-2 text-sm border-b border-gray-200 bg-gray-50 focus:outline-none" readonly
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">BERAT BADAN (KG)</label>
                        <input type="text" name="berat_badan"
                            class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                            required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">TINGGI BADAN (CM)</label>
                        <input type="text" name="tinggi_badan"
                            class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                            required>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6">
                    <a href="{{ route('pemeriksaan.tampil5') }}"
                        class="px-5 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Kembali
                    </a>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-300">
                        Simpan Pemeriksaan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script untuk hitung umur otomatis --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tanggalPemeriksaanInput = document.getElementById('tanggal_pemeriksaan');
            const umurInput = document.getElementById('umur');
            const tanggalLahir = new Date(tanggalPemeriksaanInput.dataset.tanggalLahir);

            tanggalPemeriksaanInput.addEventListener('change', function() {
                const tanggalPemeriksaan = new Date(this.value);

                if (tanggalPemeriksaan >= tanggalLahir) {
                    let selisihBulan = (tanggalPemeriksaan.getFullYear() - tanggalLahir.getFullYear()) *
                        12 +
                        (tanggalPemeriksaan.getMonth() - tanggalLahir.getMonth());

                    // Jika tanggal pemeriksaan belum melewati tanggal lahir di bulan itu
                    if (tanggalPemeriksaan.getDate() < tanggalLahir.getDate()) {
                        selisihBulan -= 1;
                    }

                    umurInput.value = selisihBulan;
                } else {
                    umurInput.value = '';
                }
            });

            // Hitung otomatis saat form dibuka jika sudah terisi
            tanggalPemeriksaanInput.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
