<?php
    // --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
    require 'koneksi.php';
    function getStatusBadge($status) {
        if ($status == 'Ongoing') {
            return '<span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-green-500/20 text-green-400 border border-green-500/30">Tayang</span>';
        } elseif ($status == 'Coming Soon') {
            return '<span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">Segera</span>';
        } else {
            return '<span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-500/20 text-red-400 border border-red-500/30">Selesai</span>';
        }
    }
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Master Film - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1485846234645-a62644f84728?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        .film-card:hover {
            transform: translateY(-10px);
            border-color: rgba(233, 30, 99, 0.4);
            background: rgba(255, 255, 255, 0.06);
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-end mb-12">
            <div>
                <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">MOVI<span class="text-pink-600">E</span> LIST</h1>
                <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Cinema Database Management</p>
            </div>
            <div class="flex gap-4">
                <a href="dahboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                    <i class="fas fa-th-large text-pink-500"></i> Dashboard
                </a>
                <a href="tambahFilm.php" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-pink-900/20 flex items-center gap-2 uppercase tracking-widest">
                    <i class="fas fa-plus"></i> Add Film
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php 
            $query = mysqli_query($koneksi, "SELECT * FROM film ORDER BY id_film DESC");
            while ($row = mysqli_fetch_assoc($query)) { 
                $harga_display = ($row['harga'] == 0) ? "N/A" : "Rp " . number_format($row['harga'], 0, ',', '.');
            ?>
            <div class="glass film-card rounded-[2.5rem] p-6 transition-all duration-500 flex flex-col justify-between border border-white/5">
                <div>
                    <div class="flex justify-between items-start mb-6">
                        <span class="font-mono text-[10px] text-gray-500 font-bold tracking-widest uppercase italic">ID: <?= $row['id_film']; ?></span>
                        <?= getStatusBadge($row['status_tayang']); ?>
                    </div>
                    
                    <h3 class="text-2xl font-black text-white mb-2 leading-tight uppercase tracking-tighter"><?= htmlspecialchars($row['nama_film']); ?></h3>
                    
                    <div class="flex items-center gap-4 text-gray-400 text-xs font-bold mb-6">
                        <span class="flex items-center gap-1"><i class="far fa-clock text-pink-500"></i> <?= htmlspecialchars($row['durasi']); ?> MIN</span>
                        <span class="text-gray-700">|</span>
                        <span class="flex items-center gap-1"><i class="fas fa-ticket-alt text-pink-500"></i> <?= $harga_display; ?></span>
                    </div>
                </div>

                <div class="mt-4 pt-6 border-t border-white/5 flex justify-end gap-3">
                    <a href="editFilm.php?id=<?= $row['id_film']; ?>" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-white/10 text-gray-400 hover:text-white transition">
                        <i class="fas fa-edit text-sm"></i>
                    </a>
                    <a href="hapusFilm.php?id=<?= $row['id_film']; ?>" 
                       onclick="return confirm('Hapus film <?= $row['nama_film']; ?>?')"
                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white transition">
                        <i class="fas fa-trash-alt text-sm"></i>
                    </a>
                </div>
            </div>
            <?php } ?>
        </div>

        <footer class="mt-20 text-center">
            <p class="text-[10px] text-gray-600 uppercase tracking-[0.6em] font-bold">
                &copy; 2025 STATIC. Cinema Elite Management System
            </p>
        </footer>
    </div>

</body>
</html>