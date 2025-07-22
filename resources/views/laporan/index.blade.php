@extends('layout.admin')

@section('konten')
    <div class="p-6">
        <!-- Header Section -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
                    <i class="fas fa-file-medical bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Laporan Posyandu
                </h1>
                <p class="text-gray-600">Analisis dan rekapitulasi data kegiatan posyandu</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('laporan.exportPDF', ['jenis' => $jenis, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors">
                    <i class="fas fa-file-pdf"></i>
                    Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-lg shadow p-4 mb-6 border border-gray-100">
            <form method="GET" action="{{ route('laporan.index') }}"
                class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Laporan</label>
                    <select name="jenis"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="pemeriksaan" {{ $jenis == 'pemeriksaan' ? 'selected' : '' }}>Pemeriksaan Balita
                        </option>
                        <option value="imunisasi" {{ $jenis == 'imunisasi' ? 'selected' : '' }}>Imunisasi</option>
                        <option value="clustering" {{ $jenis == 'clustering' ? 'selected' : '' }}>Clustering Gizi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                    <select name="bulan"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                    <select name="tahun"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        @foreach ($tahunList as $th)
                            <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <i class="fas fa-filter"></i>
                        Tampilkan
                    </button>
                </div>
            </form>
        </div>

        <!-- Report Content Section -->
        <div>
            @if ($jenis == 'pemeriksaan')
                @include('laporan.tabel_pemeriksaan')
            @elseif ($jenis == 'imunisasi')
                @include('laporan.tabel_imunisasi')
            @elseif ($jenis == 'clustering')
                @include('laporan.tabel_clustering')
            @endif
        </div>
    </div>
@endsection
