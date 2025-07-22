<table class="w-full text-sm border-collapse border">
    <thead class="bg-white">
        <tr>
            <th class="px-4 py-4">No</th>
            <th class="px-4 py-4">Nama Balita</th>
            <th class="px-4 py-4">Tempat</th>
            <th class="px-4 py-4">Petugas</th>
            <th class="px-4 py-4">Tanggal</th>
            <th class="px-4 py-4">Jenis Imunisasi</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-gray-300 border">
        @forelse ($data as $no => $i)
            <tr class="hover:bg-gray-200">
                <td class="px-2 py-3 text-center">{{ $no + 1 }}</td>
                <td class="px-2 py-3">{{ $i->balita->nama_balita }}</td>
                <td class="px-2 py-3">{{ $i->balita->tempat->tempat_posyandu ?? '-' }}</td>
                <td class="px-2 py-3">{{ $i->petugas->nama_petugas ?? '-' }}</td>
                <td class="px-2 py-3">{{ \Carbon\Carbon::parse($i->tanggal_imunisasi)->translatedFormat('d F Y') }}</td>
                <td class="px-2 py-3">{{ $i->jenis->jenis_imunisasi }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                    <div class="flex flex-col items-center justify-center py-8">
                        <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                        <p class="text-lg font-medium text-gray-600">Belum ada data imunisasi</p>
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
