@extends('layout.admin')

@section('konten')
    <div class="container mx-auto p-4 md:p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 space-y-4 md:space-y-0">
            <div>
                <h1 class="text-xl md:text-3xl font-extrabold text-green-700 mb-1 flex items-center gap-2">
                    <i class="fas fa-project-diagram bg-green-100 text-green-600 p-2 rounded-full"></i>
                    Clustering Status Gizi Balita (K-Means)
                </h1>
                <p class="text-gray-600 text-sm md:text-base">Analisis pengelompokan status gizi balita berdasarkan data
                    posyandu</p>
            </div>
            <a href="{{ route('clustering.proses') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 md:px-6 rounded-lg flex items-center text-sm md:text-base transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5 mr-2" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                        clip-rule="evenodd" />
                </svg>
                Proses Clustering
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm">Total Tempat Posyandu</h3>
                <p class="text-xl font-bold text-gray-800">{{ $tempat->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm">Terklaster</h3>
                <p class="text-xl font-bold text-gray-800">{{ $tempat->whereNotNull('cluster_kmeans')->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-yellow-500">
                <h3 class="text-gray-500 text-sm">Belum Terklaster</h3>
                <p class="text-xl font-bold text-gray-800">{{ $tempat->whereNull('cluster_kmeans')->count() }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="p-4 border-b">
                <h2 class="text-lg font-semibold text-gray-800">Visualisasi Cluster</h2>
            </div>
            <div class="p-4 overflow-x-auto">
                <div class="relative w-full h-[300px] md:h-[400px]">
                    <canvas id="chartCluster" class="w-full h-full"></canvas>
                </div>
            </div>

        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                <h2 class="text-lg font-semibold text-gray-800">Hasil Clustering</h2>
                <div class="flex flex-wrap gap-2">
                    <span class="px-2 py-1 text-xs bg-red-100 text-red-800 rounded-full">Risiko Tinggi</span>
                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Risiko Rendah</span>
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Belum Dikelompokkan</span>
                </div>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">No</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Tempat Posyandu</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Cluster</th>
                            <th class="px-4 py-2 text-left font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($tempat as $i => $t)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 whitespace-nowrap">{{ $i + 1 }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $t->tempat_posyandu }}</td>
                                <td class="px-4 py-2">{{ $t->cluster_kmeans ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    @if ($t->cluster_kmeans === 0)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">Risiko
                                            Tinggi</span>
                                    @elseif ($t->cluster_kmeans === 1)
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Risiko
                                            Rendah</span>
                                    @else
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">Belum
                                            Dikelompokkan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        let clusterChart;

        function renderClusterChart() {
            const ctx = document.getElementById('chartCluster').getContext('2d');

            if (clusterChart) clusterChart.destroy();

            const dataJumlah = {!! json_encode($dataJumlah) !!};

            const labels = dataJumlah.map(item => item.nama);
            const clusterData = dataJumlah.map(() => 1); // Semua batang tinggi 1 agar tooltip bisa tampil

            const backgroundColor = dataJumlah.map(item => {
                if (item.cluster === 0) return '#f87171'; // Merah
                if (item.cluster === 1) return '#34d399'; // Hijau
                return '#d1d5db'; // Abu
            });

            const borderColor = dataJumlah.map(item => {
                if (item.cluster === 0) return '#dc2626';
                if (item.cluster === 1) return '#059669';
                return '#6b7280';
            });

            clusterChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Status Risiko',
                        data: clusterData,
                        backgroundColor: backgroundColor,
                        borderColor: borderColor,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const idx = context.dataIndex;
                                    const d = dataJumlah[idx];
                                    const risiko = d.cluster === 0 ? 'Risiko Tinggi' : (d.cluster === 1 ?
                                        'Risiko Rendah' : 'Belum Dikelompokkan');

                                    return [
                                        `Cluster: ${risiko}`,
                                        `Stunting: ${d.stunting} orang`,
                                        `Gizi Buruk: ${d.buruk} orang`,
                                        `Gizi Kurang: ${d.kurang} orang`,
                                        `Gizi Normal: ${d.normal} orang`,
                                    ];
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 1.2,
                            ticks: {
                                callback: () => ''
                            },
                            grid: {
                                drawTicks: false,
                                display: false
                            }
                        }
                    }
                }
            });
        }

        renderClusterChart();
        window.addEventListener('resize', renderClusterChart);
    </script>
@endsection
