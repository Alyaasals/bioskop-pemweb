<?php
include 'koneksi.php';

// Query standar SELECT * FROM bahan_baku
$query = "SELECT * FROM bahan_baku";
$data = mysqli_query($koneksi, $query); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Bahan Baku - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1587582423116-ec07293f0395?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        .table-row:hover {
            background: rgba(59, 130, 246, 0.05);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">RAW <span class="text-blue-500">MATERIALS</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Warehouse & Inventory Management</p>
        </div>
        <div class="flex gap-4">
            <a href="dahboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-th-large text-blue-500"></i> Dashboard
            </a>
            <a href="tambahBahanBaku.php" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-blue-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-plus"></i> Add Item
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="glass p-6 rounded-[2rem] border-l-4 border-blue-500">
            <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Total Komoditas</p>
            <p class="text-2xl font-black"><?= mysqli_num_rows($data) ?> Jenis</p>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold text-center w-16">No</th>
                        <th class="p-6 font-bold">ID & Nama Bahan</th>
                        <th class="p-6 font-bold text-right">Nilai Aset (Total)</th>
                        <th class="p-6 font-bold text-center">Stok</th>
                        <th class="p-6 font-bold">Keterangan</th>
                        <th class="p-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    $no = 1;
                    mysqli_data_seek($data, 0); // Reset pointer jika diperlukan
                    while($row = mysqli_fetch_assoc($data)): 
                    ?>
                    <tr class="table-row">
                        <td class="p-6 text-center text-gray-500 font-mono text-sm"><?= $no++; ?></td>
                        <td class="p-6">
                            <span class="block font-bold text-white uppercase tracking-tight"><?= htmlspecialchars($row['nama_bhn_baku']) ?></span>
                            <span class="text-[10px] font-mono text-blue-500 font-bold uppercase tracking-widest"><?= htmlspecialchars($row['id_bhn_baku']) ?></span>
                        </td>
                        <td class="p-6 text-right font-bold text-white font-mono">
                            <?= formatRp($row['total']); ?>
                        </td>
                        <td class="p-6 text-center">
                            <span class="inline-block px-4 py-1 rounded-full bg-blue-500/10 text-blue-400 font-black text-xs border border-blue-500/20">
                                <?= htmlspecialchars($row['jumlah']) ?> Unit
                            </span>
                        </td>
                        <td class="p-6 text-sm text-gray-400 italic">
                            <?= htmlspecialchars($row['keterangan']) ?>
                        </td>
                        <td class="p-6">
                            <div class="flex justify-center gap-2">
                                <a href="editBahanBaku.php?id=<?= urlencode($row['id_bhn_baku']) ?>" 
                                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-blue-600 hover:text-white text-gray-400 transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="deleteBahanBaku.php?id=<?= urlencode($row['id_bhn_baku']) ?>" 
                                   onclick="return confirm('Yakin ingin menghapus bahan ini?')"
                                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-600 hover:text-white text-red-500 transition-all">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-12 text-center">
        <p class="text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Cinema Elite Management System
        </p>
    </footer>
</div>

</body>
</html>