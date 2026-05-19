<?php 
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Tabel - STATIC.</title>
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
                <a class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-white transition" href="laporan_peng_bb.php">Laporan Grafik</a>
                <a class="text-xs font-bold uppercase tracking-widest text-pink-500 border-b-2 border-pink-500 pb-1" href="laporan_tabel.php">Laporan Tabel</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-6">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase leading-none italic">USAGE <span class="text-pink-600">HISTORY</span></h1>
                <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Material Usage Detailed Logs</p>
            </div>
            <div class="flex gap-3">
                <a href="dashboard.php" class="glass px-5 py-2 rounded-xl text-xs hover:bg-white/10 transition flex items-center gap-2 text-pink-500 font-bold uppercase border border-pink-500/20">
                    <i class="fas fa-th-large"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="glass rounded-[2rem] overflow-hidden shadow-2xl border border-white/5">
            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="text-[10px] font-bold uppercase tracking-widest text-gray-400 italic">Riwayat Penggunaan Bahan Baku</h3>
                <span class="text-[9px] bg-pink-600/20 text-pink-500 px-3 py-1 rounded-full font-bold uppercase tracking-tighter border border-pink-500/30">Live Records</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-center border-collapse">
                    <thead>
                        <tr class="bg-white/5 text-gray-500 uppercase text-[9px] tracking-widest font-black">
                            <th class="p-5">ID Penggunaan</th>
                            <th class="p-5">ID Jurnal</th>
                            <th class="p-5">Tanggal</th>
                            <th class="p-5">Total (Rp)</th>
                            <th class="p-5">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <?php
                        // Query Asli
                        $res = mysqli_query($koneksi, "SELECT * FROM penggunaan_bahan_baku ORDER BY tanggal DESC");
                        while ($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="p-5 font-mono text-xs text-gray-200"><?= $row['id_penggunaan']; ?></td>
                            <td class="p-5 font-mono text-xs text-gray-400"><?= $row['id_jurnal']; ?></td>
                            <td class="p-5 text-sm text-gray-300 italic"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                            <td class="p-5 font-mono text-sm text-pink-500 font-bold">
                                <?= number_format($row['total'], 0, ',', '.'); ?>
                            </td>
                            <td class="p-5">
                                <a href="hapus.php?id=<?= $row['id_penggunaan']; ?>" 
                                   class="inline-block bg-white/5 hover:bg-red-600/20 text-red-500 border border-red-500/20 px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-tighter transition-all"
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    <i class="fas fa-trash-alt mr-1"></i> Hapus
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <footer class="mt-16 text-center">
            <p class="text-[10px] text-gray-800 uppercase tracking-[0.5em] font-bold">
                &copy; 2025 STATIC. Supply Chain Analytics
            </p>
        </footer>
    </div>

</body>
</html>