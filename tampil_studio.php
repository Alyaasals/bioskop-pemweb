<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

$query = "SELECT id_studio, kapasitas FROM studio";
$data = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Studio - STATIC.</title>
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
        .studio-card:hover {
            border-color: rgba(99, 102, 241, 0.5); /* Indigo-500 */
            background: rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-6xl mx-auto">
    <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
        <div>
            <h1 class="text-5xl font-black tracking-tighter uppercase leading-none">THEATRE <span class="text-indigo-500">ROOMS</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.5em] uppercase font-bold mt-2">Physical Asset Management</p>
        </div>
        <div class="flex gap-4">
            <a href="dashboard.php" class="glass px-6 py-3 rounded-2xl text-sm hover:bg-white/10 transition flex items-center gap-2">
                <i class="fas fa-th-large text-indigo-500"></i>
            </a>
            <a href="tambah_studio.php" class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-2xl font-black text-sm transition-all shadow-lg shadow-indigo-900/20 flex items-center gap-2 uppercase tracking-widest">
                <i class="fas fa-plus"></i> New Studio
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="glass p-6 rounded-[2rem] flex items-center gap-5">
            <div class="w-12 h-12 bg-indigo-500/20 rounded-2xl flex items-center justify-center text-indigo-500">
                <i class="fas fa-door-open text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Total Studio</p>
                <p class="text-2xl font-black"><?= mysqli_num_rows($data); ?></p>
            </div>
        </div>
    </div>

    <div class="glass rounded-[2.5rem] overflow-hidden shadow-2xl border border-white/5">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-white/5 text-gray-400 uppercase text-[10px] tracking-[0.2em]">
                        <th class="p-6 font-bold w-32 text-center">Room ID</th>
                        <th class="p-6 font-bold">Configuration & Capacity</th>
                        <th class="p-6 font-bold text-center w-48">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/5">
                    <?php if (mysqli_num_rows($data) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($data)): ?>
                        <tr class="studio-card">
                            <td class="p-6 text-center">
                                <span class="text-2xl font-black text-indigo-500 font-mono italic">
                                    #<?= htmlspecialchars($row["id_studio"]); ?>
                                </span>
                            </td>
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <div class="p-3 bg-white/5 rounded-xl">
                                        <i class="fas fa-couch text-gray-400"></i>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-lg uppercase tracking-tight">Standard Theatre Mode</p>
                                        <p class="text-gray-500 text-xs font-semibold">
                                            Kapasitas Maksimal: <span class="text-indigo-400"><?= htmlspecialchars($row["kapasitas"]); ?> Kursi</span>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6">
                                <div class="flex justify-center gap-3">
                                    <a href="edit_studio.php?id_studio=<?= $row['id_studio']; ?>" 
                                       class="px-4 py-2 rounded-xl bg-white/5 hover:bg-indigo-600 hover:text-white text-gray-400 text-[10px] font-black uppercase tracking-widest transition-all">
                                        Edit
                                    </a>
                                    <a href="delete_studio.php?id_studio=<?= $row['id_studio']; ?>" 
                                       onclick="return confirm('Yakin ingin menghapus studio ini?')"
                                       class="w-10 h-10 flex items-center justify-center rounded-xl bg-red-500/10 hover:bg-red-600 hover:text-white text-red-500 transition-all">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="p-20 text-center">
                                <i class="fas fa-couch text-4xl text-gray-700 mb-4 block"></i>
                                <p class="text-gray-500 uppercase tracking-[0.2em] font-bold text-sm">Belum ada data studio terdaftar</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <footer class="mt-16 text-center">
        <p class="text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
            &copy; 2025 STATIC. Cinema Elite Management System
        </p>
    </footer>
</div>

</body>
</html>