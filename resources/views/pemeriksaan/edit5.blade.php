@extends('layout.admin')

@section('konten')
    <div class="p-6 min-h-screen bg-gray-50">
        <div class="mx-auto">
            <header class="mb-6">
                <h1 class="text-xl font-semibold text-gray-800">Edit Pemeriksaan Balita</h1>
                <p class="text-gray-500 text-sm mt-1">Posyandu Desa Talkandang</p>
            </header>

            <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                <form action="{{ route('pemeriksaan.update5', $pemeriksaan_balita->id) }}" method="POST">
                    @csrf

                    <input type="hidden" name="id_balita" value="{{ $pemeriksaan_balita->balita->id }}">
                    <input type="hidden" id="tanggal_lahir" value="{{ $pemeriksaan_balita->balita->tanggal_lahir }}">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">NIK BALITA</label>
                            <div class="text-sm text-gray-800">{{ $pemeriksaan_balita->balita->nik_balita }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">BALITA KE</label>
                            <div class="text-sm text-gray-800">{{ $pemeriksaan_balita->balita->balita_ke }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">NAMA BALITA</label>
                            <div class="text-sm text-gray-800">{{ $pemeriksaan_balita->balita->nama_balita }}</div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">JENIS KELAMIN</label>
                            <div class="text-sm text-gray-800">{{ $pemeriksaan_balita->balita->jenis_kelamin }}</div>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-medium text-gray-500 mb-1">TEMPAT POSYANDU</label>
                            <div class="text-sm text-gray-800">{{ $pemeriksaan_balita->balita->tempat->tempat_posyandu }}
                            </div>
                            <input type="hidden" name="id_tempat" value="{{ $pemeriksaan_balita->balita->id_tempat }}">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">PETUGAS PEMERIKSA</label>
                        <select name="id_petugas"
                            class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                            required>
                            <option value="" disabled>-- Pilih Petugas --</option>
                            @foreach ($petugas as $p)
                                <option value="{{ $p->id }}"
                                    {{ $p->id == $pemeriksaan_balita->id_petugas ? 'selected' : '' }}>
                                    {{ $p->nama_petugas }} - {{ $p->jabatan_petugas }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="space-y-5 mt-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">TANGGAL PEMERIKSAAN</label>
                            <input type="date" name="tanggal_pemeriksaan"
                                value="{{ $pemeriksaan_balita->tanggal_pemeriksaan }}"
                                class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">UMUR (BULAN)</label>
                            <input type="number" id="umur" name="umur" value="{{ $pemeriksaan_balita->umur }}"
                                readonly
                                class="w-full bg-gray-100 px-3 py-2 text-sm border-b border-gray-200 focus:outline-none"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">BERAT BADAN (KG)</label>
                            <input type="number" step="0.1" name="berat_badan"
                                value="{{ $pemeriksaan_balita->berat_badan }}"
                                class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                required>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">TINGGI BADAN (CM)</label>
                            <input type="number" step="0.1" name="tinggi_badan"
                                value="{{ $pemeriksaan_balita->tinggi_badan }}"
                                class="w-full px-3 py-2 text-sm border-b border-gray-200 focus:border-blue-500 focus:outline-none transition"
                                required>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 pt-6">
                        <a href="{{ route('pemeriksaan.tampil5') }}"
                            class="px-5 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                            class="px-5 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg hover:bg-blue-600 transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tanggalLahir = new Date(document.getElementById('tanggal_lahir').value);
            const inputTanggal = document.querySelector('[name="tanggal_pemeriksaan"]');
            const inputUmur = document.getElementById('umur');

            function hitungUmur() {
                const tanggalPemeriksaan = new Date(inputTanggal.value);
                if (!isNaN(tanggalLahir.getTime()) && !isNaN(tanggalPemeriksaan.getTime())) {
                    let umurBulan = (tanggalPemeriksaan.getFullYear() - tanggalLahir.getFullYear()) * 12;
                    umurBulan += tanggalPemeriksaan.getMonth() - tanggalLahir.getMonth();
                    if (tanggalPemeriksaan.getDate() < tanggalLahir.getDate()) umurBulan--;
                    inputUmur.value = umurBulan >= 0 ? umurBulan : 0;
                }
            }

            inputTanggal.addEventListener('change', hitungUmur);
            hitungUmur(); // Jalankan saat pertama load
        });
    </script>
@endsection
