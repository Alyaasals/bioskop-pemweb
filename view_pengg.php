<?php 
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Penggunaan - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic text-white">USAGE <span class="text-pink-600">LIST</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Material Consumption Records</p>
        </div>
        <div class="flex gap-3">
            <a href="form_peng_bb.php" class="bg-pink-600 hover:bg-pink-700 text-white px-6 py-2 rounded-xl font-black text-xs transition-all flex items-center gap-2 uppercase shadow-lg shadow-pink-600/20">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>
    </div>

    <div class="glass rounded-[2rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="p-6 border-b border-white/5">
            <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-500 italic">Daftar Penggunaan Bahan Baku</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-center border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-500 uppercase text-[9px] tracking-widest font-black">
                        <th class="p-5">ID Penggunaan</th>
                        <th class="p-5">Tanggal</th>
                        <th class="p-5">Total (Rp)</th>
                        <th class="p-5">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php
                    // Logika Query Asli
                    $sql = "SELECT * FROM penggunaan_bahan_baku ORDER BY id_penggunaan DESC";
                    $result = mysqli_query($koneksi, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <tr class="hover:bg-white/[0.02] transition-colors">
                        <td class="p-5 font-mono text-xs text-gray-200"><?= $row['id_penggunaan']; ?></td>
                        <td class="p-5 text-sm text-gray-300 italic"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                        <td class="p-5 font-mono text-sm text-pink-500 font-bold">
                            <?= number_format($row['total'], 0, ',', '.'); ?>
                        </td>
                        <td class="p-5">
                            <a href="detail_penggunaan.php?id=<?= $row['id_penggunaan']; ?>" 
                               class="inline-block bg-white/5 hover:bg-pink-600/20 text-pink-500 border border-pink-500/20 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter transition-all">
                                <i class="fas fa-info-circle mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Supply Chain Analytics
        </p>
    </footer>
</div>

</body>
</html>