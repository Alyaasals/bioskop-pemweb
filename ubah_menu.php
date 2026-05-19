
<?php
require 'koneksi.php';

// --- KOREKSI LOGIKA PHP ---

// 1. Ganti $_GET menjadi $_POST untuk penanganan form submit
if (isset($_POST["submit"])){ 
    // Ganti $_GET menjadi $_POST saat memanggil ubahMenu
    if (ubahMenu($_POST) > 0) {
        echo"
        <script>
        alert('Data berhasil diubah!');
        document.location.href='viewDaftarMenu.php';
        </script>
        ";
    }else{
        echo"
        <script>
        alert('Data gagal diubah! Pastikan ada perubahan data.');
        document.location.href='viewDaftarMenu.php';
        </script>
        ";
    }
}else {
    // Ini adalah bagian untuk menampilkan form, jadi kita masih perlu ID dari URL (GET)

    // 2. Periksa apakah ID Menu ada di URL (Pastikan URL menggunakan ?id_menu=XXX)
    if (!isset($_GET["id_menu"])) {
        echo "
        <script>
        alert('ID Menu tidak ditemukan di URL! Pastikan URL memiliki parameter id_menu.');
        document.location.href='viewDaftarMenu.php';
        </script>
        ";
        exit; 
    }

    $id = $_GET["id_menu"];
    $result_menu = tampil_menu("SELECT * FROM menu WHERE id_menu = '$id'");
    
    if (empty($result_menu)) {
        echo "
        <script>
        alert('Data Menu dengan ID: $id tidak ditemukan!');
        document.location.href='viewDaftarmenu.php';
        </script>
        ";
        exit;
    }
    
    // Ambil data menu pertama (asumsi ID unik)
    $menu = $result_menu[0]; 
    $message = '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Menu F&B - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1551024601-bec78aea704b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1351&q=80');
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
            border-color: #f59e0b !important; /* Amber-500 */
            box-shadow: 0 0 0 2px rgba(245, 158, 11, 0.2);
            outline: none;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">UPDATE <span class="text-amber-500">MENU</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">F&B Management System</p>
        </div>
        <a href="viewDaftarMenu.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-amber-500"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-amber-500/50">
                <i class="fas fa-utensils text-amber-500 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2 text-white">Edit Item</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Sedang mengubah data untuk <span class="text-amber-400 font-bold"><?= htmlspecialchars($menu['nama']) ?></span>. Pastikan perubahan harga sudah disetujui oleh manajer F&B.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-500/20 rounded-full flex items-center justify-center text-amber-500">
                    <i class="fas fa-barcode"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Product ID</p>
                    <p class="text-sm font-mono text-white"><?= htmlspecialchars($menu['id_menu']) ?></p>
                </div>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <?php if ($message): ?>
                    <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 text-sm rounded-xl">
                        <?= $message; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="POST" class="space-y-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">ID Menu (Permanen)</label>
                        <input type="hidden" name="id_menu" value="<?= htmlspecialchars($menu['id_menu']) ?>">
                        <input type="text" value="<?= htmlspecialchars($menu['id_menu']) ?>" class="input-glass w-full px-4 py-3 opacity-60 cursor-not-allowed font-mono" readonly>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nama Menu</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" placeholder="e.g. Popcorn Caramel Large" class="input-glass w-full px-4 py-3" required>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Kategori / Jenis</label>
                        <select name="jenis" class="input-glass w-full px-4 py-3 appearance-none" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Makanan" <?= ($menu['jenis'] == 'Makanan') ? 'selected' : '' ?>>Makanan</option>
                            <option value="Minuman" <?= ($menu['jenis'] == 'Minuman') ? 'selected' : '' ?>>Minuman</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Harga Satuan Baru</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-amber-500 font-bold">Rp</span>
                            <input type="number" name="harga" value="<?= htmlspecialchars($menu['harga']) ?>" placeholder="0" class="input-glass w-full pl-12 pr-4 py-3 text-lg font-bold" required min="0">
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" name="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-amber-900/30 flex justify-center items-center gap-3 uppercase">
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