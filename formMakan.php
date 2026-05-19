<?php
require 'koneksi.php';

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
$id_penj_mkn_min = AmbilIPenjualanMakanMinum(); 
$nominal = GetTotalMakanMinum($id_penj_mkn_min); 
$detail = GetDataDetailMakanMinum($id_penj_mkn_min); 
$menu_list = GetDataMenu();
$tanggal_transaksi = date('Y-m-d'); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi F&B - STATIC.</title>
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
        .input-glass {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 12px !important;
        }
        .input-glass:focus {
            border-color: #eab308 !important;
            box-shadow: 0 0 0 2px rgba(234, 179, 8, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">F&B <span class="text-yellow-500">SERVICE</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">STATIC. Cinema Management</p>
        </div>
        <a href="view_penj_m.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-list text-yellow-500"></i> Riwayat Transaksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] shadow-2xl border-t-4 border-yellow-500/50">
                <form action="tambahMakan.php" method="post" class="space-y-4">
                    <input type="hidden" name="id_penj_mkn_min" value="<?= $id_penj_mkn_min ?>">
                    
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">ID Transaksi</label>
                        <input type="text" class="input-glass w-full px-4 py-3 bg-white/5 opacity-70 font-mono" value="<?= $id_penj_mkn_min ?>" readonly>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Pilih Menu</label>
                        <select name="id_menu" class="input-glass w-full px-4 py-3" required>
                            <option value="">-- Pilih Menu --</option>
                            <?php foreach ($menu_list as $m) : ?>
                                <option value="<?= $m['id_menu'] ?>"><?= $m['nama_menu'] ?> - <?= formatRp($m['harga']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Jumlah Beli</label>
                        <input type="number" name="jumlah_beli" class="input-glass w-full px-4 py-3 text-lg font-bold" value="1" min="1" required>
                    </div>

                    <button type="submit" name="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-black py-4 rounded-2xl font-black tracking-widest text-sm transition-all shadow-lg shadow-yellow-900/30 mt-4">
                        TAMBAH KE KERANJANG <i class="fas fa-cart-plus ml-2"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] flex flex-col shadow-2xl">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-receipt mr-3 text-yellow-500"></i> Daftar Pesanan
                </h3>
                
                <div class="overflow-x-auto min-h-[300px]">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 uppercase text-[10px] tracking-widest border-b border-white/10">
                                <th class="pb-4 font-bold">Item Menu</th>
                                <th class="pb-4 font-bold text-center">Jumlah</th>
                                <th class="pb-4 font-bold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php if (!empty($detail)) : ?>
                                <?php foreach ($detail as $row) : ?>
                                    <tr class="hover:bg-white/[0.02] transition">
                                        <td class="py-4">
                                            <span class="block font-bold text-white"><?= htmlspecialchars($row['nama_menu']); ?></span>
                                            <span class="text-[9px] text-gray-500 uppercase tracking-widest">F&B Item</span>
                                        </td>
                                        <td class="py-4 text-center font-mono font-bold text-yellow-500"><?= htmlspecialchars($row['jumlah']); ?></td>
                                        <td class="py-4 text-right font-bold text-white"><?= formatRp($row['subtotal']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" class="py-20 text-center">
                                        <i class="fas fa-shopping-basket text-4xl text-gray-800 mb-4 block"></i>
                                        <span class="text-gray-500 tracking-widest uppercase text-xs font-bold">Keranjang masih kosong</span>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 pt-8 border-t-2 border-dashed border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 font-bold mb-1">Grand Total</p>
                        <h2 class="text-4xl font-black text-yellow-500"><?= formatRp($nominal) ?></h2>
                    </div>
                    <a href="selesaiMakan.php?id_penj_mkn_min=<?= urlencode($id_penj_mkn_min) ?>" 
                       class="bg-white text-black px-10 py-4 rounded-2xl font-black tracking-widest text-sm transition-all hover:bg-yellow-500 shadow-xl flex items-center gap-3"
                       onclick="return confirm('Selesaikan transaksi?')">
                       SELESAI TRANSAKSI <i class="fas fa-check-circle text-lg"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>