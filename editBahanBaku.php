<?php
include 'koneksi.php';

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
if (isset($_POST["submit"])) {  
    if (ubah($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil diubah!');
        document.location.href='tampilBahanBaku.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal diubah atau tidak ada perubahan!');
        document.location.href='tampilBahanBaku.php';
        </script>
        ";
    }
    exit;
}

$id = $_GET["id"] ?? null;

if (!$id){
    echo "
    <script>
    alert('ID tidak ditemukan di URL!');
    document.location.href='tampilBahanBaku.php';
    </script>
    ";
    exit;
}

$data_array = tampil("SELECT * FROM bahan_baku WHERE id_bhn_baku = '$id'");
if (empty($data_array)) {
    echo "<script>alert('Data tidak ditemukan!'); window.location='tampilBahanBaku.php';</script>";
    exit;
}
$data = $data_array[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Bahan Baku - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1587582423116-ec07293f0395?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
            border-color: #3b82f6 !important; /* Blue-500 */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
        .input-readonly {
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
            color: #6b7280 !important;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">UPDATE <span class="text-blue-500">STOCK</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Inventory Adjustment System</p>
        </div>
        <a href="tampilBahanBaku.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-blue-500"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-blue-500/50">
                <i class="fas fa-edit text-blue-500 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2">Penyesuaian Data</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Sedang mengubah data untuk <span class="text-blue-400 font-bold"><?= htmlspecialchars($data['nama_bhn_baku']) ?></span>. Pastikan perhitungan stok akhir sudah sesuai dengan audit fisik di gudang.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 bg-blue-500/20 rounded-full flex items-center justify-center text-blue-500">
                    <i class="fas fa-tag"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">ID Referensi</p>
                    <p class="text-sm font-mono text-white"><?= htmlspecialchars($data['id_bhn_baku']) ?></p>
                </div>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <form action="" method="POST" class="space-y-5">
                    <input type="hidden" name="id_bhn_baku" value="<?= htmlspecialchars($data['id_bhn_baku']); ?>">

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nama Bahan Baku</label>
                        <input type="text" name="nama_bhn_baku" value="<?= htmlspecialchars($data['nama_bhn_baku']); ?>" class="input-glass w-full px-4 py-3" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nilai Aset (Total)</label>
                            <input type="number" name="total" value="<?= htmlspecialchars($data['total']); ?>" class="input-glass w-full px-4 py-3" required>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Jumlah Stok</label>
                            <input type="number" name="jumlah" value="<?= htmlspecialchars($data['jumlah']); ?>" class="input-glass w-full px-4 py-3" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Keterangan / Satuan</label>
                        <input type="text" name="keterangan" value="<?= htmlspecialchars($data['keterangan']); ?>" class="input-glass w-full px-4 py-3" required>
                    </div>

                    <div class="pt-6">
                        <button type="submit" name="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-blue-900/30 flex justify-center items-center gap-3 uppercase">
                            Simpan Perubahan <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="mt-12 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
        &copy; 2025 STATIC. Cinema Elite Management System
    </footer>
</div>

</body>
</html>