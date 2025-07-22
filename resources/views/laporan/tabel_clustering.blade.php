<table class="min-w-full bg-white border mt-4">
    <thead>
        <tr class="bg-white">
            <th class="py-4 px-4 ">No</th>
            <th class="py-4 px-4 ">Tempat Posyandu</th>
            <th class="py-4 px-4 ">Cluster</th>
            <th class="py-4 px-4 ">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-300 border">
        @forelse ($data as $i => $item)
            <tr class="hover:bg-gray-200">
                <td class="py-2 px-3 text-center">{{ $i + 1 }}</td>
                <td class="py-2 px-3 text-center">{{ $item->tempat_posyandu }}</td>
                <td class="py-2 px-3 text-center">{{ $item->cluster_kmeans ?? '-' }}</td>
                <td class="py-2 px-3 text-center">
                    @if ($item->cluster_kmeans === 0)
                        Risiko Tinggi
                    @elseif ($item->cluster_kmeans === 1)
                        Risiko Rendah
                    @else
                        Belum Dikelompokkan
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                        <p class="text-lg font-medium text-gray-600">Belum ada data Cluster</p>
                        <p class="text-sm text-gray-500 mt-1">Silakan tampilkan petugas di sini.
                        </p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="mt-4">
    {{ $data->links() }}
</div>
