<?php

namespace App\Http\Controllers;

use App\Models\PemeriksaanBalita;
use App\Models\Tempat;
use Illuminate\Http\Request;

class ClusteringController extends Controller
{
    public function index()
    {
        $tempat = Tempat::with('pemeriksaan_balita')->get();

        $dataJumlah = $tempat->map(function ($t) {
            $pemeriksaans = PemeriksaanBalita::whereHas('balita', fn($q) => $q->where('id_tempat', $t->id))->get();

            $counts = [
                'stunting' => 0,
                'buruk' => 0,
                'kurang' => 0,
                'normal' => 0,
            ];

            foreach ($pemeriksaans as $p) {
                $status = strtolower($p->status);
                if (str_contains($status, 'stunting')) $counts['stunting']++;
                elseif (str_contains($status, 'buruk')) $counts['buruk']++;
                elseif (str_contains($status, 'kurang')) $counts['kurang']++;
                elseif (str_contains($status, 'normal') || str_contains($status, 'baik')) $counts['normal']++;
            }

            return [
                'id' => $t->id,
                'nama' => $t->tempat_posyandu,
                'cluster' => $t->cluster_kmeans,
                ...$counts
            ];
        });

        return view('clustering.index', [
            'tempat' => $tempat,
            'dataJumlah' => $dataJumlah,
        ]);
    }



    public function prosesKMeans()
    {
        $tempat = Tempat::all();

        // 1. Ambil data pemeriksaan per tempat → bentuk vektor
        $data = collect($tempat)->map(function ($t) {
            $pemeriksaans = PemeriksaanBalita::whereHas('balita', fn($q) => $q->where('id_tempat', $t->id))->get();
            $total = $pemeriksaans->count();

            $counts = [
                'stunting' => 0,
                'buruk' => 0,
                'kurang' => 0,
                'normal' => 0,
            ];

            foreach ($pemeriksaans as $p) {
                $status = strtolower($p->status);
                if (str_contains($status, 'stunting')) $counts['stunting']++;
                elseif (str_contains($status, 'buruk')) $counts['buruk']++;
                elseif (str_contains($status, 'kurang')) $counts['kurang']++;
                elseif (str_contains($status, 'normal') || str_contains($status, 'baik')) $counts['normal']++;
            }

            // Hitung persentase (biar tidak bias oleh jumlah data)
            $persentase = array_map(fn($x) => $total > 0 ? round(($x / $total) * 100, 2) : 0, $counts);

            return [
                'id' => $t->id,
                ...$persentase
            ];
        });

        // 2. Jalankan K-Means (k=2)
        $clustered = $this->kMeans($data->values(), 2);

        // 3. Simpan hasil cluster ke DB
        foreach ($clustered as $item) {
            Tempat::where('id', $item['id'])->update([
                'cluster_kmeans' => $item['cluster']
            ]);
        }

        return redirect()->route('clustering.index')->with('success', 'Clustering berhasil dilakukan!');
    }

    // 4. K-Means PHP Murni
    private function kMeans($data, $k = 2, $maxIter = 100)
    {
        $centroids = $data->random($k)->values()->toArray();

        for ($iter = 0; $iter < $maxIter; $iter++) {
            // Assign ke cluster terdekat
            $clusters = array_fill(0, $k, []);
            foreach ($data as $point) {
                $distances = array_map(fn($c) => $this->euclidean($point, $c), $centroids);
                $minIndex = array_keys($distances, min($distances))[0];
                $clusters[$minIndex][] = $point;
            }

            // Update centroid
            $newCentroids = [];
            foreach ($clusters as $cluster) {
                if (count($cluster) == 0) {
                    $newCentroids[] = $data->random(1)->first(); // centroid acak jika kosong
                    continue;
                }

                $mean = [];
                foreach (['stunting', 'buruk', 'kurang', 'normal'] as $field) {
                    $mean[$field] = round(array_sum(array_column($cluster, $field)) / count($cluster), 2);
                }
                $newCentroids[] = $mean;
            }

            if ($centroids == $newCentroids) break; // konvergen
            $centroids = $newCentroids;
        }

        // Pasangkan hasil cluster ke masing-masing tempat
        $result = [];
        foreach ($data as $point) {
            $distances = array_map(fn($c) => $this->euclidean($point, $c), $centroids);
            $cluster = array_keys($distances, min($distances))[0];
            $result[] = [...$point, 'cluster' => $cluster];
        }

        return $result;
    }

    // Euclidean distance
    private function euclidean($a, $b)
    {
        $sum = 0;
        foreach (['stunting', 'buruk', 'kurang', 'normal'] as $key) {
            $sum += pow($a[$key] - $b[$key], 2);
        }
        return sqrt($sum);
    }
}
