@extends('layout.admin')

@section('konten')
<div x-data="imunisasiHandler()" class="p-6">

    <header class="mb-6 text-center md:text-left">
        <h1 class="text-2xl md:text-3xl font-extrabold text-green-700 mb-1">
            <i class="fas fa-syringe bg-green-100 text-green-600 p-2 rounded-full"></i>
            Data Imunisasi Balita
        </h1>
        <p class="text-gray-600">Kelola Hasil Imunisasi Balita Posyandu.</p>
    </header>

    {{-- Filter dan Cari --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mt-4 mb-4 gap-4">
        <form method="GET" action="{{ route('imunisasi.tampil2') }}"
            class="bg-white p-3 rounded shadow text-sm border w-full md:w-auto">
            <div class="flex flex-wrap items-center gap-4">
                <div class="font-semibold text-gray-800">Filter Tempat:</div>
                <label class="flex items-center gap-1">
                    <input type="radio" name="filter_tempat" value=""
                        {{ request('filter_tempat') == '' ? 'checked' : '' }} onchange="this.form.submit()" />
                    <span>Semua</span>
                </label>
                @foreach ($tempatList as $t)
                <label class="flex items-center gap-1">
                    <input type="radio" name="filter_tempat" value="{{ $t->id }}"
                        {{ request('filter_tempat') == $t->id ? 'checked' : '' }} onchange="this.form.submit()" />
                    <span>{{ $t->tempat_posyandu }}</span>
                </label>
                @endforeach
                @if (request('cari'))
                <input type="hidden" name="cari" value="{{ request('cari') }}">
                @endif
            </div>
        </form>
    </div>

    <form method="GET" action="{{ route('imunisasi.tampil2') }}" class="mb-4">
        <div class="flex flex-col sm:flex-row gap-2 items-start sm:items-center">
            <input type="text" name="cari" placeholder="Cari Nama Balita..." value="{{ request('cari') }}"
                class="border border-gray-300 rounded px-3 py-2 text-sm w-full md:w-64" />
            <input type="hidden" name="filter_tempat" value="{{ request('filter_tempat') }}">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded text-sm">Cari</button>
            @if (request('cari'))
            <a href="{{ route('imunisasi.tampil2', ['filter_tempat' => request('filter_tempat')]) }}"
                class="text-gray-500 hover:underline text-sm">Reset</a>
            @endif
        </div>
    </form>

    @if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
        class="mb-4 px-4 py-3 rounded-md bg-green-100 text-green-800 border border-green-300 shadow">
        <div class="flex justify-between items-center">
            <span class="font-semibold">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </span>
            <button @click="show = false" class="text-green-700 hover:text-green-900">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    @endif


    {{-- TABEL --}}
    <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-white text-black">
                    <th class="px-4 py-4 text-center">No</th>
                    <th class="px-4 py-4 text-center">Nama Balita</th>
                    <th class="px-4 py-4 text-center">Jenis Kelamin</th>
                    <th class="px-4 py-4 text-center">Tempat Posyandu</th>
                    <th class="px-4 py-4 text-center">Petugas</th>
                    <th class="px-4 py-4 text-center">Tanggal Imunisasi</th>
                    <th class="px-4 py-4 text-center">Jenis Imunisasi</th>
                    <th class="px-4 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-300 border">
                @forelse ($balita as $no => $b)
                @php
                $lastImunisasi = $b->imunisasi->sortByDesc('tanggal_imunisasi')->first();
                @endphp
                <tr class="hover:bg-gray-200">
                    <td class="px-2 py-3 text-center">{{ $balita->firstItem() + $no }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->nama_balita }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->jenis_kelamin }}</td>
                    <td class="px-2 py-3 text-center">{{ $b->tempat->tempat_posyandu ?? '-' }}</td>
                    <td class="px-2 py-3 text-center">
                        {{ $lastImunisasi->petugas->nama_petugas ?? '-' }}
                    </td>
                    <td class="px-2 py-3 text-center">
                        {{ $lastImunisasi?->tanggal_imunisasi ? \Carbon\Carbon::parse($lastImunisasi->tanggal_imunisasi)->translatedFormat('d F Y') : '-' }}
                    </td>
                    <td class="px-2 py-3 text-center">{{ $lastImunisasi->jenis->jenis_imunisasi ?? '-' }}</td>
                    <td class="px-2 py-3 text-center space-x-1">
                        <button
                            @click="openTambahModal({{ $b->id }}, '{{ $b->nama_balita }}', '{{ $b->jenis_kelamin }}', '{{ $b->tempat->tempat_posyandu ?? '-' }}')"
                            class="text-green-500 hover:text-green-700">
                            <i class="fas fa-plus-circle text-xl"></i>
                        </button>

                        @if ($lastImunisasi)
                        <button
                            @click="openEditModal(
                                        {{ $lastImunisasi->id }},
                                        '{{ $lastImunisasi->tanggal_imunisasi }}',
                                        {{ $lastImunisasi->id_jenis }},
                                        '{{ $lastImunisasi->jenis->keterangan ?? '' }}',
                                        '{{ $b->nama_balita }}',
                                        '{{ $b->jenis_kelamin }}',
                                        '{{ $b->tempat->tempat_posyandu ?? '-' }}',
                                        {{ $lastImunisasi->id_petugas ?? 'null' }}
                                    )"
                            class="text-blue-500 hover:text-blue-700">
                            <i class="fas fa-edit text-xl"></i>
                        </button>

                        <a href="{{ route('imunisasi.lihat2', $b->id) }}"
                            class="text-yellow-500 hover:text-yellow-700">
                            <i class="fas fa-eye text-xl"></i>
                        </a>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        <div class="flex flex-col items-center justify-center py-8">
                            <i class="fas fa-calendar-times text-4xl text-gray-400 mb-3"></i>
                            <p class="text-lg font-medium text-gray-600">Belum ada data imunisasi</p>
                            <p class="text-sm text-gray-500 mt-1">Silakan tambahkan data imunisasi untuk ditampilkan
                                di
                                sini.
                            </p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $balita->links() }}
        </div>
    </div>

    {{-- Modal Tambah --}}
    <div x-show="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button @click="modalTambah = false" class="absolute top-2 right-2 text-gray-500">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-center">Tambah Imunisasi</h2>
            <form action="{{ route('imunisasi.submit2') }}" method="POST">
                @csrf
                <input type="hidden" name="id_balita" :value="selectedBalita.id">

                <div class="mb-3">
                    <label class="font-semibold block">Nama Balita</label>
                    <input type="text" readonly :value="selectedBalita.nama"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Jenis Kelamin</label>
                    <input type="text" readonly :value="selectedBalita.kelamin"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Tempat Posyandu</label>
                    <input type="text" readonly :value="selectedBalita.tempat"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>

                <div class="mb-4">
                    <label for="id_petugas" class="block mb-1 font-medium text-gray-700">Nama Petugas</label>
                    <select name="id_petugas" id="id_petugas" required
                        class="w-full border-gray-300 rounded px-3 py-2 focus:ring focus:border-blue-500">
                        <option value="">-- Pilih Petugas --</option>
                        @foreach ($petugasList as $petugas)
                        <option value="{{ $petugas->id }}">
                            {{ $petugas->nama_petugas }} ({{ $petugas->jabatan_petugas }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block">Tanggal Imunisasi</label>
                    <input type="date" name="tanggal_imunisasi" required class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Jenis Imunisasi</label>
                    <select name="id_jenis" required class="w-full border px-3 py-2 rounded"
                        @change="updateKeterangan($event)">
                        <option value="">-- Pilih Jenis --</option>
                        @foreach ($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" data-keterangan="{{ $jenis->keterangan }}">
                            {{ $jenis->jenis_imunisasi }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Keterangan</label>
                    <textarea readonly class="w-full bg-gray-100 border px-3 py-2 rounded" x-text="keteranganJenis"></textarea>
                </div>
                <div class="flex justify-end gap-2 mt-3">
                    <button type="button" @click="modalTambah = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div x-show="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        x-cloak>
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
            <button @click="modalEdit = false" class="absolute top-2 right-2 text-gray-500">&times;</button>
            <h2 class="text-xl font-bold mb-4 text-center">Edit Imunisasi</h2>
            <form :action="editActionUrl" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="font-semibold block">Nama Balita</label>
                    <input type="text" readonly :value="editForm.nama"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Jenis Kelamin</label>
                    <input type="text" readonly :value="editForm.kelamin"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Tempat Posyandu</label>
                    <input type="text" readonly :value="editForm.tempat"
                        class="w-full bg-gray-100 border px-3 py-2 rounded">
                </div>

                <div class="mb-3">
                    <label class="font-semibold block">Nama Petugas</label>
                    <select name="id_petugas" x-model="editForm.petugas_id" class="w-full border px-3 py-2 rounded"
                        required>
                        <option value="">-- Pilih Petugas --</option>
                        @foreach ($petugasList as $petugas)
                        <option value="{{ $petugas->id }}">
                            {{ $petugas->nama_petugas }} ({{ $petugas->jabatan_petugas }})
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block">Tanggal Imunisasi</label>
                    <input type="date" name="tanggal_imunisasi" x-model="editForm.tanggal" required
                        class="w-full border px-3 py-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Jenis Imunisasi</label>
                    <select name="id_jenis" x-model="editForm.jenis_id" @change="updateKeteranganEdit($event)"
                        class="w-full border px-3 py-2 rounded" required>
                        <option value="">-- Pilih Jenis --</option>
                        @foreach ($jenisList as $jenis)
                        <option value="{{ $jenis->id }}" data-keterangan="{{ $jenis->keterangan }}">
                            {{ $jenis->jenis_imunisasi }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="font-semibold block">Keterangan</label>
                    <textarea readonly class="w-full bg-gray-100 border px-3 py-2 rounded" x-text="editForm.keterangan"></textarea>
                </div>
                <div class="flex justify-end gap-2 mt-3">
                    <button type="button" @click="modalEdit = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

</div>

{{-- SCRIPT ALPINE.JS --}}
<script>
    function imunisasiHandler() {
        return {
            modalTambah: false,
            modalEdit: false,
            selectedBalita: {
                id: '',
                nama: '',
                kelamin: '',
                tempat: ''
            },
            editForm: {
                id: '',
                tanggal: '',
                jenis_id: '',
                keterangan: '',
                nama: '',
                kelamin: '',
                tempat: '',
                petugas_id: ''
            },
            editActionUrl: '',
            keteranganJenis: '',

            openTambahModal(id, nama, kelamin, tempat) {
                this.selectedBalita = {
                    id,
                    nama,
                    kelamin,
                    tempat
                };
                this.keteranganJenis = '';
                this.modalTambah = true;
            },
            openEditModal(id, tanggal, jenisId, keterangan, nama, kelamin, tempat, petugasId) {
                this.editForm = {
                    id,
                    tanggal,
                    jenis_id: jenisId,
                    keterangan,
                    nama,
                    kelamin,
                    tempat,
                    petugas_id: petugasId
                };
                this.editActionUrl = /imunisasi/update2 / $ {
                    id
                };
                this.modalEdit = true;
            },
            updateKeterangan(event) {
                const k = event.target.selectedOptions[0].getAttribute('data-keterangan') || '';
                this.keteranganJenis = k;
            },
            updateKeteranganEdit(event) {
                const k = event.target.selectedOptions[0].getAttribute('data-keterangan') || '';
                this.editForm.keterangan = k;
            }
        };
    }
</script>
@endsection