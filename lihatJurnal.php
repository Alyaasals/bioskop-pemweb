<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
require 'koneksi.php';

$tglAwal = $_POST['tglAwal'] ?? date('Y-m-01');
$tglAkhir = $_POST['tglAkhir'] ?? date('Y-m-d');
$filterTransaksi = $_POST['filterTransaksi'] ?? 'Semua';
$data_jurnal = GetDataJurnal($tglAwal, $tglAkhir, $filterTransaksi); 

$totalDebit = 0;
$totalKredit = 0;
$current_page = 'jurnal';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jurnal Umum - STATIC.</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0b0712;
            --navy-card: #262c4988;
            --accent-pink: #e91e63;
            --accent-blue: #224f5ed3;
            --text-light: #ffffff;
            --border-color: #2e2c3a;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.85)), 
                        url('https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
            color: white;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }
        .menu-toggle {
            background: rgba(233, 30, 99, 0.2);
            border: 1px solid var(--accent-pink);
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        /* --- Container Size (Disamakan dengan Tampil Jadwal) --- */
        .container {
            max-width: 1180px; /* Standar Bootstrap Container */
        }

        .filter-container {
            background: var(--navy-card);
            padding: 20px;
            border-radius: 15px;
            border: 1px solid var(--border-color);
            margin-top: 30px;
        }

        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Tabel Proposional */
        .table { color: var(--text-light); font-size: 0.9rem; }
        .table thead th { 
            border-bottom: 2px solid var(--accent-pink); 
            border-top: none;
            color: var(--accent-blue);
            text-transform: uppercase;
        }
        .table td { border-top: 1px solid var(--border-color); vertical-align: middle; padding: 12px 8px; }
        
        .tfoot-custom {
            background: rgba(0, 210, 255, 0.05);
            font-weight: bold;
            color: var(--accent-blue);
        }

        .form-control {
            background-color: #0f1224ff;
            border: 1px solid var(--border-color);
            color: white !important;
            font-size: 0.85rem;
        }

        .btn-pink { background: var(--accent-pink); color: white; font-weight: bold; }
        .btn-pink:hover { background: #c2185b; color: white; }

    </style>
</head>
<body>

<div class="container pb-5">
    <div class="row mt-5">
        <div class="col-12 text-center">
            <h2 class="font-weight-bold">LAPORAN JURNAL UMUM</h2>
            <div style="width: 80px; height: 4px; background: var(--accent-pink); margin: 10px auto;"></div>
        </div>
    </div>

    <div class="filter-container">
        <form method="POST" action="">
            <div class="form-row align-items-end">
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">AWAL</label>
                    <input type="date" name="tglAwal" class="form-control" value="<?= $tglAwal ?>">
                </div>
                <div class="col-md-3 mb-2">
                    <label class="small font-weight-bold">AKHIR</label>
                    <input type="date" name="tglAkhir" class="form-control" value="<?= $tglAkhir ?>">
                </div>
                <div class="col-md-4 mb-2">
                    <label class="small font-weight-bold">TRANSAKSI</label>
                    <select name="filterTransaksi" class="form-control">
                        <option value="Semua" <?= ($filterTransaksi == 'Semua') ? 'selected' : '' ?>>Semua Transaksi</option>
                        <option value="Penjualan Tiket" <?= ($filterTransaksi == 'Penjualan Tiket') ? 'selected' : '' ?>>Penjualan Tiket</option>
                        <option value="Penjualan Makan & Minum" <?= ($filterTransaksi == 'Penjualan Makan & Minum') ? 'selected' : '' ?>>Penjualan Makanan</option>
                        <option value="Sewa Royalti" <?= ($filterTransaksi == 'Sewa Royalti') ? 'selected' : '' ?>>Sewa Royalti</option>
                        <option value="Pembelian Bahan Baku" <?= ($filterTransaksi == 'Pembelian Bahan Baku') ? 'selected' : '' ?>>Pembelian Bahan Baku</option>
                        <option value="Penggunaan Bahan Baku" <?= ($filterTransaksi == 'Penggunaan Bahan Baku') ? 'selected' : '' ?>>Penggunaan Bahan Baku</option>
                        <option value="Retur Bahan Baku" <?= ($filterTransaksi == 'Retur Bahan Baku') ? 'selected' : '' ?>>Retur Bahan Baku</option>
                    </select>
                </div>
                <div class="col-md-2 mb-2">
                    <button type="submit" class="btn btn-pink btn-block">
                        <i class="fas fa-sync-alt"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="table-container shadow-lg">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="45%">Keterangan</th>
                        <th width="10%">Ref</th>
                        <th width="15%" class="text-right">Debit</th>
                        <th width="15%" class="text-right">Kredit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data_jurnal)): ?>
                        <?php foreach ($data_jurnal as $j): 
                            $totalDebit += $j['debit'];
                            $totalKredit += $j['kredit'];
                        ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($j['tanggal'])) ?></td>
                            <td>
                                <div class="<?= ($j['debit'] == 0) ? 'pl-4' : 'font-weight-bold text-white' ?>">
                                    <?= htmlspecialchars($j['nm_akun']) ?>
                                </div>
                                <small class="text-muted"><?= htmlspecialchars($j['jenis_transaksi']) ?></small>
                            </td>
                            <td><?= $j['no_akun'] ?></td>
                            <td class="text-right"><?= number_format($j['debit'], 0, ',', '.') ?></td>
                            <td class="text-right"><?= number_format($j['kredit'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center py-4 text-muted">Data tidak ditemukan.</td></tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="tfoot-custom">
                    <tr>
                        <td colspan="3" class="text-center">TOTAL</td>
                        <td class="text-right"><?= number_format($totalDebit, 0, ',', '.') ?></td>
                        <td class="text-right"><?= number_format($totalKredit, 0, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    function openNav() { document.getElementById("myNav").style.width = "100%"; }
    function closeNav() { document.getElementById("myNav").style.width = "0%"; }
</script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>