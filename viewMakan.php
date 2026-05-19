<?php
require 'koneksi.php';

// --- LOGIKA ASLI ANDA ---
$query = "SELECT * FROM penjualan_makan_minum ORDER BY id_penj_mkn_min DESC";
$transaksi = tampil($query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi Penjualan Tiket - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
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

        /* Tombol Tambah Data (+ Tambah Data) */
        .btn-tambah {
            background-color: #e74c3c; /* Merah sesuai gambar */
            border: none;
            color: white;
            font-weight: bold;
            padding: 8px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        /* Kotak Tabel (Card) */
        .card-table {
            background-color: var(--bg-card);
            border: 1px solid var(--color-border);
            border-radius: 8px;
            overflow: hidden;
        }

        .table {
            color: var(--color-text);
            margin-bottom: 0;
        }

        /* Header Tabel (ID TRANSAKSI, TANGGAL, dll) */
        .table thead th {
            background-color: transparent;
            color: var(--color-accent);
            border-bottom: 2px solid var(--color-border);
            border-top: none;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1px;
        }

        /* Baris Tabel */
        .table tbody td {
            border-top: 1px solid var(--color-border);
            padding: 12px 15px;
            vertical-align: middle;
        }

        /* Tombol Aksi (Lihat Detail) */
        .btn-lihat {
            background-color: #2ecc71;
            color: white;
            border-radius: 4px;
            padding: 5px 12px;
            font-size: 0.8rem;
            text-decoration: none;
        }
        
        .btn-lihat:hover {
            background-color: #2980b9;
            color: white;
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase">PENJUALAN <span class="text-pink-600">FNB</span></h1>
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
                    <tr>
                        <th class="p-6 font-bold">ID TRANSAKSI</th>
                        <th class="p-6 font-bold">TANGGAL TRANSAKSI</th>
                        <th class="p-6 font-bold text-right">TOTAL TRANSAKSI</th>
                        <th class="p-6 font-bold text-center">STATUS TRANSAKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php foreach ($transaksi as $row) : ?>
                        <?php
                            $status_transaksi = htmlspecialchars($row['status_selesai']);
                            
                            if ($status_transaksi == 'Dalam Proses') {
                                $btn_style = 'bg-yellow-600/20 text-yellow-400 border-yellow-600/30';
                                $link_target = "formMakan.php?id_penjualan_tiket=".$row['id_penj_mkn_min']; 
                            } else {
                                $btn_style = 'bg-green-600/20 text-green-400 border-green-600/30'; 
                                $link_target = "detailMakan.php?id=".$row['id_penj_mkn_min']; 
                            }
                        ?>
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="p-6 font-mono font-bold text-maroon-custom"><?= $row['id_penj_mkn_min']; ?></td>
                        <td class="p-6 text-sm text-gray-300"><?= $row['tanggal']; ?></td>
                        <td class="p-6 text-right font-bold text-green-400"><?= formatRp($row['total_harga']); ?></td>
                        <td class="p-6">
                            <a href="detailMakan.php?id=<?= $row['id_penj_mkn_min']; ?>" class="btn-lihat">Selesai</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <footer class="mt-10 text-center text-gray-600 text-[10px] tracking-[0.4em] uppercase">
            &copy; 2025 STATIC. Cinema Elite Management System
        </footer>
    </div>


</body>
</html>