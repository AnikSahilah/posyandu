@extends('layout.admin')

@section('konten')
    <div class="p-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded-xl shadow border border-gray-200">
            <h2 class="text-2xl font-bold text-green-700 mb-4 flex items-center">
                <i class="fas fa-info-circle mr-2 text-green-600"></i> Detail Data Balita
            </h2>

            <table class="w-full text-sm">
                <tbody class="divide-y divide-gray-200">
                    <tr>
                        <td class="font-semibold py-2 w-48">NIK Balita</td>
                        <td>{{ $balita->nik_balita }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Nama Balita</td>
                        <td>{{ $balita->nama_balita }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Balita Ke</td>
                        <td>{{ $balita->balita_ke }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Tanggal Lahir</td>
                        <td>{{ \Carbon\Carbon::parse($balita->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Berat Badan Lahir</td>
                        <td>{{ $balita->berat_badan_lahir }} kg</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Tinggi Lahir</td>
                        <td>{{ $balita->tinggi_lahir }} cm</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Jenis Kelamin</td>
                        <td>{{ $balita->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Nama Orang Tua</td>
                        <td>{{ $balita->nama_orang_tua }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">NIK Orang Tua</td>
                        <td>{{ $balita->nik_orang_tua }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">No HP</td>
                        <td>{{ $balita->no_hp }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Tempat Posyandu</td>
                        <td>{{ $balita->tempat->tempat_posyandu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">RT / RW</td>
                        <td>{{ $balita->rt }} / {{ $balita->rw }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Buku KIA</td>
                        <td>{{ $balita->buku_kia }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold py-2">Inisiasi Menyusui Dini</td>
                        <td>{{ $balita->inisiasi_menyusui_dini ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('balita.tampil4') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg shadow text-sm">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
            </div>
        </div>
    </div>
@endsection
