<?php
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include "koneksi.php"; 

if (isset($_POST['simpan'])) {
    $cekId = mysqli_query($koneksi, "SELECT id_film FROM film ORDER BY id_film DESC LIMIT 1");
    if (!$cekId) {
        die("Query GAGAL pada pembuatan ID (Baris 8). Error: " . mysqli_error($koneksi));
    }
    $idTerakhir = mysqli_fetch_array($cekId);
    if ($idTerakhir) {
        $angkaAkhir = intval(substr($idTerakhir['id_film'], 1));
        $angkaBaru = $angkaAkhir + 1;
        $id_film = "F" . sprintf("%03d", $angkaBaru);
    } else {
        $id_film = "F001";
    }
    
    $nama_film     = mysqli_real_escape_string($koneksi, $_POST['nama_film']);
    $genre         = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $durasi        = mysqli_real_escape_string($koneksi, $_POST['durasi']);
    $status_tayang = mysqli_real_escape_string($koneksi, $_POST['status_tayang']);
    $harga         = mysqli_real_escape_string($koneksi, $_POST['harga']);

    $query = "
        INSERT INTO Film 
        (id_film, nama_film, genre, durasi, status_tayang, harga)
        VALUES
        ('$id_film', '$nama_film', '$genre', '$durasi', '$status_tayang', '$harga')
    ";

    if (mysqli_query($koneksi, $query)) {
        header("location:tampilFilm.php?status=sukses");
        exit;
    } else {
        echo "<script>alert('Gagal menambahkan film!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Film Baru - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1485846234645-a62644f84728?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
            border-color: #e91e63 !important; /* Pink-500 */
            box-shadow: 0 0 0 2px rgba(233, 30, 99, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">NEW <span class="text-pink-600">CINEMA</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Movie Registration System</p>
        </div>
        <a href="tampilFilm.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-pink-600"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-pink-600/50">
                <i class="fas fa-film text-pink-600 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2 text-white">Registrasi Master</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Data film yang Anda masukkan akan menjadi basis untuk pembuatan **Jadwal Tayang** dan **Penjualan Tiket**. Pastikan durasi dalam satuan menit.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl flex items-center gap-4">
                <div class="w-10 h-10 bg-pink-600/20 rounded-full flex items-center justify-center text-pink-600">
                    <i class="fas fa-plus-circle"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Input Mode</p>
                    <p class="text-sm font-bold italic text-pink-400">Manual Entry</p>
                </div>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <form action="" method="post" class="space-y-5">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Judul Film</label>
                        <input type="text" name="nama_film" placeholder="Masukkan judul..." class="input-glass w-full px-4 py-3" required>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Genre</label>
                            <input type="text" name="genre" placeholder="e.g. Action" class="input-glass w-full px-4 py-3" required>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Durasi (Menit)</label>
                            <input type="number" name="durasi" placeholder="120" class="input-glass w-full px-4 py-3" required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Status Tayang</label>
                        <select name="status_tayang" class="input-glass w-full px-4 py-3" required>
                            <option value="Coming Soon">Coming Soon (Segera)</option>
                            <option value="Ongoing">Ongoing (Sedang Tayang)</option>
                            <option value="Finished">Finished (Selesai)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Harga Tiket Default</label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-pink-600 font-bold">Rp</span>
                            <input type="number" name="harga" placeholder="0" class="input-glass w-full pl-12 pr-4 py-3 text-lg font-bold" required>
                        </div>
                    </div>

                    <div class="pt-6">
                        <button type="submit" name="simpan" class="w-full bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-pink-900/30 flex justify-center items-center gap-3 uppercase">
                            Simpan Film <i class="fas fa-save"></i>
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