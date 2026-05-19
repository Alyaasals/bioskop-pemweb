<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

if (isset($_POST["submit"])) {  
    if (ubah_kursi($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil diubah!');
        document.location.href='tampil_kursi.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal diubah!');
        document.location.href='tampil_kursi.php';
        </script>
        ";
    }
    exit;
}

$id = $_GET["id"] ?? null;

if (!$id){
    echo "
    <script>
    alert('ID tidak ditemukan!');
    document.location.href='tampil_kursi.php';
    </script>
    ";
    exit;
}

$data = tampil("SELECT * FROM kursi WHERE id_kursi = '$id'")[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kursi - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* SELARAS DENGAN MODUL FILM, JADWAL, & TAMPIL KURSI */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.78)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
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
    </style>
</head>
<body class="p-6">

<div class="w-full max-w-lg">
    <div class="mb-6">
        <a href="tampil_kursi.php" class="text-pink-500 hover:text-pink-400 text-sm font-bold flex items-center gap-2 transition">
            <i class="fas fa-chevron-left"></i> BATALKAN PERUBAHAN
        </a>
    </div>

    <div class="glass p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden border border-white/5">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-pink-600/10 rounded-full blur-3xl"></div>

        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-pink-600/20 rounded-2xl flex items-center justify-center text-pink-500 mx-auto mb-4">
                <i class="fas fa-edit text-2xl"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tighter uppercase italic leading-none">EDIT <span class="text-pink-500">SEAT</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Update Asset Information</p>
        </div>

        <form method="POST" class="space-y-6">
            <input type="hidden" name="id_lama" value="<?= htmlspecialchars($data['id_kursi']); ?>">

            <div>
                <label for="id_kursi" class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">ID Kursi</label>
                <input type="text" name="id_kursi" id="id_kursi" value="<?= htmlspecialchars($data['id_kursi']); ?>" class="input-glass w-full px-4 py-3 font-mono" required>
            </div>

            <div>
                <label for="id_studio" class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">ID Studio</label>
                <input type="text" name="id_studio" id="id_studio" value="<?= htmlspecialchars($data['id_studio']); ?>" class="input-glass w-full px-4 py-3 font-bold" required>
            </div>

            <div>
                <label for="no_kursi" class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nomor Kursi</label>
                <input type="text" name="no_kursi" id="no_kursi" value="<?= htmlspecialchars($data['no_kursi']); ?>" class="input-glass w-full px-4 py-3 font-bold uppercase" required>
            </div>

            <div class="pt-4">
                <button type="submit" name="submit" value="EDIT" class="w-full bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-pink-900/40 flex justify-center items-center gap-3 uppercase">
                    SIMPAN PERUBAHAN <i class="fas fa-save"></i>
                </button>
            </div>
        </form>

        <p class="text-center text-[9px] text-gray-600 uppercase tracking-widest mt-8 font-semibold">
            &copy; 2025 STATIC. Cinema Elite Management
        </p>
    </div>
</div>

</body>
</html>