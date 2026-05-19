<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php';

if (isset($_GET["submit"])){ 
    if (ubahJadwal($_GET) > 0) {
        echo"
        <script>
        alert('Data berhasil diubah!');
        document.location.href='tampil_jadwal.php';
        </script>
        ";
    }else{
        echo"
        <script>
        alert('Data gagal diubah! Pastikan ada perubahan data.');
        document.location.href='tampil_jadwal.php';
        </script>
        ";
    }
} else {

    if (!isset($_GET["id_jadwal"])) {
        echo "
        <script>
        alert('ID Jadwal tidak ditemukan di URL!');
        document.location.href='tampil_jadwal.php';
        </script>
        ";
        exit; 
    }

    $id = $_GET["id_jadwal"];
    $result_jadwal = tampil("SELECT * FROM jadwal_tayang WHERE id_jadwal = '$id'");
    
    if (empty($result_jadwal)) {
        echo "
        <script>
        alert('Data jadwal dengan ID: $id tidak ditemukan!');
        document.location.href='tampil_jadwal.php';
        </script>
        ";
        exit;
    }

    $jadwal = $result_jadwal[0];
    $f = tampil("SELECT * FROM film");
    $s = tampil("SELECT * FROM studio");
    $film_aktif = $jadwal["id_film"];
    $studio_aktif = $jadwal["id_studio"];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal - STATIC.</title>
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
            border-color: #ec4899 !important; /* Pink-500 */
            box-shadow: 0 0 0 2px rgba(236, 72, 153, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">UPDATE <span class="text-pink-500">SHOW</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Schedule Modification</p>
        </div>
        <a href="tampil_jadwal.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-pink-500"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-pink-500/50">
                <i class="fas fa-history text-pink-500 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2">Re-Scheduling</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Anda sedang mengubah slot waktu tayang. Pastikan studio yang dipilih tersedia pada jam tersebut untuk menghindari tabrakan jadwal.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 bg-pink-500/20 rounded-full flex items-center justify-center text-pink-500">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Current ID</p>
                    <p class="text-sm font-mono text-white"><?= htmlspecialchars($jadwal["id_jadwal"]); ?></p>
                </div>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <form action="" method="GET" class="space-y-5">
                    <input type="hidden" name="id_jadwal" value="<?= htmlspecialchars($jadwal["id_jadwal"]); ?>">
                    
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">ID Jadwal (Read Only)</label>
                        <input type="text" value="<?= htmlspecialchars($jadwal["id_jadwal"]); ?>" class="input-glass w-full px-4 py-3 opacity-60 cursor-not-allowed font-mono" disabled>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Judul Film</label>
                        <select name="id_film" class="input-glass w-full px-4 py-3 appearance-none" required>
                            <?php foreach ($f as $data) : ?>
                                <option value="<?= $data["id_film"]; ?>" <?= ($data["id_film"] == $film_aktif) ? 'selected' : ''; ?>>
                                    <?= htmlspecialchars($data["nama_film"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Lokasi Studio</label>
                        <select name="id_studio" class="input-glass w-full px-4 py-3 appearance-none" required>
                            <?php foreach ($s as $data) : ?>
                                <option value="<?= $data["id_studio"]; ?>" <?= ($data["id_studio"] == $studio_aktif) ? 'selected' : ''; ?>>
                                    Studio <?= htmlspecialchars($data["id_studio"]); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Waktu Tayang</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-pink-500 font-bold"><i class="far fa-clock"></i></span>
                            <input type="text" name="waktu_mulai" value="<?= htmlspecialchars($jadwal["waktu_mulai"]); ?>" class="input-glass w-full pl-12 pr-4 py-3 text-lg font-bold" required>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" name="submit" value="Ubah" class="w-full bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-pink-900/30 flex justify-center items-center gap-3 uppercase">
                            Perbarui Jadwal <i class="fas fa-sync-alt"></i>
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