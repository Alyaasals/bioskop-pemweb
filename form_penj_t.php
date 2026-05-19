<?php
require_once 'koneksi.php';
$IdPenjualanTiket = AmbilIPenjualanTiket();
$nominal = GetTotalPenjTiket($IdPenjualanTiket); 
$detail = GetDataDetailPenjTiket($IdPenjualanTiket);
$tanggal_transaksi = $GLOBALS['tanggal_transaksi_saat_ini'] ?? date('Y-m-d');
$jadwal = GetDataJadwalTayang();
$all_sold_seats = GetAllSoldSeats(); 
$sold_seats_json = json_encode($all_sold_seats); 
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Tiket - STATIC.</title>
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
            transition: all 0.3s;
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.1) !important;
            border-color: #db2777 !important;
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">TRANSAKSI <span class="text-pink-600">TIKET</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">STATIC. Cinema Management</p>
        </div>
        <a href="view_penj_t.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-list text-pink-600"></i> Daftar Transaksi
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="glass p-8 rounded-[2.5rem]">
                <form action="tambah_detail_penj_t.php" method="post" class="space-y-4">
                    <input type="hidden" name="id_penjualan_tiket" value="<?= $IdPenjualanTiket ?>">
                    
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">ID Transaksi</label>
                        <input type="text" class="input-glass w-full px-4 py-3 bg-white/5 opacity-70" value="<?= $IdPenjualanTiket ?>" readonly>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Jadwal Tayang</label>
                        <select name="id_jadwal" id="id_jadwal" class="input-glass w-full px-4 py-3" required onchange="loadSoldSeats()">
                            <option value="">Pilih Jadwal</option>
                            <?php foreach ($jadwal as $j): ?>
                                <option value="<?= $j['id_jadwal'] ?>"><?= $j['nama_film'] ?> - <?= $j['nama_studio'] ?> (<?= $j['jam_mulai'] ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div id="soldSeatsContainer" class="hidden p-4 rounded-xl text-xs font-semibold border">
                        <i class="fas fa-info-circle mr-2"></i> <span id="soldSeatsList"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Pilih Kursi</label>
                            <input type="text" name="id_kursi" class="input-glass w-full px-4 py-3" placeholder="Contoh: A1" required>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Harga (Rp)</label>
                            <input type="number" name="harga_tiket" class="input-glass w-full px-4 py-3" placeholder="50000" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-bold text-sm transition-all shadow-lg shadow-pink-900/30 mt-4">
                        TAMBAH KE KERANJANG
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem]">
                <h3 class="text-xl font-bold mb-6 flex items-center">
                    <i class="fas fa-shopping-cart mr-3 text-pink-600"></i> Keranjang Tiket
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="text-gray-500 uppercase text-[10px] tracking-widest border-b border-white/10">
                                <th class="pb-4 font-bold">Film & Studio</th>
                                <th class="pb-4 font-bold">Kursi</th>
                                <th class="pb-4 font-bold text-right">Harga</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($detail as $d): ?>
                                <tr>
                                    <td class="py-4">
                                        <span class="block font-bold"><?= $d['nama_film'] ?></span>
                                        <span class="text-[10px] text-gray-500 italic"><?= $d['id_studio'] ?></span>
                                    </td>
                                    <td class="py-4 text-pink-500 font-mono font-bold"><?= $d['id_kursi'] ?></td>
                                    <td class="py-4 text-right">Rp <?= number_format($d['harga_tiket'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-10 pt-8 border-t-2 border-dashed border-white/10 flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.3em] text-gray-500 font-bold mb-1">Total Bayar</p>
                        <h2 class="text-4xl font-black text-pink-500">Rp <?= number_format($nominal, 0, ',', '.') ?></h2>
                    </div>
                    <form action="selesai_penj_t.php" method="post">
                        <input type="hidden" name="id_penjualan_tiket" value="<?= $IdPenjualanTiket ?>">
                        <input type="hidden" name="total_harga" value="<?= $nominal ?>">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-black tracking-widest text-sm transition-all shadow-xl shadow-blue-900/30 flex items-center gap-3">
                            SELESAI TRANSAKSI <i class="fas fa-check-circle"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const allSoldSeats = <?= $sold_seats_json ?>;

    function loadSoldSeats() {
        const jadwalSelect = document.getElementById('id_jadwal');
        const selectedJadwal = jadwalSelect.value;
        const soldSeatsContainer = document.getElementById('soldSeatsContainer');
        const soldSeatsList = document.getElementById('soldSeatsList');

        if (!selectedJadwal) {
            soldSeatsContainer.classList.add('hidden');
            return;
        }

        const seatsForThisJadwal = allSoldSeats.filter(seat => seat.id_jadwal == selectedJadwal);
        const seatNames = seatsForThisJadwal.map(seat => seat.id_kursi);

        soldSeatsContainer.classList.remove('hidden', 'bg-red-500/10', 'border-red-500/30', 'text-red-400', 'bg-green-500/10', 'border-green-500/30', 'text-green-400');

        if (seatNames.length > 0) {
            soldSeatsList.innerHTML = "Kursi Terisi: " + seatNames.join(', ');
            soldSeatsContainer.classList.add('bg-red-500/10', 'border-red-500/30', 'text-red-400');
        } else {
            soldSeatsList.innerHTML = "Semua kursi tersedia!";
            soldSeatsContainer.classList.add('bg-green-500/10', 'border-green-500/30', 'text-green-400');
        }
    }
</script>

</body>
</html>