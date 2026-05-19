<?php
require 'koneksi.php';

// Logika PHP asli (tidak diubah)
$query = "SELECT s.id_retur, s.id_bhn_baku, s.id_pembelian, b.status_selesai AS status
          FROM detail_retur_bahan_baku s 
          LEFT JOIN pembelian_bahan_baku b ON s.id_pembelian = b.id_pembelian
          GROUP BY s.id_retur";
$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Transaksi Retur - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.85)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
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
                <h1 class="text-4xl font-black tracking-tighter">DAFTAR <span class="text-pink-600">RETUR</span></h1>
                <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Cinema Management System</p>
            </div>
            <a href="dahboard.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-pink-600"></i> Kembali ke Dashboard
            </a>
        </div>

        <div class="mb-6">
            <a href="tambah_retur.php" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20 inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Detail Retur
            </a>
        </div>

        <div class="glass rounded-[2.5rem] overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold">No</th>
                        <th class="p-6 font-bold">ID Retur</th>
                        <th class="p-6 font-bold">ID Bahan Baku</th>
                        <th class="p-6 font-bold">ID Pembelian</th>
                        <th class="p-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                <?php 
                $no = 1;
                while($row = mysqli_fetch_assoc($data)): ?>
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="p-6 text-sm text-gray-400"><?= $no++; ?></td>
                        <td class="p-6 font-mono text-pink-500 font-bold"><?= $row['id_retur']; ?></td>
                        <td class="p-6 text-sm"><?= $row['id_bhn_baku']; ?></td>
                        <td class="p-6 text-sm"><?= $row['id_pembelian']; ?></td>
                        <td class="p-6">
                            <div class="flex justify-center gap-3">
                                <a href="detail_retur.php?id=<?= $row['id_retur'] ?>" 
                                   class="bg-cyan-600/20 text-cyan-400 border border-cyan-600/30 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-cyan-600 hover:text-white transition">
                                   Detail
                                </a>                
                                <a href="selesai_retur.php?id=<?= $row['id_retur'] ?>" 
                                   class="bg-green-600/20 text-green-400 border border-green-600/30 px-4 py-1.5 rounded-lg text-xs font-bold hover:bg-green-600 hover:text-white transition">
                                   Selesai
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