<?php
include 'koneksi.php';

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: ID Retur tidak ditentukan.");
}

$id_retur = mysqli_real_escape_string($koneksi, $_GET['id']);

$query_sql = "SELECT d.*, b.nama_bhn_baku 
              FROM detail_retur_bahan_baku d
              LEFT JOIN bahan_baku b ON d.id_bhn_baku = b.id_bhn_baku
              WHERE d.id_retur = '$id_retur'";

$result = mysqli_query($koneksi, $query_sql);

if (!$result) {
    die("Query Error: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Retur: <?= htmlspecialchars($id_retur) ?> - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
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
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-black tracking-tighter uppercase">DETAIL <span class="text-pink-600 text-2xl block tracking-[0.2em] font-bold">RETUR: <?= htmlspecialchars($id_retur) ?></span></h1>
            </div>
            <a href="view_retur.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-arrow-left text-pink-600"></i> Kembali
            </a>
        </div>

        <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold">Bahan Baku</th>
                        <th class="p-6 font-bold">Jumlah</th>
                        <th class="p-6 font-bold">Harga</th>
                        <th class="p-6 font-bold text-pink-600">Subtotal</th>
                        <th class="p-6 font-bold">Alasan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="p-6">
                                <span class="block font-bold text-white"><?= htmlspecialchars($row['nama_bhn_baku'] ?? 'Tidak Diketahui'); ?></span>
                                <span class="text-[9px] text-gray-500 uppercase tracking-widest">Master Item</span>
                            </td>
                            <td class="p-6 text-sm"><?= $row['jumlah_retur']; ?></td>
                            <td class="p-6 text-sm text-gray-400">Rp <?= number_format($row['harga_satuan'], 0, ',', '.'); ?></td>
                            <td class="p-6 text-sm font-bold text-pink-500">Rp <?= number_format($row['subtotal'], 0, ',', '.'); ?></td>
                            <td class="p-6">
                                <div class="bg-white/5 p-3 rounded-xl border border-white/5 text-xs text-gray-300 italic">
                                    "<?= htmlspecialchars($row['alasan']); ?>"
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <i class="fas fa-folder-open text-4xl text-gray-700 mb-4 block"></i>
                                <span class="text-gray-500 tracking-widest uppercase text-xs font-bold">Data tidak ditemukan untuk ID ini.</span>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-8 flex justify-between items-center px-6">
            <div class="flex gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-pink-600"></div>
                    <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Verified System</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                    <span class="text-[10px] text-gray-500 uppercase font-bold tracking-widest">Database Synced</span>
                </div>
            </div>
            <p class="text-[10px] text-gray-600 uppercase tracking-[0.4em] font-bold">&copy; 2025 STATIC. SYSTEM</p>
        </div>
    </div>

</body>
</html>