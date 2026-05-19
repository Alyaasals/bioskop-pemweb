<?php
require 'koneksi.php';

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
$id = $_GET['id'] ?? null; 

if (!$id) {
    die("ID Transaksi tidak ditemukan.");
}

$detail = GetDetailMakanMinum($id); 
$total = TotalMakanMinum($id);     

$status = $detail[0]['status_selesai'] ?? 'Data tidak ditemukan'; 

if ($status == 'Selesai') {
    $status_class = 'text-green-400 border-green-500/30 bg-green-500/10';
    $status_text = 'Selesai';
} elseif ($status == 'Dalam Proses') {
    $status_class = 'text-yellow-400 border-yellow-500/30 bg-yellow-500/10';
    $status_text = 'Dalam Proses';
} else {
    $status_class = 'text-red-400 border-red-500/30 bg-red-500/10';
    $status_text = 'Tidak Ditemukan';
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail F&B #<?= htmlspecialchars($id) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1513104890138-7c749659a591?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
            <h1 class="text-4xl font-black tracking-tighter uppercase">RINGKASAN <span class="text-yellow-500">PESANAN</span></h1>
            <div class="flex items-center gap-3 mt-2">
                <span class="text-gray-500 text-[10px] tracking-[0.3em] uppercase font-bold">Nota: #<?= htmlspecialchars($id) ?></span>
                <span class="px-3 py-1 rounded-full text-[9px] font-bold border <?= $status_class ?> uppercase tracking-wider">
                    <?= $status_text ?>
                </span>
            </div>
        </div>
        <a href="view_penj_m.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2 text-yellow-500 font-bold">
            <i class="fas fa-arrow-left"></i> KEMBALI
        </a>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl">
        <div class="bg-white/5 p-6 border-b border-white/10 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-yellow-500/20 rounded-2xl text-yellow-500">
                    <i class="fas fa-utensils"></i>
                </div>
                <div>
                    <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Kategori Transaksi</p>
                    <p class="text-sm font-bold uppercase">Food & Beverage</p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-[9px] text-gray-500 uppercase font-bold tracking-widest">Sistem</p>
                <p class="text-sm font-bold text-yellow-500 italic">STATIC. Elite Service</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-gray-500 uppercase text-[10px] tracking-widest bg-white/[0.02]">
                        <th class="p-6 font-bold">Nama Item</th>
                        <th class="p-6 font-bold text-center">Jumlah</th>
                        <th class="p-6 font-bold text-right">Harga Satuan</th>
                        <th class="p-6 font-bold text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (is_array($detail) && !empty($detail)): ?>
                        <?php foreach ($detail as $d): ?>
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-6">
                                <span class="block font-bold text-white"><?= htmlspecialchars($d['nama_menu']) ?></span>
                                <span class="text-[10px] text-gray-500">Menu ID: <?= htmlspecialchars($d['id_menu']) ?></span>
                            </td>
                            <td class="p-6 text-center">
                                <span class="bg-yellow-500/20 text-yellow-500 border border-yellow-500/30 px-3 py-1 rounded-lg font-mono font-bold">
                                    <?= htmlspecialchars($d['jumlah']) ?>
                                </span>
                            </td>
                            <td class="p-6 text-right text-sm text-gray-400"><?= formatRp($d['harga']) ?></td>
                            <td class="p-6 text-right font-bold text-white"><?= formatRp($d['subtotal']) ?></td>
                        </tr>
                        <?php endforeach ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="p-20 text-center">
                                <i class="fas fa-shopping-basket text-4xl text-gray-700 mb-4 block"></i>
                                <span class="text-gray-500 tracking-widest uppercase text-xs font-bold">Item tidak ditemukan dalam transaksi ini.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="bg-white/5 p-8 flex justify-end border-t border-white/10">
            <div class="text-right">
                <p class="text-[10px] uppercase tracking-[0.4em] text-gray-500 font-bold mb-1">Total Transaksi</p>
                <h2 class="text-4xl font-black text-yellow-500"><?= formatRp($total) ?></h2>
            </div>
        </div>
    </div>

    <p class="mt-8 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
        &copy; 2025 STATIC. Cinema Elite Management System
    </p>
</div>

</body>
</html>