<?php
include 'koneksi.php';

// --- LOGIKA ASLI (TIDAK DIUBAH) ---
$studio    = mysqli_query($koneksi, "SELECT * FROM studio");
$kapasitas = mysqli_query($koneksi, "SELECT * FROM studio");

if(isset($_POST['submit'])){
    $hasil = tambah_studio($_POST);

    if($hasil >= 0){   
        echo "
        <script>
            alert('Proses berhasil!');
            document.location='tampil_studio.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Proses gagal!');
            document.location='tambah_studio.php';
        </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Studio - STATIC.</title>
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
            border-color: #6366f1 !important; /* Indigo-500 */
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
            outline: none;
        }
    </style>
</head>
<body class="p-6">

<div class="w-full max-w-lg">
    <div class="mb-6 flex justify-start">
        <a href="tampil_studio.php" class="text-indigo-400 hover:text-indigo-300 text-sm font-bold flex items-center gap-2 transition">
            <i class="fas fa-chevron-left"></i> KEMBALI KE DAFTAR
        </a>
    </div>

    <div class="glass p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-600/10 rounded-full blur-3xl"></div>

        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-indigo-600/20 rounded-2xl flex items-center justify-center text-indigo-500 mx-auto mb-4">
                <i class="fas fa-door-open text-2xl"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tighter uppercase italic">NEW <span class="text-indigo-500">THEATRE</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-1">Room Registration System</p>
        </div>

        <form method="POST" class="space-y-6">
            <div>
                <label for="id_studio" class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">ID Studio</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-indigo-500 font-bold">#</span>
                    <input type="text" name="id_studio" id="id_studio" placeholder="Contoh: S1" class="input-glass w-full pl-10 pr-4 py-3 font-mono" required>
                </div>
            </div>

            <div>
                <label for="kapasitas" class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Kapasitas Kursi</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-indigo-500"><i class="fas fa-couch"></i></span>
                    <input type="number" name="kapasitas" id="kapasitas" placeholder="Jumlah maksimal penonton" class="input-glass w-full pl-12 pr-4 py-3 font-bold" required>
                </div>
            </div>

            <div class="pt-4">
                <button type="submit" name="submit" value="Tambah" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-indigo-900/40 flex justify-center items-center gap-3 uppercase">
                    DAFTARKAN STUDIO <i class="fas fa-plus-circle"></i>
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