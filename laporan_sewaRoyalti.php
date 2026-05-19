<?php
include "koneksi.php";

/* ================= LOGIKA ASLI (TIDAK DIUBAH) ================= */
$totalRoyalti = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(harga) AS total FROM sewa_royalti"));
$totalTransaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT id_sewa FROM sewa_royalti"));
$totalFilm = mysqli_num_rows(mysqli_query($koneksi, "SELECT DISTINCT id_film FROM sewa_royalti"));

$qFilm = mysqli_query($koneksi, "SELECT f.nama_film, SUM(s.harga) AS total FROM sewa_royalti s JOIN film f ON s.id_film = f.id_film GROUP BY s.id_film");
$filmLabel = []; $filmTotal = [];
while ($f = mysqli_fetch_assoc($qFilm)) { $filmLabel[] = $f['nama_film']; $filmTotal[] = $f['total']; }

$qDurasi = mysqli_query($koneksi, "SELECT f.nama_film, SUM(DATEDIFF(s.tanggal_tutup_tayang, s.tanggal_sewa)) AS total_hari FROM sewa_royalti s JOIN film f ON s.id_film = f.id_film GROUP BY s.id_film");
$durasiLabel = []; $durasiTotal = [];
while ($d = mysqli_fetch_assoc($qDurasi)) { $durasiLabel[] = $d['nama_film']; $durasiTotal[] = $d['total_hari']; }

$dataSewa = mysqli_query($koneksi, "SELECT s.*, f.nama_film FROM sewa_royalti s JOIN film f ON s.id_film = f.id_film");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Royalti - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover; background-position: center; background-attachment: fixed;
            min-height: 100vh; color: white; font-family: 'Segoe UI', sans-serif;
        }
        .glass { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(15px); border: 1px solid rgba(255, 255, 255, 0.08); }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic">ROYALTY <span class="text-pink-600">REPORT</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Licensing Analytics</p>
        </div>
        <div class="flex gap-3">
            <a href="dashboard.php" class="glass px-5 py-2 rounded-xl text-xs hover:bg-white/10 transition flex items-center gap-2 text-pink-500 font-bold"><i class="fas fa-th-large"></i></a>
            <button onclick="window.print()" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-xl font-black text-xs transition-all flex items-center gap-2 uppercase">PRINT <i class="fas fa-print"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass p-6 rounded-[2rem] border-l-4 border-l-pink-600">
            <h4 class="text-gray-500 text-[9px] uppercase tracking-widest font-bold mb-1">Total Royalty</h4>
            <p class="text-2xl font-black italic text-pink-500">Rp <?= number_format($totalRoyalti['total'], 0, ',', '.') ?></p>
        </div>
        <div class="glass p-6 rounded-[2rem]">
            <h4 class="text-gray-500 text-[9px] uppercase tracking-widest font-bold mb-1">Total Movies</h4>
            <p class="text-2xl font-black italic text-white"><?= $totalFilm ?> <span class="text-xs font-normal text-gray-600">Titles</span></p>
        </div>
        <div class="glass p-6 rounded-[2rem]">
            <h4 class="text-gray-500 text-[9px] uppercase tracking-widest font-bold mb-1">Total Transactions</h4>
            <p class="text-2xl font-black italic text-white"><?= $totalTransaksi ?> <span class="text-xs font-normal text-gray-600">Records</span></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="glass p-6 rounded-[2rem]">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-4 flex items-center gap-2">
                <i class="fas fa-coins text-pink-500"></i> Royalty Distribution
            </h3>
            <div class="h-[200px]"><canvas id="filmChart"></canvas></div>
        </div>
        <div class="glass p-6 rounded-[2rem]">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-4 flex items-center gap-2">
                <i class="fas fa-hourglass-half text-pink-500"></i> Screening Days
            </h3>
            <div class="h-[200px]"><canvas id="durasiChart"></canvas></div>
        </div>
    </div>

    <div class="glass rounded-[2rem] overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-500 uppercase text-[9px] tracking-widest">
                        <th class="p-5 font-bold">Film Name</th>
                        <th class="p-5 font-bold text-center">Period</th>
                        <th class="p-5 font-bold text-right">Cost</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php while ($row = mysqli_fetch_assoc($dataSewa)) { ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-5 font-bold text-gray-200 text-sm italic uppercase"><?= htmlspecialchars($row['nama_film']) ?></td>
                        <td class="p-5 text-center text-[10px] text-gray-500 font-mono"><?= $row['tanggal_sewa'] ?> — <?= $row['tanggal_tutup_tayang'] ?></td>
                        <td class="p-5 text-right font-mono font-bold text-pink-500 text-sm">Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
const chartOptions = {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
        y: { grid: { color: 'rgba(255,255,255,0.03)' }, ticks: { color: '#475569', font: { size: 9 } } },
        x: { grid: { display: false }, ticks: { color: '#475569', font: { size: 9 } } }
    }
};

new Chart(document.getElementById('filmChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($filmLabel) ?>,
        datasets: [{ data: <?= json_encode($filmTotal) ?>, backgroundColor: '#db2777', borderRadius: 6 }]
    },
    options: chartOptions
});

new Chart(document.getElementById('durasiChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($durasiLabel) ?>,
        datasets: [{ data: <?= json_encode($durasiTotal) ?>, backgroundColor: 'rgba(255,255,255,0.2)', borderRadius: 6 }]
    },
    options: chartOptions
});
</script>
</body>
</html>