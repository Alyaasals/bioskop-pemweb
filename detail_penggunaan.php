<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM penggunaan_bahan_baku WHERE id_penggunaan = '$id'");
$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - STATIC.</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
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
<body class="py-10 px-6 flex items-center justify-center">

<div class="w-full max-w-2xl">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black tracking-tighter uppercase italic text-white leading-none">TRANSACTION <span class="text-pink-600">DETAIL</span></h1>
        <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Verified Consumption Log</p>
    </div>

    <div class="glass p-1 rounded-[2.5rem] shadow-2xl border border-white/5 overflow-hidden">
        <div class="bg-white/5 px-8 py-4 border-b border-white/10 flex justify-between items-center">
            <span class="text-[10px] font-bold uppercase tracking-widest text-pink-500">ID: <?= $data['id_penggunaan']; ?></span>
            <i class="fas fa-file-invoice text-gray-600"></i>
        </div>
        
        <div class="p-8">
            <table class="w-full text-left">
                <tr class="border-b border-white/5">
                    <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold">ID Jurnal</th>
                    <td class="py-4 font-mono text-sm text-gray-200"><?= $data['id_jurnal']; ?></td>
                </tr>
                <tr class="border-b border-white/5">
                    <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold">Tanggal</th>
                    <td class="py-4 text-sm text-gray-200 italic"><?= date('d F Y', strtotime($data['tanggal'])); ?></td>
                </tr>
                <tr>
                    <th class="py-4 text-[10px] uppercase tracking-widest text-gray-500 font-bold">Total Biaya</th>
                    <td class="py-4 text-2xl font-black text-pink-500 italic">
                        Rp <?= number_format($data['total'], 0, ',', '.'); ?>
                    </td>
                </tr>
            </table>

            <div class="mt-10 flex gap-4">
                <a href="view_pengg.php" class="flex-1 bg-pink-600 hover:bg-pink-700 text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] transition-all shadow-xl shadow-pink-600/20 text-center flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-left"></i> Kembali ke Laporan
                </a>
                <button onclick="window.print()" class="glass px-6 py-4 rounded-2xl text-gray-400 hover:text-white transition">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>
    </div>

    <footer class="mt-12 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            STATIC. Supply Chain Analytics &copy; 2025
        </p>
    </footer>
</div>

</body>
</html>