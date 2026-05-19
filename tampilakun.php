<?php 
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php'; 

$current_page = 'akun'; 

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

$data_akun = tampil("SELECT * FROM akun ORDER BY no_akun ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Akun - STATIC.</title>
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
        .account-row:hover {
            background: rgba(233, 30, 99, 0.05); /* Pink tint */
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none italic">
                CHART OF <span class="text-pink-600">ACCOUNTS</span>
            </h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Financial Accounting Structure</p>
        </div>
        <div class="flex gap-4">
            <a href="dashboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-th-large text-pink-600"></i>
            </a>
            <a href="tambahakun.php" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-pink-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-plus"></i> Tambah Akun
            </a>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold w-20 text-center">No</th>
                        <th class="p-6 font-bold">Nomor Akun</th>
                        <th class="p-6 font-bold">Nama Akun</th>
                        <th class="p-6 font-bold text-center">Header</th>
                        <th class="p-6 font-bold text-center w-48">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (count($data_akun) > 0): ?>
                        <?php $i = 1; foreach ($data_akun as $row): ?>
                        <tr class="account-row">
                            <td class="p-6 text-center text-gray-600 font-mono text-sm"><?= $i++; ?></td>
                            <td class="p-6">
                                <span class="text-pink-500 font-mono font-bold italic">
                                    #<?= htmlspecialchars($row["no_akun"]); ?>
                                </span>
                            </td>
                            <td class="p-6 font-bold text-gray-200 uppercase tracking-tight italic">
                                <?= htmlspecialchars($row["nm_akun"]); ?>
                            </td>
                            <td class="p-6 text-center">
                                <span class="px-3 py-1 rounded-lg bg-white/5 text-gray-400 font-bold border border-white/10 text-[10px] uppercase">
                                    <?= htmlspecialchars($row["header_akun"]); ?>
                                </span>
                            </td>
                            <td class="p-6 text-center">
                                <div class="flex justify-center gap-3">
                                    <a href="updateakun.php?id=<?= $row['no_akun']; ?>" 
                                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/5 hover:bg-pink-600 hover:text-white text-gray-400 transition-all shadow-sm">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <a href="hapusakun.php?id=<?= $row['no_akun']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus akun ini?')"
                                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-600 hover:text-white text-red-500 transition-all shadow-sm">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="p-20 text-center">
                                <p class="text-gray-600 uppercase tracking-widest font-bold italic">No Accounting Data Found</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-700 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Finance Elite Management
        </p>
    </footer>
</div>

</body>
</html>