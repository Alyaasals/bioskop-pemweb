<?php 
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php'; 
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Penggunaan - STATIC.</title>
    
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
        input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
        }
        input:focus {
            border-color: #db2777 !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
        }
    </style>
</head>
<body class="py-10 px-6 flex items-center justify-center">

<div class="w-full max-w-2xl">
    <div class="text-center mb-10">
        <h1 class="text-4xl font-black tracking-tighter uppercase italic text-white leading-none">RECORD <span class="text-pink-600">USAGE</span></h1>
        <p class="text-gray-500 text-[10px] tracking-[0.4em] uppercase font-bold mt-2">Material Consumption Entry</p>
    </div>

    <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl border border-white/5">
        <form action="tambah_proses.php" method="POST" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2 ml-1">ID Penggunaan</label>
                    <input type="text" name="id_penggunaan" placeholder="Contoh: PG001" 
                           class="w-full rounded-xl px-4 py-3 text-sm transition-all italic" required>
                </div>
                
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2 ml-1">ID Jurnal</label>
                    <input type="text" name="id_jurnal" placeholder="Contoh: J001"
                           class="w-full rounded-xl px-4 py-3 text-sm transition-all italic" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2 ml-1">Tanggal</label>
                    <input type="date" name="tanggal" 
                           class="w-full rounded-xl px-4 py-3 text-sm transition-all" required>
                </div>

                <div>
                    <label class="block text-[10px] uppercase tracking-widest text-gray-400 font-bold mb-2 ml-1">Total Biaya (Rp)</label>
                    <input type="number" name="total" placeholder="0"
                           class="w-full rounded-xl px-4 py-3 text-sm transition-all font-mono" required>
                </div>
            </div>

            <div class="flex flex-col md:flex-row gap-4 pt-6">
                <button type="submit" name="simpan" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white font-black py-4 rounded-2xl text-xs uppercase tracking-[0.2em] transition-all shadow-xl shadow-pink-600/20 flex items-center justify-center gap-2">
                    Simpan Transaksi <i class="fas fa-save"></i>
                </button>
                <a href="view_pengg.php" 
                   class="glass px-8 py-4 rounded-2xl text-xs font-bold uppercase tracking-[0.2em] text-gray-400 hover:text-white hover:bg-white/5 transition flex items-center justify-center gap-2">
                    Kembali
                </a>
            </div>
        </form>
    </div>

    <footer class="mt-12 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            STATIC. Supply Chain Integrity &copy; 2025
        </p>
    </footer>
</div>

</body>
</html>