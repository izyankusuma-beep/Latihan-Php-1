<?php
// ============================================================
// Latihan Individu - versi tema Honkai: Star Rail
// Logika sama dengan index.php, hanya tampilan yang beda
// ============================================================

// 1. Array multidimensi $matkul (key: nama, sks, nilai 0-100)
$matkul = [
    ['nama' => 'Struktur Data',               'sks' => 3, 'nilai' => 88],
    ['nama' => 'Basis Data',                  'sks' => 3, 'nilai' => 76],
    ['nama' => 'Arsitektur Komputer',         'sks' => 3, 'nilai' => 58],
    ['nama' => 'Probabilitas dan Statistika', 'sks' => 3, 'nilai' => 42],
    ['nama' => 'Robotika',                    'sks' => 2, 'nilai' => 91],
    ['nama' => 'Pemrograman Web',             'sks' => 3, 'nilai' => 35],
];

// 2. Fungsi helper: nilai angka -> huruf & bobot
function hitungBobot($nilai)
{
    if ($nilai >= 85) {
        return ['huruf' => 'A', 'bobot' => 4.0];
    } elseif ($nilai >= 70) {
        return ['huruf' => 'B', 'bobot' => 3.0];
    } elseif ($nilai >= 55) {
        return ['huruf' => 'C', 'bobot' => 2.0];
    } elseif ($nilai >= 40) {
        return ['huruf' => 'D', 'bobot' => 1.0];
    }
    return ['huruf' => 'E', 'bobot' => 0.0];
}

// Hiasan tema: huruf -> "rarity" ala gacha
function rarity($huruf)
{
    $map = [
        'A' => ['★★★★★', 'r5'],
        'B' => ['★★★★',  'r4'],
        'C' => ['★★★',   'r3'],
        'D' => ['★★',    'r2'],
        'E' => ['★',     'r1'],
    ];
    return $map[$huruf];
}

$totalSks  = 0;
$totalMutu = 0;
$rows      = [];

foreach ($matkul as $mk) {
    $hasil  = hitungBobot($mk['nilai']);
    $status = $hasil['bobot'] >= 2.0 ? 'LULUS' : 'MENGULANG';

    $totalSks  += $mk['sks'];
    $totalMutu += $mk['sks'] * $hasil['bobot'];

    $rows[] = [
        'nama'   => $mk['nama'],
        'sks'    => $mk['sks'],
        'nilai'  => $mk['nilai'],
        'huruf'  => $hasil['huruf'],
        'status' => $status,
    ];
}

// 5. IPS
$ips = $totalSks > 0 ? $totalMutu / $totalSks : 0;

// 6. Batas SKS semester depan
$maksSks = $ips >= 3.00 ? 24 : 20;

$jumlahLulus     = count(array_filter($rows, fn($r) => $r['status'] === 'LULUS'));
$jumlahMengulang = count($rows) - $jumlahLulus;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Astral Express - Kartu Hasil Studi</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 36px 16px;
            min-height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #e8e6f5;
            background:
                radial-gradient(1.5px 1.5px at 12% 18%, #fff 50%, transparent 52%),
                radial-gradient(1px 1px at 70% 30%, #cfd8ff 50%, transparent 52%),
                radial-gradient(1.5px 1.5px at 85% 75%, #fff 50%, transparent 52%),
                radial-gradient(1px 1px at 30% 80%, #ffe9a8 50%, transparent 52%),
                radial-gradient(1px 1px at 55% 60%, #fff 50%, transparent 52%),
                radial-gradient(ellipse at top, #2a2250 0%, #12102a 55%, #08071a 100%);
        }
        .container {
            max-width: 940px;
            margin: 0 auto;
            padding: 28px;
            background: rgba(20, 17, 48, .85);
            border: 1px solid #c9a85c;
            border-radius: 14px;
            box-shadow: 0 0 30px rgba(140, 110, 255, .25), inset 0 0 40px rgba(201, 168, 92, .06);
        }
        .tag { color: #c9a85c; letter-spacing: 3px; font-size: 12px; text-transform: uppercase; }
        h1 { margin: 4px 0 2px; font-size: 28px; color: #f5e6b8; letter-spacing: 1px; }
        .sub { color: #9a95c4; margin-bottom: 22px; font-size: 14px; }

        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 11px 12px; text-align: center; border-bottom: 1px solid rgba(201,168,92,.25); }
        th {
            background: linear-gradient(90deg, #3b2f7a, #5a3f9e);
            color: #f5e6b8;
            font-size: 13px;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        td.nama { text-align: left; font-weight: 600; }
        tbody tr:hover { background: rgba(140,110,255,.12); }

        /* 4. Baris MENGULANG berwarna merah */
        tr.mengulang td { background: rgba(220, 38, 38, .28); color: #ffb4b4; font-weight: 700; }
        tr.mengulang:hover td { background: rgba(220, 38, 38, .38); }

        .star { letter-spacing: 1px; font-size: 13px; }
        .r5 { color: #ffd166; text-shadow: 0 0 8px rgba(255,209,102,.7); }
        .r4 { color: #c39bff; text-shadow: 0 0 8px rgba(195,155,255,.6); }
        .r3 { color: #7fb8ff; }
        .r2 { color: #9aa5b5; }
        .r1 { color: #7a7a7a; }
        .huruf { display: block; font-size: 16px; font-weight: 700; color: #fff; }

        .badge {
            display: inline-block; padding: 3px 12px; border-radius: 999px;
            font-size: 12px; font-weight: 700; letter-spacing: 1px;
        }
        .lulus { background: rgba(80, 200, 140, .18); color: #7ef0b4; border: 1px solid #3bbf80; }
        .ulang { background: rgba(255, 90, 90, .2); color: #ff9a9a; border: 1px solid #ff5a5a; }

        .ringkasan {
            margin-top: 26px;
            padding: 20px 22px;
            border: 1px solid #c9a85c;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(90,63,158,.35), rgba(20,17,48,.6));
        }
        .ringkasan h2 { margin: 0 0 12px; font-size: 17px; color: #f5e6b8; letter-spacing: 1px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)); gap: 12px; }
        .stat {
            padding: 12px 14px; border-radius: 10px;
            background: rgba(8,7,26,.6); border: 1px solid rgba(201,168,92,.3);
        }
        .stat small { display: block; color: #9a95c4; font-size: 12px; margin-bottom: 4px; }
        .stat b { font-size: 22px; color: #ffd166; }
        .footer { margin-top: 18px; text-align: center; color: #7d78a8; font-size: 12px; font-style: italic; }
    </style>
</head>
<body>
<div class="container">
    <div class="tag">Astral Express &bull; Trailblaze Records</div>
    <h1>Kartu Hasil Studi</h1>
    <div class="sub">Latihan Individu &mdash; Array Multidimensi &amp; Fungsi Helper PHP</div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Nilai Angka</th>
                <th>Nilai Huruf</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $r): ?>
            <?php [$bintang, $kelas] = rarity($r['huruf']); ?>
            <tr class="<?= $r['status'] === 'MENGULANG' ? 'mengulang' : '' ?>">
                <td><?= $i + 1 ?></td>
                <td class="nama"><?= htmlspecialchars($r['nama']) ?></td>
                <td><?= $r['sks'] ?></td>
                <td><?= $r['nilai'] ?></td>
                <td>
                    <span class="huruf"><?= $r['huruf'] ?></span>
                    <span class="star <?= $kelas ?>"><?= $bintang ?></span>
                </td>
                <td>
                    <span class="badge <?= $r['status'] === 'LULUS' ? 'lulus' : 'ulang' ?>">
                        <?= $r['status'] ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="ringkasan">
        <h2>Ringkasan IPS</h2>
        <div class="grid">
            <div class="stat"><small>Total SKS</small><b><?= $totalSks ?></b></div>
            <div class="stat"><small>Total Mutu</small><b><?= number_format($totalMutu, 2) ?></b></div>
            <div class="stat"><small>IPS</small><b><?= number_format($ips, 2) ?></b></div>
            <div class="stat"><small>Lulus / Mengulang</small><b><?= $jumlahLulus ?> / <?= $jumlahMengulang ?></b></div>
            <div class="stat"><small>Batas SKS Semester Depan</small><b><?= $maksSks ?> SKS</b></div>
        </div>
    </div>

    <div class="footer">"Semua perjalanan dimulai dari satu langkah. All aboard the Astral Express!"</div>
</div>
</body>
</html>