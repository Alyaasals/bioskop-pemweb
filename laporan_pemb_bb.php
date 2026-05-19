<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

$data = mysqli_query($koneksi,"
    SELECT * FROM pembelian_bahan_baku
    ORDER BY id_pembelian ASC
");

$qChart = mysqli_query($koneksi,"
    SELECT tgl_pembelian, SUM(total_harga) AS total
    FROM pembelian_bahan_baku
    WHERE status_selesai = 'Selesai'
    GROUP BY tgl_pembelian
    ORDER BY tgl_pembelian
");

$tanggal = [];
$total = [];

while($c = mysqli_fetch_assoc($qChart)){
    $tanggal[] = $c['tgl_pembelian'];
    $total[]   = $c['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian - STATIC.</title>
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
            <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic text-white">PURCHASING <span class="text-pink-600">REPORT</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Raw Material Procurement</p>
        </div>
        <div class="flex gap-3">
            <a href="dashboard.php" class="glass px-5 py-2 rounded-xl text-xs hover:bg-white/10 transition flex items-center gap-2 text-pink-500 font-bold uppercase"><i class="fas fa-th-large"></i> DASHBOARD</a>
            <button onclick="window.print()" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-xl font-black text-xs transition-all flex items-center gap-2 uppercase">PRINT <i class="fas fa-print"></i></button>
        </div>
    </div>

    <div class="glass p-8 rounded-[2rem] mb-8 shadow-2xl">
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-6 flex items-center gap-2">
            <i class="fas fa-chart-line text-pink-500"></i> Purchasing Trend
        </h3>
        <div class="h-[300px]">
            <canvas id="purchaseChart"></canvas>
        </div>
    </div>

    <div class="glass rounded-[2rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="p-6 border-b border-white/5">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Transaction History</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-500 uppercase text-[9px] tracking-widest">
                        <th class="p-5 font-bold">ID Pembelian</th>
                        <th class="p-5 font-bold">Tgl Pembelian</th>
                        <th class="p-5 font-bold">ID Jurnal</th>
                        <th class="p-5 font-bold">Total Harga</th>
                        <th class="p-5 font-bold text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php while($row = mysqli_fetch_assoc($data)): ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-5 font-bold text-gray-200 text-sm font-mono"><?= $row['id_pembelian']; ?></td>
                        <td class="p-5 text-gray-400 text-sm italic"><?= date('d M Y', strtotime($row['tgl_pembelian'])); ?></td>
                        <td class="p-5 text-gray-400 text-sm"><?= $row['id_jurnal']; ?></td>
                        <td class="p-5 font-mono text-white text-sm">Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td class="p-5 text-right">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter <?= $row['status_selesai'] == 'Selesai' ? 'bg-pink-600/20 text-pink-500' : 'bg-zinc-800 text-gray-500' ?>">
                                <?= $row['status_selesai']; ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Material Procurement Integrity
        </p>
    </footer>
</div>

<script>
const ctx = document.getElementById('purchaseChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($tanggal); ?>,
        datasets: [{
            label: 'Total Pembelian (Rp)',
            data: <?= json_encode($total); ?>,
            backgroundColor: 'rgba(219, 39, 119, 0.6)',
            borderColor: '#db2777',
            borderWidth: 2,
            borderRadius: 8,
            hoverBackgroundColor: '#db2777'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { 
                position: 'top',
                labels: { color: '#64748b', font: { size: 10, weight: 'bold' }, boxWidth: 12 }
            },
            tooltip: {
                backgroundColor: '#111',
                callbacks: {
                    label: function(context) {
                        return 'Rp ' + context.raw.toLocaleString('id-ID');
                    }
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                ticks: { 
                    color: '#64748b', 
                    font: { size: 10 },
                    callback: function(value) {
                        return 'Rp ' + (value / 1000).toLocaleString('id-ID') + ' Rb';
                    }
                }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } }
            }
        }
    }
});
</script>
</body>
</html>