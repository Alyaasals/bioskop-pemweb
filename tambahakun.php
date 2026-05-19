<?php 
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php'; 

if (isset($_POST['submit'])) { 
    $no = $_POST['no_akun'];
    $nama = $_POST['nm_akun'];
    $header = $_POST['header_akun'];

    $query = "INSERT INTO akun VALUES ('$no', '$nama', '$header')";
    mysqli_query($koneksi, $query);

    header("Location: tampilakun.php"); 
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        /* SELARAS DENGAN MODUL LAIN */
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
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
        <a href="tampilakun.php" class="text-pink-500 hover:text-pink-400 text-sm font-bold flex items-center gap-2 transition">
            <i class="fas fa-arrow-left"></i> KEMBALI KE DAFTAR
        </a>
    </div>

    <div class="glass p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden border border-white/5">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-pink-600/10 rounded-full blur-3xl"></div>

        <div class="text-center mb-10">
            <div class="w-16 h-16 bg-pink-600/20 rounded-2xl flex items-center justify-center text-pink-500 mx-auto mb-4">
                <i class="fas fa-file-invoice-dollar text-2xl"></i>
            </div>
            <h1 class="text-3xl font-black tracking-tighter uppercase italic leading-none">CREATE <span class="text-pink-500">ACCOUNT</span></h1>
            <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Financial Master Data</p>
        </div>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nomor Akun</label>
                <input type="number" name="no_akun" placeholder="Contoh: 1101" class="input-glass w-full px-4 py-3 font-mono" required>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Nama Akun</label>
                <input type="text" name="nm_akun" placeholder="Contoh: KAS BESAR" class="input-glass w-full px-4 py-3 font-bold uppercase" required>
            </div>

            <div>
                <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2 ml-1">Header Akun (Opsional)</label>
                <input type="number" name="header_akun" placeholder="Contoh: 1" class="input-glass w-full px-4 py-3 font-mono">
            </div>

            <div class="pt-4">
                <button type="submit" name="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-black tracking-[0.2em] text-sm transition-all shadow-lg shadow-pink-900/40 flex justify-center items-center gap-3 uppercase">
                    SIMPAN AKUN <i class="fas fa-check-double"></i>
                </button>
            </div>
        </form>

        <p class="text-center text-[9px] text-gray-600 uppercase tracking-widest mt-8 font-semibold">
            &copy; 2025 STATIC. Finance Elite Management
        </p>
    </div>
</div>

</body>
</html>