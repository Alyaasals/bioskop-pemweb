<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php';

// Data Penjualan (Red Aksen)
$tren = mysqli_query($koneksi, "SELECT tanggal_transaksi as tgl, SUM(total_harga) as total FROM penjualan_tiket GROUP BY tgl");
while($r = mysqli_fetch_assoc($tren)){ $l_tgl[] = $r['tgl']; $d_tgl[] = $r['total']; }

// Data Film (Gold Aksen)
$film = mysqli_query($koneksi, "SELECT f.nama_film as nama, COUNT(*) as jml FROM film f JOIN jadwal_tayang jt ON f.id_film = jt.id_film JOIN detail_penjualan_tiket dpt ON jt.id_jadwal = dpt.id_jadwal GROUP BY f.id_film LIMIT 5");
while($r = mysqli_fetch_assoc($film)){ $l_f[] = $r['nama']; $d_f[] = $r['jml']; }
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.78)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none italic">
                SALES <span class="text-pink-600">REPORT</span>
            </h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Ticket Sales Analytics</p>
        </div>
        <div class="flex gap-4">
            <a href="dashboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2 text-pink-500">
                <i class="fas fa-th-large"></i> DASHBOARD
            </a>
            <button onclick="window.print()" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-pink-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-print"></i> Print Report
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="glass p-8 rounded-[2.5rem] border border-white/5">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-line text-pink-500"></i> Revenue Trend
            </h3>
            <canvas id="chartLine" height="200"></canvas>
        </div>

        <div class="glass p-8 rounded-[2.5rem] border border-white/5">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-pie text-pink-500"></i> Popular Movies
            </h3>
            <div class="max-w-[300px] mx-auto">
                <canvas id="chartDoughnut"></canvas>
            </div>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="p-8 border-b border-white/5">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400">Detailed Transaction Log</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold text-center w-20">No</th>
                        <th class="p-6 font-bold">Tanggal</th>
                        <th class="p-6 font-bold text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    $total_seluruh = 0;
                    $tren_data = mysqli_query($koneksi, "SELECT tanggal_transaksi as tgl, SUM(total_harga) as total FROM penjualan_tiket GROUP BY tgl");
                    while($row = mysqli_fetch_assoc($tren_data)): 
                        $total_seluruh += $row['total'];
                    ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-6 text-center text-gray-600 font-mono text-sm"><?= $no++; ?></td>
                        <td class="p-6 font-bold text-gray-200 uppercase tracking-tight">
                            <?= date('d M Y', strtotime($row['tgl'])); ?>
                        </td>
                        <td class="p-6 text-right">
                            <span class="text-pink-500 font-mono font-bold">
                                Rp <?= number_format($row['total'], 0, ',', '.'); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                    <tr class="bg-pink-600/5">
                        <td colspan="2" class="p-6 text-right font-black uppercase tracking-widest text-pink-500 text-xs">Grand Total</td>
                        <td class="p-6 text-right font-black text-xl text-white italic">
                            Rp <?= number_format($total_seluruh, 0, ',', '.'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Analytics Intelligence System
        </p>
    </footer>
</div>

<script>
// Chart Line - Tema Pink Gradient
new Chart(document.getElementById('chartLine'), {
    type: 'line',
    data: {
        labels: <?= json_encode($l_tgl ?? []) ?>,
        datasets: [{
            label: 'Revenue',
            data: <?= json_encode($d_tgl ?? []) ?>,
            borderColor: '#db2777', // Pink-600
            backgroundColor: 'rgba(219, 39, 119, 0.1)',
            fill: true,
            tension: 0.4,
            borderWidth: 4,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: '#db2777',
            pointRadius: 4
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { 
                grid: { color: 'rgba(255,255,255,0.05)' }, 
                ticks: { color: '#64748b', font: { size: 10 } } 
            },
            x: { 
                grid: { display: false }, 
                ticks: { color: '#64748b', font: { size: 10 } } 
            }
        }
    }
});

// Chart Doughnut - Tema Pink & Purple
new Chart(document.getElementById('chartDoughnut'), {
    type: 'doughnut',
    data: {
        labels: <?= json_encode($l_f ?? []) ?>,
        datasets: [{
            data: <?= json_encode($d_f ?? []) ?>,
            backgroundColor: [
                '#db2777', // Pink-600
                '#9d174d', // Pink-800
                '#be185d', // Pink-700
                '#4c1d95', // Purple-900 (untuk kontras mewah)
                '#831843'  // Rose-900
            ],
            borderWidth: 0,
            hoverOffset: 20
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: '#64748b',
                    padding: 20,
                    font: { size: 10, weight: 'bold' },
                    usePointStyle: true
                }
            }
        },
        cutout: '70%'
    }
});
</script>

</body>
</html>