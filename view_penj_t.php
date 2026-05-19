<?php
require 'koneksi.php';
// Menggunakan query asli Anda
$trns = tampil("SELECT * FROM penjualan_tiket");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Penjualan Tiket - STATIC.</title>
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
        }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .text-maroon-custom {
            color: #ef4444; /* Merah cerah untuk ID */
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase">PENJUALAN <span class="text-pink-600">TIKET</span></h1>
                <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Cinema Management System</p>
            </div>
            <a href="dahboard.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-pink-600"></i> Dashboard
            </a>
        </div>

        <div class="mb-6">
            <a href="form_penj_t.php" class="bg-red-700 hover:bg-red-800 text-white px-6 py-3 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-red-900/20 inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Transaksi Baru
            </a>
        </div>

        <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold">ID Transaksi</th>
                        <th class="p-6 font-bold">Tanggal</th>
                        <th class="p-6 font-bold text-right">Total Penjualan</th>
                        <th class="p-6 font-bold text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach($trns as $data): ?>
                        <?php
                            $status_transaksi = htmlspecialchars($data['status_selesai']);
                            
                            if ($status_transaksi == 'Dalam Proses') {
                                $btn_style = 'bg-yellow-600/20 text-yellow-400 border-yellow-600/30';
                                $link_target = "form_penj_t.php?id_penjualan_tiket=".$data['id_penjualan_tiket']; 
                            } else {
                                $btn_style = 'bg-green-600/20 text-green-400 border-green-600/30'; 
                                $link_target = "detail_penj_t.php?id=".$data['id_penjualan_tiket']; 
                            }
                        ?>
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-6 font-mono font-bold text-maroon-custom">
                                <?= htmlspecialchars($data['id_penjualan_tiket']) ?>
                            </td>
                            <td class="p-6 text-sm text-gray-300">
                                <?= htmlspecialchars($data['tanggal_transaksi']) ?>
                            </td>
                            <td class="p-6 text-right font-bold text-green-400">
                                <?= formatRp($data['total_harga']) ?>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center">
                                    <a href="<?= $link_target ?>" 
                                       class="<?= $btn_style ?> border px-4 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider transition hover:opacity-80">
                                       <?= $status_transaksi ?>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <footer class="mt-10 text-center text-gray-600 text-[10px] tracking-[0.4em] uppercase">
            &copy; 2025 STATIC. Cinema Elite Management System
        </footer>
    </div>

</body>
</html>