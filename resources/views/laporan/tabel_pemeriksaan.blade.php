<table class="w-full text-sm border-collapse border border-gray-300">
    <thead class="bg-white">
        <tr>
            <th class="px-4 py-4">No</th>
            <th class="px-4 py-4">Nama Balita</th>
            <th class="px-4 py-4">Tempat</th>
            <th class="px-4 py-4">Petugas</th>
            <th class="px-4 py-4">Tanggal</th>
            <th class="px-4 py-4">Umur</th>
            <th class="px-4 py-4">BB</th>
            <th class="px-4 py-4">TB</th>
            <th class="px-4 py-4">Status</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-300 border">
        @forelse ($data as $no => $p)
            <tr class="hover:bg-gray-200">
                <td class="px-2 py-3 text-center">{{ $no + 1 }}</td>
                <td class="px-2 py-3 text-center">{{ $p->balita->nama_balita }}</td>
                <td class="px-2 py-3 text-center">{{ $p->balita->tempat->tempat_posyandu ?? '-' }}</td>
                <td class="px-2 py-3 text-center">
                    {{ $p->petugas->nama_petugas ?? '-' }}
                </td>
                <td class="px-2 py-3 text-center">
                    {{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->translatedFormat('d F Y') }}
                </td>
                <td class="px-2 py-3 text-center">{{ $p->umur }}</td>
                <td class="px-2 py-3 text-center">{{ $p->berat_badan }}</td>
                <td class="px-2 py-3 text-center">{{ $p->tinggi_badan }}</td>
                <td class="px-2 py-3 text-center">{{ $p->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                        <p class="text-lg font-medium text-gray-600">Belum ada data pemeriksaan</p>
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
