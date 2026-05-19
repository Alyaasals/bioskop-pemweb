<?php
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

$id = $_GET['id'];

$q = mysqli_query($koneksi,"
    SELECT * FROM pembelian_bahan_baku
    WHERE id_pembelian='$id'
");
$data = mysqli_fetch_assoc($q);

$isSelesai = ($data['status_selesai'] == 'Selesai');
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pembelian - SIG(NE)MA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">DETAIL <span class="text-blue-500">PEMBELIAN</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">ID: <?= htmlspecialchars($id) ?></p>
        </div>
        <a href="view_pemb_bb.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-list text-blue-500"></i> Daftar Pembelian
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <?php if(!$isSelesai): ?>
            <div class="glass p-8 rounded-[2.5rem] shadow-2xl border-t-4 border-blue-500/50 sticky top-10">
                <h3 class="text-lg font-bold mb-6 flex items-center gap-2">
                    <i class="fas fa-plus-circle text-blue-500"></i> Tambah Item
                </h3>
                <form method="post" action="simpan_pemb_bb.php" class="space-y-4">
                    <input type="hidden" name="id_pembelian" value="<?= $id ?>">

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Bahan Baku</label>
                        <select name="id_bhn_baku" class="input-glass w-full px-4 py-3" required>
                            <option value="">Pilih Bahan Baku</option>
                            <?php
                            $bb = mysqli_query($koneksi,"SELECT * FROM bahan_baku");
                            while($b = mysqli_fetch_assoc($bb)){
                                echo "<option value='$b[id_bhn_baku]'>$b[nama_bhn_baku]</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Jumlah</label>
                            <input type="number" step="0.01" name="jumlah" class="input-glass w-full px-4 py-3" placeholder="0.00" required>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Harga Satuan</label>
                            <input type="number" name="harga_satuan" class="input-glass w-full px-4 py-3" placeholder="Rp" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Keterangan (Opsional)</label>
                        <input type="text" name="keterangan" class="input-glass w-full px-4 py-3" placeholder="...">
                    </div>

                    <button name="tambah" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black tracking-widest text-sm transition-all shadow-lg shadow-blue-900/30 mt-4">
                        TAMBAH ITEM <i class="fas fa-plus ml-2"></i>
                    </button>
                </form>
            </div>
            <?php else: ?>
            <div class="glass p-8 rounded-[2.5rem] text-center border-t-4 border-green-500/50">
                <i class="fas fa-check-circle text-green-500 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold uppercase tracking-tighter">Transaksi Selesai</h3>
                <p class="text-gray-500 text-xs mt-2 leading-relaxed">Status transaksi ini sudah terkunci dan tidak dapat diubah kembali.</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="lg:col-span-2">
            <div class="glass p-8 rounded-[2.5rem] shadow-2xl flex flex-col min-h-[500px]">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-bold flex items-center">
                        <i class="fas fa-shopping-cart mr-3 text-blue-500"></i> Item Terdaftar
                    </h3>
                    <div class="text-right">
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Total Sementara</p>
                        <p class="text-2xl font-black text-blue-500"><?= formatRp($data['total_harga']) ?></p>
                    </div>
                </div>

                <div class="flex-grow overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 uppercase text-[10px] tracking-widest border-b border-white/10">
                                <th class="pb-4 font-bold">Bahan Baku</th>
                                <th class="pb-4 font-bold text-center">Jumlah</th>
                                <th class="pb-4 font-bold text-right">Harga</th>
                                <th class="pb-4 font-bold text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php
                            $detail = mysqli_query($koneksi,"
                                SELECT d.*, b.nama_bhn_baku
                                FROM detail_pembelian_bahan_baku d
                                JOIN bahan_baku b ON d.id_bhn_baku=b.id_bhn_baku
                                WHERE d.id_pembelian='$id'
                            ");
                            while($d = mysqli_fetch_assoc($detail)):
                            ?>
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="py-4 font-bold text-white"><?= $d['nama_bhn_baku'] ?></td>
                                <td class="py-4 text-center font-mono text-blue-400 font-bold"><?= $d['jumlah'] ?></td>
                                <td class="py-4 text-right text-sm text-gray-400"><?= formatRp($d['harga_satuan']) ?></td>
                                <td class="py-4 text-right font-bold text-white"><?= formatRp($d['subtotal']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(!$isSelesai): ?>
                <div class="mt-10 pt-8 border-t-2 border-dashed border-white/10 flex justify-end">
                    <a href="selesai_pemb_bb.php?id=<?= $id ?>" 
                       class="bg-white text-black px-10 py-4 rounded-2xl font-black tracking-widest text-sm transition-all hover:bg-blue-500 hover:text-white shadow-xl flex items-center gap-3"
                       onclick="return confirm('Selesaikan pembelian? Data tidak bisa diubah lagi.')">
                       KONFIRMASI SELESAI <i class="fas fa-check-double text-lg"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

</body>
</html>