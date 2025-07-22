<!DOCTYPE html>
<html>

<head>
    <title>Laporan Imunisasi Balita</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        h2,
        h4 {
            text-align: center;
            margin: 0;
        }
    </style>
</head>

<body>
    <h2>Laporan Imunisasi Balita</h2>
    <h4>Bulan {{ \Carbon\Carbon::createFromDate($tahun, (int) $bulan, 1)->translatedFormat('F') }} {{ $tahun }}
    </h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Posyandu</th>
                <th>Tanggal Imunisasi</th>
                <th>Jenis Imunisasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $no => $i)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $i->balita->nama_balita }}</td>
                    <td>{{ $i->balita->jenis_kelamin }}</td>
                    <td>{{ $i->balita->tempat->tempat_posyandu ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($i->tanggal_imunisasi)->format('d-m-Y') }}</td>
                    <td>{{ $i->jenis->jenis_imunisasi }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Tidak ada data imunisasi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
