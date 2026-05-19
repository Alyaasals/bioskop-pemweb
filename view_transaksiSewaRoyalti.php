<?php 
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include "koneksi.php";

$querySewaRoyalti = mysqli_query($koneksi, "
    SELECT sewa_royalti.*, film.nama_film
    FROM sewa_royalti
    JOIN film ON sewa_royalti.id_film = film.id_film
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa & Royalti Film - STATIC.</title>
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

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase">SEWA & <span class="text-indigo-500">ROYALTI</span></h1>
                <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Film Licensing Management</p>
            </div>
            <a href="dahboard.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-indigo-500"></i> Dashboard
            </a>
        </div>

        <div class="mb-6">
            <a href="form_TransaksiSewaRoyalti.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-indigo-900/20 inline-flex items-center gap-2">
                <i class="fas fa-film"></i> Tambah Sewa Film Baru
            </a>
        </div>

        <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border-t border-white/10">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold">ID Sewa</th>
                        <th class="p-6 font-bold">Informasi Film</th>
                        <th class="p-6 font-bold">Periode Tayang</th>
                        <th class="p-6 font-bold text-right">Harga Sewa</th>
                        <th class="p-6 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php 
                    if (mysqli_num_rows($querySewaRoyalti) > 0):
                        while ($dataSewa = mysqli_fetch_assoc($querySewaRoyalti)): 
                    ?>
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-6 font-mono font-bold text-indigo-400">
                                <?= htmlspecialchars($dataSewa['id_sewa']); ?>
                            </td>
                            <td class="p-6">
                                <span class="block font-bold text-white text-lg"><?= htmlspecialchars($dataSewa['nama_film']); ?></span>
                                <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Master Film ID: <?= htmlspecialchars($dataSewa['id_film']); ?></span>
                            </td>
                            <td class="p-6">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 text-xs text-gray-300">
                                        <i class="far fa-calendar-check text-indigo-500"></i> 
                                        <?= htmlspecialchars($dataSewa['tanggal_sewa']); ?>
                                    </div>
                                    <div class="flex items-center gap-2 text-xs text-gray-500">
                                        <i class="far fa-calendar-times text-red-500"></i> 
                                        <?= htmlspecialchars($dataSewa['tanggal_tutup_tayang']); ?>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-right font-bold text-white font-mono text-lg">
                                Rp <?= number_format($dataSewa['harga'], 0, ',', '.'); ?>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center">
                                    <?php 
                                        $isSelesai = ($dataSewa['status_selesai'] == 'Selesai');
                                        $statusClass = $isSelesai 
                                            ? 'bg-green-600/20 text-green-400 border-green-600/30' 
                                            : 'bg-yellow-600/20 text-yellow-400 border-yellow-600/30';
                                    ?>
                                    <span class="<?= $statusClass ?> border px-4 py-1.5 rounded-full text-[9px] font-black uppercase tracking-wider">
                                        <?= htmlspecialchars($dataSewa['status_selesai']); ?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                    <?php 
                        endwhile; 
                    else:
                    ?>
                         <tr>
                            <td colspan="5" class="p-20 text-center">
                                <i class="fas fa-compact-disc text-4xl text-gray-800 mb-4 block animate-spin-slow"></i>
                                <p class="text-gray-500 tracking-[0.3em] uppercase text-xs font-bold">Belum ada data transaksi sewa royalti.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <footer class="mt-10 text-center text-gray-600 text-[10px] tracking-[0.4em] uppercase">
            &copy; 2025 STATIC. Cinema Elite Management System
        </footer>
    </div>

    <style>
        @keyframes spin-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .animate-spin-slow {
            animation: spin-slow 8s linear infinite;
        }
    </style>

</body>
</html>