<!DOCTYPE html>
<html>

<head>
    <title>Laporan Pemeriksaan Balita</title>
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
    <h2>Laporan Pemeriksaan Balita</h2>
    <h4>Bulan {{ \Carbon\Carbon::createFromDate($tahun, (int) $bulan, 1)->translatedFormat('F') }} {{ $tahun }}
    </h4>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Balita</th>
                <th>Jenis Kelamin</th>
                <th>Tempat Posyandu</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Umur (bln)</th>
                <th>BB (kg)</th>
                <th>TB (cm)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $no => $p)
                <tr>
                    <td>{{ $no + 1 }}</td>
                    <td>{{ $p->balita->nama_balita }}</td>
                    <td>{{ $p->balita->jenis_kelamin }}</td>
                    <td>{{ $p->balita->tempat->tempat_posyandu ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                    <td>{{ $p->umur }}</td>
                    <td>{{ $p->berat_badan }}</td>
                    <td>{{ $p->tinggi_badan }}</td>
                    <td>{{ $p->status }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">Tidak ada data pemeriksaan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
