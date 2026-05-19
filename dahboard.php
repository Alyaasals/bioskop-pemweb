<?php
require 'koneksi.php'; 

if (!function_exists('tampil')) {
    function tampil($query){
        global $koneksi;
        $result = mysqli_query($koneksi, $query);
        $rows = [];
        if (!$result) { return []; } 
        while($row = mysqli_fetch_assoc($result)){
            $rows[] = $row;
        }
        return $rows;
    }
}

$total_film = tampil("SELECT COUNT(*) as total FROM film")[0]['total'] ?? 0;
$total_bahan_baku = tampil("SELECT COUNT(*) as total FROM bahan_baku")[0]['total'] ?? 0;
$total_menu_fb = tampil("SELECT COUNT(*) as total FROM menu")[0]['total'] ?? 0;
$total_akun = tampil("SELECT COUNT(*) as total FROM akun")[0]['total'] ?? 0;
$total_jadwal = tampil("SELECT COUNT(*) as total FROM jadwal_tayang")[0]['total'] ?? 0;
$total_kursi = tampil("SELECT COUNT(*) as total FROM kursi")[0]['total'] ?? 0;
$total_studio = tampil("SELECT COUNT(*) as total FROM studio")[0]['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIG(NE)MA Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.76), rgba(0, 0, 0, 0.73)), 
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
            transition: all 0.3s ease;
        }
        .glass:hover {
            background: rgba(255, 255, 255, 0.07);
            transform: translateY(-3px);
        } 
        .nav-item-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            font-size: 0.9rem;
            color: #e0e0e0;
            text-decoration: none;
            transition: 0.2s;
            margin-bottom: 0 !important; /* Menghapus margin bawaan agar diatur oleh gap */
        }
        .nav-item-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }
        .container-ideal {
            max-width: 1200px;
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="container-ideal mx-auto flex flex-col items-center">
    
    <div class="text-center mb-10 pt-4">
        <h1 class="text-6xl font-black tracking-tighter mb-1">STA<span class="text-pink-600">TIC</span>.</h1>
        <p class="text-gray-500 text-xs tracking-[0.6em] uppercase font-semibold">Cinema Management System</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6 w-full max-w-5xl justify-center">
        <a href="tampilFilm.php" class="card-link">
            <div class="glass p-6 rounded-[2rem] text-center border-2 border-pink-600/30 relative overflow-hidden">
                <i class="fas fa-film text-lg text-pink-600 mb-3"></i>
                <h2 class="text-3xl font-black block leading-none"><?= $total_film ?></h2>
                <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold mt-2">Total Film</p>
            </div>
        </a>
        <a href="tampilBahanBaku.php" class="card-link">
            <div class="glass p-6 rounded-[2rem] text-center border-2 border-blue-500/30">
                <i class="fas fa-boxes-stacked text-lg text-blue-500 mb-3"></i>
                <h2 class="text-3xl font-black block leading-none"><?= $total_bahan_baku ?></h2>
                <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold mt-2">Bahan Baku</p>
            </div>
        </a>
        <a href="viewDaftarMenu.php" class="card-link">
            <div class="glass p-6 rounded-[2rem] text-center border-2 border-yellow-500/30">
                <i class="fas fa-utensils text-lg text-yellow-500 mb-3"></i>
                <h2 class="text-3xl font-black block leading-none"><?= $total_menu_fb ?></h2>
                <p class="text-[9px] text-gray-500 uppercase tracking-widest font-bold mt-2">Menu F&B</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-12 w-full max-w-6xl justify-center">
        <a href="tampil_jadwal.php" class="card-link">
            <div class="glass p-5 rounded-[1.8rem] text-center border-2 border-pink-600/30">
                <i class="fas fa-calendar-alt text-base text-pink-600 mb-2"></i>
                <h2 class="text-2xl font-black block leading-none"><?= $total_jadwal ?></h2>
                <p class="text-[8px] text-gray-500 uppercase tracking-widest font-bold mt-1">Jadwal Tayang</p>
            </div>
        </a>
        <a href="tampil_studio.php" class="card-link">
            <div class="glass p-5 rounded-[1.8rem] text-center border-2 border-blue-500/30">
                <i class="fas fa-door-open text-base text-blue-500 mb-2"></i>
                <h2 class="text-2xl font-black block leading-none"><?= $total_studio ?></h2>
                <p class="text-[8px] text-gray-500 uppercase tracking-widest font-bold mt-1">Studio</p>
            </div>
        </a>
        <a href="tampil_kursi.php" class="card-link">
            <div class="glass p-5 rounded-[1.8rem] text-center border-2 border-yellow-500/30">
                <i class="fas fa-chair text-base text-yellow-500 mb-2"></i>
                <h2 class="text-2xl font-black block leading-none"><?= $total_kursi ?></h2>
                <p class="text-[8px] text-gray-500 uppercase tracking-widest font-bold mt-1">Kursi</p>
            </div>
        </a>
        <a href="tampilakun.php" class="card-link">
            <div class="glass p-5 rounded-[1.8rem] text-center border-2 border-purple-500/30">
                <i class="fas fa-user-shield text-base text-purple-500 mb-2"></i>
                <h2 class="text-2xl font-black block leading-none"><?= $total_akun ?></h2>
                <p class="text-[8px] text-gray-500 uppercase tracking-widest font-bold mt-1">Akun</p>
            </div>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 w-full max-w-5xl">
        <div class="glass p-8 rounded-[2.5rem]">
            <h3 class="text-lg font-bold mb-6 flex items-center text-blue-400">
                <i class="fas fa-chart-line mr-3"></i> View Transaksi
            </h3>
            <div class="flex flex-col gap-3">
                <a href="view_penj_t.php" class="nav-item-link"><span>Penjualan Tiket</span> <i class="fas fa-ticket-alt opacity-30 text-xs"></i></a>
                <a href="view_transaksiSewaRoyalti.php" class="nav-item-link"><span>Sewa Royalti</span> <i class="fas fa-file-contract opacity-30 text-xs"></i></a>
                <a href="viewMakan.php" class="nav-item-link"><span>Penjualan F&B</span> <i class="fas fa-coffee opacity-30 text-xs"></i></a>
                <a href="view_pengg.php" class="nav-item-link"><span>Penggunaan Bahan Baku</span> <i class="fas fa-utensils opacity-30 text-xs"></i></a>
                <a href="view_pemb_bb.php" class="nav-item-link"><span>Pembelian Bahan Baku</span> <i class="fas fa-shopping-cart opacity-30 text-xs"></i></a>
                <a href="view_retur.php" class="nav-item-link"><span>Retur Bahan Baku</span> <i class="fas fa-undo opacity-30 text-xs"></i></a>
            </div>
        </div>

        <div class="glass p-8 rounded-[2.5rem]">
            <h3 class="text-lg font-bold mb-6 flex items-center text-yellow-500">
                <i class="fas fa-file-invoice mr-3"></i> Laporan
            </h3>
            <div class="flex flex-col gap-3">
                <a href="laporan_penj_t.php" class="nav-item-link"><span>Laporan Penjualan Tiket</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="laporan_sewaRoyalti.php" class="nav-item-link"><span>Laporan Sewa Royalti</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="laporan_penj_m.php" class="nav-item-link"><span>Laporan Penjualan F&B</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="laporan_peng_bb.php" class="nav-item-link"><span>Laporan Penggunaan Bahan Baku</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="laporan_pemb_bb.php" class="nav-item-link"><span>Laporan Pembelian Bahan Baku</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="laporanRetur.php" class="nav-item-link"><span>Laporan Retur Bahan Baku</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
                <a href="lihatJurnal.php" class="nav-item-link"><span>Jurnal Umum</span> <i class="fas fa-print opacity-30 text-xs"></i></a>
            </div>
        </div>
    </div>
</div>

        <footer class="mt-20 text-center text-gray-600 text-[10px] tracking-[0.4em] uppercase">
            &copy; 2025 STATIC Cinema Management System
        </footer>
    </div>

</body>
</html>