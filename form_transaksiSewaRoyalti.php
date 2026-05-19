<?php
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include "koneksi.php";

$queryFilmComingSoon = mysqli_query($koneksi, "
    SELECT * FROM film 
    WHERE status_tayang = 'Coming Soon'
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sewa Royalti Baru - STATIC.</title>
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
        .input-glass {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 12px !important;
        }
        .input-glass:focus {
            border-color: #6366f1 !important; /* Indigo-500 */
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">KONTRAK <span class="text-indigo-500">ROYALTI</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Film Licensing Agreement</p>
        </div>
        <a href="view_transaksiSewaRoyalti.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-indigo-500"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-indigo-500/50">
                <i class="fas fa-shield-halved text-indigo-500 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2">Lisensi Film</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Pastikan film yang dipilih telah memiliki status <strong>Coming Soon</strong> di sistem master data film sebelum membuat kontrak royalti.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 bg-indigo-500/20 rounded-full flex items-center justify-center text-indigo-500">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Tipe Kontrak</p>
                    <p class="text-sm font-bold italic text-indigo-400">Fixed Cost / Royalty</p>
                </div>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <form action="tambah_sewaRoyalti_proses.php" method="post" class="space-y-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Pilih Film</label>
                        <select name="id_film" class="input-glass w-full px-4 py-3" required>
                            <option value="">-- Pilih Film (Coming Soon) --</option>
                            <?php while ($dataFilm = mysqli_fetch_assoc($queryFilmComingSoon)) { ?>
                                <option value="<?= $dataFilm['id_film']; ?>">
                                    <?= htmlspecialchars($dataFilm['nama_film']); ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Tanggal Mulai Sewa</label>
                            <input type="date" name="tanggal_sewa" class="input-glass w-full px-4 py-3" required>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Tutup Tayang</label>
                            <input type="date" name="tanggal_tutup_tayang" class="input-glass w-full px-4 py-3" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Biaya Royalti / Harga Sewa</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="harga_royalti" class="input-glass w-full pl-12 pr-4 py-3 text-lg font-bold text-indigo-400" placeholder="0" required>
                        </div>
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-black tracking-widest text-sm transition-all shadow-lg shadow-indigo-900/30 flex justify-center items-center gap-3">
                            SIMPAN KONTRAK <i class="fas fa-check-circle text-lg"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <p class="mt-12 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
        &copy; 2025 STATIC. Cinema Elite Management System
    </p>
</div>

</body>
</html>