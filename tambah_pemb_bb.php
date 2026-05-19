<?php
// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

if(isset($_POST['submit'])){
    $id = $_POST['id_pembelian'];
    $tgl = $_POST['tgl_pembelian'];
    $jurnal = $_POST['id_jurnal'];

    mysqli_query($koneksi, "
        INSERT INTO pembelian_bahan_baku
        (id_pembelian, id_jurnal, tgl_pembelian, total_harga, status_selesai)
        VALUES
        ('$id','$jurnal','$tgl',0,'Dalam Proses')
    ");

    header("Location: detail_pemb_bb.php?id=$id");
    exit;
}

// ID pembelian
$qPB = mysqli_query($koneksi,"
    SELECT id_pembelian FROM pembelian_bahan_baku
    ORDER BY id_pembelian DESC LIMIT 1
");
$dataPB = mysqli_fetch_assoc($qPB);
$noPB = $dataPB ? (int)substr($dataPB['id_pembelian'],2)+1 : 1;
$id_pembelian = "PB".str_pad($noPB,3,"0",STR_PAD_LEFT);

// ID jurnal
$qJ = mysqli_query($koneksi,"
    SELECT id_jurnal FROM pembelian_bahan_baku
    ORDER BY id_jurnal DESC LIMIT 1
");
$dataJ = mysqli_fetch_assoc($qJ);
$noJ = $dataJ ? (int)substr($dataJ['id_jurnal'],1)+1 : 1;
$id_jurnal = "J".str_pad($noJ,3,"0",STR_PAD_LEFT);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pembelian - STATIC.</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.85), rgba(0, 0, 0, 0.9)), 
                        url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
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
        }
        .input-glass:focus {
            border-color: #3b82f6 !important; /* Blue-500 */
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2);
            outline: none;
        }
    </style>
</head>
<body class="py-10 px-6">

<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-black tracking-tighter uppercase">BARU <span class="text-blue-500">PEMBELIAN</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Procurement Initialization</p>
        </div>
        <a href="view_pemb_bb.php" class="glass px-6 py-2 rounded-xl text-sm hover:bg-white/10 transition flex items-center gap-2">
            <i class="fas fa-arrow-left text-blue-500"></i> Batal
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-8">
        <div class="md:col-span-2 space-y-6">
            <div class="glass p-8 rounded-[2.5rem] border-l-4 border-blue-500/50">
                <i class="fas fa-info-circle text-blue-500 text-3xl mb-4"></i>
                <h4 class="text-lg font-bold mb-2">Inisialisasi</h4>
                <p class="text-sm text-gray-400 leading-relaxed">
                    Tahap awal ini akan mendaftarkan nomor transaksi dan jurnal ke dalam sistem. Setelah disimpan, Anda dapat menambahkan detail item bahan baku pada halaman berikutnya.
                </p>
            </div>
            
            <div class="glass p-6 rounded-3xl text-center">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-1 font-bold">Status Transaksi</p>
                <span class="text-yellow-500 font-bold text-sm italic">Dalam Proses</span>
            </div>
        </div>

        <div class="md:col-span-3">
            <div class="glass p-10 rounded-[2.5rem] shadow-2xl">
                <form action="" method="post" class="space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">ID Pembelian</label>
                            <input type="text" name="id_pembelian" value="<?= $id_pembelian ?>" class="input-glass w-full px-4 py-3 font-mono opacity-70" readonly>
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">ID Jurnal</label>
                            <input type="text" name="id_jurnal" value="<?= $id_jurnal ?>" class="input-glass w-full px-4 py-3 font-mono opacity-70" readonly>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-500 mb-2">Tanggal Transaksi</label>
                        <input type="date" name="tgl_pembelian" value="<?= date('Y-m-d') ?>" class="input-glass w-full px-4 py-3 text-white" required>
                    </div>

                    <div class="pt-4">
                        <button type="submit" name="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-black tracking-widest text-sm transition-all shadow-lg shadow-blue-900/30 flex justify-center items-center gap-3">
                            BUAT TRANSAKSI <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <p class="mt-12 text-center text-[10px] text-gray-600 uppercase tracking-[0.5em] font-bold">
        &copy; 2025 STATIC. Cinema Elite Management System
    </p>
</div>

</body>
</html>