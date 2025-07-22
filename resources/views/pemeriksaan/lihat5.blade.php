@extends('layout.admin')

@section('konten')
    <div class="p-6 min-h-screen bg-gray-50">
        <div class="mx-auto">
            <!-- Header -->
            <header class="mb-6">
                <h1 class="text-2xl font-semibold text-gray-800">Detail Pemeriksaan Balita</h1>
                <p class="text-gray-500 text-sm mt-1">Posyandu Desa Talkandang</p>
            </header>

            <!-- Informasi Balita -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs font-medium text-gray-500">NIK BALITA</p>
                            <p class="text-gray-800 mt-1">{{ $balita->nik_balita }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">NAMA BALITA</p>
                            <p class="text-gray-800 mt-1">{{ $balita->nama_balita }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">JENIS KELAMIN</p>
                            <p class="text-gray-800 mt-1">{{ $balita->jenis_kelamin }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">TEMPAT POSYANDU</p>
                            <p class="text-gray-800 mt-1">
                                {{ optional($balita->tempat)->tempat_posyandu ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Pemeriksaan -->
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-800 mb-4">
                        Riwayat Pemeriksaan Tahun {{ $tahunTerpilih }}
                    </h2>

                    <div>
                        <button onclick="document.getElementById('grafikModal').showModal()"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                            Lihat Grafik Pemeriksaan
                        </button>
                    </div>

                    <!-- Tabel Riwayat -->
                    <div class="overflow-x-auto mt-4">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-left border-b border-gray-200">
                                    <th class="pb-3 text-xs font-medium text-gray-500">NO</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">PETUGAS</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">TANGGAL</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">UMUR (BULAN)</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">BERAT BADAN (KG)</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">TINGGI BADAN (CM)</th>
                                    <th class="pb-3 text-xs font-medium text-gray-500">STATUS GIZI</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($pemeriksaan as $no => $data)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 text-gray-800">{{ $pemeriksaan->firstItem() + $no }}</td>
                                        <td class="py-3 text-gray-800">
                                            {{ optional($data->petugas)->nama_petugas ?? '-' }}
                                        </td>
                                        <td class="py-3 text-gray-800">
                                            {{ \Carbon\Carbon::parse($data->tanggal_pemeriksaan)->translatedFormat('d M Y') }}
                                        </td>
                                        <td class="py-3 text-gray-800">{{ $data->umur }}</td>
                                        <td class="py-3 text-gray-800">{{ $data->berat_badan }}</td>
                                        <td class="py-3 text-gray-800">{{ $data->tinggi_badan }}</td>
                                        <td
                                            class="py-3 font-semibold
                                            @if ($data->status == 'Gizi Baik') text-green-600
                                            @elseif ($data->status == 'Gizi Kurang') text-yellow-600
                                            @elseif ($data->status == 'Gizi Buruk') text-red-600
                                            @elseif ($data->status == 'Stunting') text-orange-600
                                            @else text-gray-600 @endif">
                                            {{ $data->status }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="py-4 text-sm text-gray-500 text-center">
                                            Belum ada data pemeriksaan
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Dropdown Filter Tahun -->
                    <form method="GET" action="{{ route('pemeriksaan.lihat5', $balita->id) }}" class="mt-4">
                        <label for="tahun" class="text-sm text-gray-600 mr-2">Tampilkan Tahun:</label>
                        <select name="tahun" id="tahun" onchange="this.form.submit()"
                            class="border px-3 py-1 rounded text-sm">
                            @foreach ($tahunTersedia as $tahun)
                                <option value="{{ $tahun }}" {{ $tahun == $tahunTerpilih ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ route('pemeriksaan.tampil5') }}"
                    class="px-4 py-2 text-sm border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Grafik Pemeriksaan -->
    <dialog id="grafikModal" class="w-full max-w-4xl rounded-lg shadow-lg">
        <div class="p-6 bg-white relative">
            <h3 class="text-lg font-semibold mb-4 text-gray-800">Grafik Pemeriksaan Seluruh Tahun</h3>

            <canvas id="grafikPemeriksaan" height="100"></canvas>

            <button onclick="document.getElementById('grafikModal').close()"
                class="absolute top-2 right-2 text-gray-500 hover:text-red-500">
                ✕
            </button>
        </div>
    </dialog>

    <!-- Script Chart.js -->
    <script>
        const dataPemeriksaan = @json($balita->pemeriksaan_balita->sortBy('tanggal_pemeriksaan')->values());

        const labels = dataPemeriksaan.map(p => p.umur + ' bln');
        const bbData = dataPemeriksaan.map(p => p.berat_badan);
        const tbData = dataPemeriksaan.map(p => p.tinggi_badan);

        const ctx = document.getElementById('grafikPemeriksaan').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                        label: 'Berat Badan (kg)',
                        data: bbData,
                        borderColor: 'rgb(75, 192, 192)',
                        backgroundColor: 'rgba(75, 192, 192, 0.4)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(75, 192, 192)'
                    },
                    {
                        label: 'Tinggi Badan (cm)',
                        data: tbData,
                        borderColor: 'rgb(255, 159, 64)',
                        backgroundColor: 'rgba(255, 159, 64, 0.4)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointBackgroundColor: 'rgb(255, 159, 64)'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                interaction: {
                    mode: 'nearest',
                    axis: 'x',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: false
                    }
                }
            }
        });
    </script>
@endsection
