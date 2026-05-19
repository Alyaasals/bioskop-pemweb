<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php';

$chartQuery = mysqli_query($koneksi, "
    SELECT id_bhn_baku, SUM(jumlah_retur) AS total_retur
    FROM detail_retur_bahan_baku
    GROUP BY id_bhn_baku
");

$labels = [];
$values = [];
$total_item_retur = 0;

// Memasukkan data ke array untuk Chart
while ($row = mysqli_fetch_assoc($chartQuery)) {
    $labels[] = $row['id_bhn_baku'];
    $values[] = (int) $row['total_retur'];
    $total_item_retur += $row['total_retur'];
}

$total_jenis_bahan = count($labels);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Retur - STATIC.</title>
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
            <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic text-white">RETURNS <span class="text-pink-600">REPORT</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Material Return Analytics</p>
        </div>
        <div class="flex gap-3">
            <a href="dashboard.php" class="glass px-5 py-2 rounded-xl text-xs hover:bg-white/10 transition flex items-center gap-2 text-pink-500 font-bold"><i class="fas fa-th-large"></i> DASHBOARD</a>
            <button onclick="window.print()" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-xl font-black text-xs transition-all flex items-center gap-2 uppercase">PRINT <i class="fas fa-print"></i></button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="glass p-6 rounded-[2rem] border-l-4 border-l-pink-600">
            <h4 class="text-gray-500 text-[9px] uppercase tracking-widest font-bold mb-1">Total Items Returned</h4>
            <p class="text-2xl font-black italic text-pink-500"><?= number_format($total_item_retur, 0, ',', '.') ?> <span class="text-xs font-normal text-gray-600 italic">Units</span></p>
        </div>
        <div class="glass p-6 rounded-[2rem]">
            <h4 class="text-gray-500 text-[9px] uppercase tracking-widest font-bold mb-1">Affected Materials</h4>
            <p class="text-2xl font-black italic text-white"><?= $total_jenis_bahan ?> <span class="text-xs font-normal text-gray-600 italic">SKU</span></p>
        </div>
    </div>

    <div class="glass p-8 rounded-[2rem] mb-8">
        <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 mb-6 flex items-center gap-2">
            <i class="fas fa-box-open text-pink-500"></i> Return Frequency by Material ID
        </h3>
        <div class="h-[250px]">
            <canvas id="returChart"></canvas>
        </div>
    </div>

    <div class="glass rounded-[2rem] overflow-hidden shadow-2xl">
        <div class="p-6 border-b border-white/5">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Material Integrity Log</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-500 uppercase text-[9px] tracking-widest">
                        <th class="p-5 font-bold">Material ID</th>
                        <th class="p-5 font-bold text-right">Quantity Returned</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    // Menampilkan data dari array yang sudah diproses di atas
                    foreach ($labels as $index => $label): 
                    ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-5 font-bold text-gray-200 text-sm font-mono"><?= htmlspecialchars($label); ?></td>
                        <td class="p-5 text-right font-mono font-bold text-pink-500 text-sm"><?= number_format($values[$index], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Supply Chain Integrity
        </p>
    </footer>
</div>

<script>
new Chart(document.getElementById('returChart'), {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels); ?>,
        datasets: [{
            label: 'Total Retur',
            data: <?= json_encode($values); ?>,
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
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(255, 255, 255, 0.05)' },
                ticks: { color: '#64748b', font: { size: 10 } }
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