<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php';
$jadwal = tampil("SELECT * FROM jadwal_tayang;");
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Tayang - STATIC.</title>
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
        .table-row:hover {
            background: rgba(233, 30, 99, 0.05); /* Pink-500 tint */
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">SHOW <span class="text-pink-600">TIMES</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Cinema Broadcasting Schedule</p>
        </div>
        <div class="flex gap-4">
            <a href="dashboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-th-large text-pink-600"></i> Dashboard
            </a>
            <a href="tambah_jadwal.php" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-pink-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-calendar-plus"></i> Atur Jadwal
            </a>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold text-center w-20">No</th>
                        <th class="p-6 font-bold">ID Jadwal</th>
                        <th class="p-6 font-bold">Informasi Film</th>
                        <th class="p-6 font-bold text-center">Studio</th>
                        <th class="p-6 font-bold text-center">Waktu Mulai</th>
                        <th class="p-6 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php $i = 1; foreach ($jadwal as $row) : ?>
                    <tr class="table-row">
                        <td class="p-6 text-center text-gray-500 font-mono text-sm"><?= $i; ?></td>
                        <td class="p-6">
                            <span class="px-3 py-1 rounded-lg bg-white/5 text-pink-500 font-mono text-xs font-bold border border-pink-500/20">
                                <?= htmlspecialchars($row["id_jadwal"]); ?>
                            </span>
                        </td>
                        <td class="p-6">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-10 bg-pink-600 rounded-full"></div>
                                <div>
                                    <span class="block font-bold text-white uppercase tracking-tight italic">Movie ID: <?= htmlspecialchars($row["id_film"]); ?></span>
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Cinema Main Schedule</span>
                                </div>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            <span class="inline-block px-4 py-1 rounded-full bg-white/5 text-gray-300 font-black text-xs border border-white/10 uppercase">
                                <?= htmlspecialchars($row["id_studio"]); ?>
                            </span>
                        </td>
                        <td class="p-6 text-center font-bold text-white font-mono">
                            <i class="far fa-clock text-pink-600 mr-2"></i><?= htmlspecialchars($row["waktu_mulai"]); ?> WIB
                        </td>
                        <td class="p-6">
                            <div class="flex justify-center gap-2">
                                <a href="ubah_jadwal.php?id_jadwal=<?= $row["id_jadwal"]; ?>" 
                                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-pink-600 hover:text-white text-gray-400 transition-all">
                                    <i class="fas fa-edit text-xs"></i>
                                </a>
                                <a href="hapus_jadwal.php?id_jadwal=<?= $row["id_jadwal"]; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                   class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-600 hover:text-white text-red-500 transition-all">
                                    <i class="fas fa-trash-alt text-xs"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php $i++; endforeach; ?>
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