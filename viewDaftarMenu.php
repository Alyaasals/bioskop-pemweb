<?php
require 'koneksi.php'; 
$daftar_menu = tampil_menu("SELECT * FROM menu"); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu F&B - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1594212699903-ec8a3eca50f5?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80');
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
        .menu-card:hover {
            transform: translateY(-10px);
            border-color: rgba(245, 158, 11, 0.4); /* Amber-500 */
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-center mb-12 gap-6">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none text-center md:text-left">
                SNACK <span class="text-amber-500">& BAR</span>
            </h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-3 text-center md:text-left">Cinema Food & Beverage Management</p>
        </div>
        <div class="flex gap-4">
            <a href="dashboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-home text-amber-500"></i>
            </a>
            <a href="tambahMenu.php" class="bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-amber-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-plus"></i> Add New Menu
            </a>
        </div>
    </div>

    <div class="flex gap-4 mb-10 overflow-x-auto pb-2">
        <button class="glass px-6 py-2 rounded-full text-xs font-bold uppercase tracking-widest border-amber-500/50 text-amber-500">All Items</button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php foreach ($daftar_menu as $row) : ?>
            <div class="glass menu-card p-6 rounded-[2.5rem] relative group">
                <div class="absolute -top-3 -right-3 bg-amber-600 text-[10px] font-black px-4 py-1 rounded-full shadow-lg">
                    <?= htmlspecialchars($row['id_menu']); ?>
                </div>

                <div class="mb-6">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] uppercase tracking-[0.2em] font-bold text-amber-500/70">
                            <?= htmlspecialchars($row['jenis']); ?>
                        </span>
                    </div>
                    <h3 class="text-xl font-bold text-white leading-tight mb-1 group-hover:text-amber-400 transition">
                        <?= htmlspecialchars($row['nama']); ?>
                    </h3>
                </div>

                <div class="bg-white/5 rounded-3xl p-4 mb-6">
                    <p class="text-[10px] uppercase tracking-widest text-gray-500 font-bold mb-1">Unit Price</p>
                    <p class="text-2xl font-black text-white"><?= formatRp($row['harga']); ?></p>
                </div>

                <div class="flex gap-3">
                    <a href="ubah_menu.php?id_menu=<?= $row["id_menu"]; ?>" 
                    class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-pink-600 hover:text-white text-gray-400 transition-all">
                    <i class="fas fa-edit text-xs"></i>
                    </a>
                    <a href="hapus_menu.php?id_menu=<?= htmlspecialchars($row['id_menu']); ?>" 
                       onclick="return confirm('Yakin ingin menghapus menu ini?');"
                       class="w-12 h-12 flex items-center justify-center rounded-2xl bg-red-500/10 text-red-500 hover:bg-red-600 hover:text-white transition-all">
                        <i class="fas fa-trash-alt text-xs"></i>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <footer class="mt-20 text-center">
        <p class="text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Cinema Elite Management System
        </p>
    </footer>
</div>

</body>
</html>