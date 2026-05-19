<?php
// detail_penj_t.php
require 'koneksi.php';
$id = $_GET['id'];
$detail = GetDetailPenjualan($id); 
$total = TotalPenjualan($id);     

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
if (is_array($detail) && !empty($detail)) {
    $status = $detail[0]['status_selesai'] ?? 'Data tidak ditemukan'; 
    $tanggal_transaksi = $detail[0]['tanggal_transaksi'] ?? 'Tanggal Tidak Ditemukan';
    $tanggal_tampil = ($tanggal_transaksi != 'Tanggal Tidak Ditemukan') ? date('d-m-Y', strtotime($tanggal_transaksi)) : 'N/A';
} else {
    $status = 'Data Tidak Ditemukan';
    $tanggal_tampil = 'N/A';
}

$status_class = ($status == 'Selesai') ? 'text-green-400 border-green-500/30 bg-green-500/10' : 'text-yellow-400 border-yellow-500/30 bg-yellow-500/10'; 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penjualan Tiket #<?= htmlspecialchars($id) ?></title>
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
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-5xl mx-auto">
    <div class="flex justify-between items-end mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">DETAIL <span class="text-pink-600">TIKET</span></h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="text-gray-500 text-[10px] tracking-[0.3em] uppercase font-bold">No. Transaksi: <?= htmlspecialchars($id) ?></span>
                <span class="px-3 py-1 rounded-full text-[9px] font-bold border <?= $status_class ?> uppercase tracking-wider">
                    <?= $status ?>
                </span>
            </div>
        </div>
        <a href="view_penj_t.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-pink-600"></i> Kembali
        </a>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="bg-white/5 p-6 border-b border-white/10 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-pink-600/20 rounded-2xl">
                    <i class="fas fa-calendar-day text-pink-600"></i>
                </div>
                <div>
                    <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Tanggal Transaksi</p>
                    <p class="text-sm font-bold"><?= $tanggal_tampil ?></p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Sistem</p>
                <p class="text-sm font-bold text-blue-400 italic">STATIC. Elite</p>
            </div>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="text-gray-500 uppercase text-[10px] tracking-widest bg-white/[0.02]">
                    <th class="p-6 font-bold">Rincian Film & Studio</th>
                    <th class="p-6 font-bold text-center">Kursi</th>
                    <th class="p-6 font-bold text-right">Harga</th>
                    <th class="p-6 font-bold text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                <?php if (is_array($detail) && !empty($detail)): ?>
                    <?php foreach ($detail as $d): ?>
                    <tr class="hover:bg-white/[0.02] transition">
                        <td class="p-6">
                            <span class="block font-bold text-white"><?= htmlspecialchars($d['nama_film']) ?></span>
                            <span class="text-[10px] text-gray-500"><?= htmlspecialchars($d['nama_studio']) ?></span>
                        </td>
                        <td class="p-6 text-center">
                            <span class="bg-pink-600/20 text-pink-500 border border-pink-600/30 px-3 py-1 rounded-lg font-mono font-bold">
                                <?= htmlspecialchars($d['id_kursi']) ?>
                            </span>
                        </td>
                        <td class="p-6 text-right text-sm text-gray-400"><?= formatRp($d['harga']) ?></td>
                        <td class="p-6 text-right font-bold text-white"><?= formatRp($d['subtotal']) ?></td>
                    </tr>
                    <?php endforeach ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="p-20 text-center">
                            <i class="fas fa-exclamation-circle text-4xl text-gray-700 mb-4 block"></i>
                            <span class="text-gray-500 tracking-widest uppercase text-xs font-bold">Data rincian tidak ditemukan.</span>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="bg-white/5 p-8 flex justify-end border-t border-white/10">
            <div class="text-right">
                <p class="text-[10px] uppercase tracking-[0.4em] text-gray-500 font-bold mb-1">Grand Total</p>
                <h2 class="text-4xl font-black text-pink-500"><?= formatRp($total) ?></h2>
            </div>
        </div>
    </div>

    <p class="mt-8 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
        &copy; 2025 STATIC. Cinema Elite Management System
    </p>
</div>

</body>
</html>