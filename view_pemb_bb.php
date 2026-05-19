<?php
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

$data = mysqli_query($koneksi,"
    SELECT * FROM pembelian_bahan_baku
    ORDER BY id_pembelian ASC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pembelian Bahan Baku - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase">PEMBELIAN <span class="text-blue-500">BAHAN BAKU</span></h1>
                <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Inventory & Procurement System</p>
            </div>
            <a href="dahboard.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-blue-500"></i> Dashboard
            </a>
        </div>

        <div class="mb-6 text-right">
            <a href="tambah_pemb_bb.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Transaksi Pembelian
            </a>
        </div>

        <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border-t border-white/10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold text-center w-16">No</th>
                        <th class="p-6 font-bold">ID Pembelian</th>
                        <th class="p-6 font-bold">Tanggal</th>
                        <th class="p-6 font-bold text-right">Total Harga</th>
                        <th class="p-6 font-bold text-center">Status</th>
                        <th class="p-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php $no=1; while($row=mysqli_fetch_assoc($data)): ?>
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-6 text-center text-gray-500 font-mono text-sm"><?= $no++ ?></td>
                            <td class="p-6">
                                <span class="font-mono font-bold text-blue-400"><?= $row['id_pembelian'] ?></span>
                                <div class="text-[9px] text-gray-600 font-bold tracking-widest uppercase mt-1">Jurnal: <?= $row['id_jurnal'] ?></div>
                            </td>
                            <td class="p-6 text-sm text-gray-300">
                                <?= htmlspecialchars($row['tgl_pembelian']) ?>
                            </td>
                            <td class="p-6 text-right font-bold text-white font-mono">
                                <?= formatRp($row['total_harga']) ?>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center">
                                    <?php if($row['status_selesai'] == "Selesai"): ?>
                                        <span class="bg-green-600/20 text-green-400 border border-green-600/30 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                            Selesai
                                        </span>
                                    <?php else: ?>
                                        <span class="bg-yellow-600/20 text-yellow-400 border border-yellow-600/30 px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-wider">
                                            Dalam Proses
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center">
                                    <a href="detail_pemb_bb.php?id=<?= $row['id_pembelian'] ?>" 
                                       class="glass border border-white/10 px-4 py-2 rounded-xl text-xs font-bold hover:bg-white/10 transition flex items-center gap-2">
                                       <i class="fas fa-eye text-blue-400"></i> Detail
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <footer class="mt-10 text-center text-gray-600 text-[10px] tracking-[0.4em] uppercase">
            &copy; 2025 STATIC. Cinema Elite Management System
        </footer>
    </div>

</body>
</html>