<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php'; 

if (!function_exists('formatRp')) {
    function formatRp($angka) {
        return "Rp " . number_format($angka, 0, ',', '.');
    }
}

$query_laporan = "
    SELECT 
        menu.nama AS nama_barang,
        menu.harga AS harga_satuan,
        SUM(detail_penj_mkn_min.jumlah) AS total_dipesan,
        SUM(detail_penj_mkn_min.subtotal) AS total_harga
        FROM detail_penj_mkn_min
        INNER JOIN menu 
        ON menu.id_menu = detail_penj_mkn_min.id_menu
        GROUP BY 
        detail_penj_mkn_min.id_menu, 
        menu.nama, 
        menu.harga 
    ORDER BY total_dipesan DESC
";

$data = tampil_lap_m($query_laporan); 

$query_total = "
    SELECT 
        SUM(subtotal) AS grand_total_penjualan,
        SUM(jumlah) AS grand_total_kuantitas
    FROM detail_penj_mkn_min
";
$total_data_row = tampil($query_total);
$total_data = !empty($total_data_row) ? $total_data_row[0] : ['grand_total_penjualan' => 0, 'grand_total_kuantitas' => 0];

// Persiapan Data Chart
$labels = [];
$values = [];
foreach ($data as $row) {
    $labels[] = $row['nama_barang'];
    $values[] = $row['total_harga'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan F&B - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
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
                F&B <span class="text-pink-600">SALES</span>
            </h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Food & Beverage Analytics</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border border-pink-500/20 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 text-pink-500/10 text-7xl italic font-black">QTY</div>
                <h4 class="text-gray-500 text-[10px] uppercase tracking-widest font-bold mb-1">Total Items Sold</h4>
                <p class="text-4xl font-black italic text-white"><?= number_format($total_data['grand_total_kuantitas'], 0, ',', '.'); ?></p>
            </div>
            <div class="glass p-8 rounded-[2.5rem] border border-white/5 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 text-white/5 text-7xl italic font-black">REV</div>
                <h4 class="text-gray-500 text-[10px] uppercase tracking-widest font-bold mb-1">Total Revenue</h4>
                <p class="text-3xl font-black italic text-pink-500"><?= formatRp($total_data['grand_total_penjualan']); ?></p>
            </div>
        </div>

        <div class="lg:col-span-2 glass p-8 rounded-[2.5rem] border border-white/5">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400 mb-6 flex items-center gap-2">
                <i class="fas fa-chart-bar text-pink-500"></i> Sales Performance by Menu
            </h3>
            <div class="h-[250px]">
                <canvas id="penjualanChart"></canvas>
            </div>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="p-8 border-b border-white/5 flex justify-between items-center">
            <h3 class="text-sm font-bold uppercase tracking-widest text-gray-400">Inventory Sales Detail</h3>
            <span class="text-[10px] bg-pink-500/10 text-pink-500 px-3 py-1 rounded-full font-bold uppercase tracking-tighter italic">Top Sellers First</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold">Menu Item</th>
                        <th class="p-6 font-bold text-center">Unit Price</th>
                        <th class="p-6 font-bold text-center">Sold</th>
                        <th class="p-6 font-bold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($data as $row): ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-6">
                            <div class="font-bold text-gray-200 uppercase tracking-tight italic"><?= htmlspecialchars($row['nama_barang']); ?></div>
                        </td>
                        <td class="p-6 text-center text-gray-500 font-mono text-sm">
                            <?= formatRp($row['harga_satuan']); ?>
                        </td>
                        <td class="p-6 text-center">
                            <span class="bg-white/5 px-4 py-1 rounded-lg border border-white/10 font-bold text-sm">
                                <?= $row['total_dipesan']; ?>
                            </span>
                        </td>
                        <td class="p-6 text-right">
                            <span class="text-pink-500 font-mono font-bold">
                                <?= formatRp($row['total_harga']); ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. F&B Intelligence System
        </p>
    </footer>
</div>

<script>
    const data = {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
            label: 'Total Penjualan',
            data: <?= json_encode($values); ?>,
            backgroundColor: 'rgba(233, 30, 99, 0.6)', // Pink-500 with opacity
            borderColor: '#e91e63',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: '#e91e63'
        }]
    };

    new Chart(document.getElementById('penjualanChart'), {
        type: 'bar',
        data: data,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255, 255, 255, 0.05)' },
                    ticks: {
                        color: '#64748b',
                        callback: value => 'Rp ' + (value / 1000) + 'K'
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>

</body>
</html>