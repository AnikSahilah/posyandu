@extends('layout.admin')

@section('konten')
<div class="p-6 max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-gray-50">
            <h2 class="text-2xl font-bold text-gray-800 text-center">Riwayat Imunisasi Balita</h2>
        </div>

        <!-- Balita Info Section -->
        <div class="px-6 py-4 grid grid-cols-1 md:grid-cols-3 gap-4 border-b border-gray-200">
            <div class="bg-blue-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Nama Balita</p>
                <p class="text-lg font-semibold text-blue-600">{{ $balita->nama_balita }}</p>
            </div>
            <div class="bg-pink-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                <p class="text-lg font-semibold text-pink-600">{{ $balita->jenis_kelamin }}</p>
            </div>
            <div class="bg-green-50 p-3 rounded-lg">
                <p class="text-sm font-medium text-gray-500">Tempat Posyandu</p>
                <p class="text-lg font-semibold text-green-600">{{ $balita->tempat->tempat_posyandu ?? '-' }}</p>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Petugas</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal Imunisasi</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                            Imunisasi</th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($imunisasi as $index => $item)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $imunisasi->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">
                            {{ $item->petugas->nama_petugas ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->tanggal_imunisasi)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                            {{ $item->jenis->jenis_imunisasi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ $item->jenis->keterangan ?? '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            <div class="flex flex-col items-center justify-center py-6">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                                <p class="mt-2">Belum ada data imunisasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 px-6 py-4">
            {{ $imunisasi->links() }}
        </div>

        <!-- Footer Section -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-center">
            <a href="{{ route('imunisasi.tampil2') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>
</div>
@endsection