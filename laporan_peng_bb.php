<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';
$query = mysqli_query($koneksi, "SELECT tanggal, SUM(total) as subtotal FROM penggunaan_bahan_baku GROUP BY tanggal ORDER BY tanggal ASC");
$labels = []; $values = [];
while ($row = mysqli_fetch_assoc($query)) {
    $labels[] = date('d/m', strtotime($row['tanggal']));
    $values[] = $row['subtotal'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penggunaan - STATIC.</title>
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
        .nav-glass { background: rgba(0, 0, 0, 0.6); backdrop-filter: blur(10px); border-bottom: 1px solid rgba(255, 255, 255, 0.1); }
    </style>
</head>
<body class="pb-10">

    <nav class="nav-glass sticky top-0 z-50 mb-10">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a class="text-xl font-black tracking-tighter italic text-white" href="#">
                SIG(NE)<span class="text-pink-600">MA</span>
            </a>
            <div class="flex gap-6">
                <a class="text-xs font-bold uppercase tracking-widest text-pink-500 border-b-2 border-pink-500 pb-1" href="laporan_grafik.php">Laporan Grafik</a>
                <a class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition" href="laporan_tabel.php">Laporan Tabel</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic">USAGE <span class="text-pink-600">ANALYTICS</span></h1>
                <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Material Consumption Trend</p>
            </div>
            <a href="dashboard.php" class="glass px-5 py-2 rounded-xl text-xs hover:bg-white/10 transition flex items-center gap-2 text-pink-500 font-bold uppercase border border-pink-500/20">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        <div class="glass p-8 rounded-[2rem] shadow-2xl border border-white/5">
            <div class="flex items-center gap-2 mb-8">
                <div class="w-2 h-2 bg-pink-600 rounded-full animate-pulse"></div>
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500">Grafik Tren Penggunaan Bahan Baku</h3>
            </div>
            <div class="h-[400px]">
                <canvas id="myChart"></canvas>
            </div>
        </div>

        <footer class="mt-16 text-center">
            <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
                &copy; 2025 STATIC. Supply Chain Analytics
            </p>
        </footer>
    </div>

    <script>
        const ctx = document.getElementById('myChart').getContext('2d');
        
        // Gradient untuk Line Chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(219, 39, 119, 0.4)');
        gradient.addColorStop(1, 'rgba(219, 39, 119, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [{
                    label: 'Total Biaya (Rp)',
                    data: <?= json_encode($values) ?>,
                    borderColor: '#db2777', // Pink-600
                    backgroundColor: gradient,
                    borderWidth: 4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#db2777',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#111',
                        padding: 12,
                        titleFont: { size: 10, weight: 'bold' },
                        bodyFont: { size: 13 },
                        callbacks: {
                            label: function(context) {
                                return ' Rp ' + context.raw.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        grid: { color: 'rgba(255, 255, 255, 0.05)' },
                        ticks: { 
                            color: '#64748b', 
                            font: { size: 11 },
                            callback: function(value) {
                                return 'Rp ' + (value / 1000).toLocaleString('id-ID') + 'k';
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#64748b', font: { size: 11, weight: 'bold' } }
                    }
                }
            }
        });
    </script>
</body>
</html>