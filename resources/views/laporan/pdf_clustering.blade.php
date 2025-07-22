<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Clustering</title>
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
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Clustering Status Gizi Balita</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tempat Posyandu</th>
                <th>Cluster</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $t)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $t->tempat_posyandu }}</td>
                    <td>{{ $t->cluster_kmeans ?? '-' }}</td>
                    <td>
                        @if ($t->cluster_kmeans === 0)
                            Risiko Tinggi
                        @elseif ($t->cluster_kmeans === 1)
                            Risiko Rendah
                        @else
                            Belum Dikelompokkan
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
