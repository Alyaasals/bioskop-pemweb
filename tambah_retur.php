<?php
include 'koneksi.php';

// --- LOGIKA PHP ASLI (TIDAK DIUBAH) ---
if (isset($_POST['submit'])) {
    $id_retur     = mysqli_real_escape_string($koneksi, $_POST['id_retur']);
    $id_bhn_baku  = mysqli_real_escape_string($koneksi, $_POST['id_bhn_baku']);
    $id_pembelian = mysqli_real_escape_string($koneksi, $_POST['id_pembelian']);
    $jumlah       = $_POST['jumlah_retur'];
    $harga        = $_POST['harga_satuan'];
    $satuan       = mysqli_real_escape_string($koneksi, $_POST['satuan']); 
    $alasan       = mysqli_real_escape_string($koneksi, $_POST['alasan']);
    $subtotal     = $jumlah * $harga;

    $query = "INSERT INTO detail_retur_bahan_baku 
              (id_retur, id_bhn_baku, id_pembelian, jumlah_retur, keterangan, harga_satuan, subtotal, alasan) 
              VALUES 
              ('$id_retur', '$id_bhn_baku', '$id_pembelian', '$jumlah', '$satuan', '$harga', '$subtotal', '$alasan')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Data Berhasil Disimpan!'); window.location='view_retur.php';</script>";
        exit;
    } else {
        die("Gagal simpan: " . mysqli_error($koneksi));
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Retur - SIG(NE)MA</title>
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
            border-color: #db2777 !important; /* Pink-600 */
            box-shadow: 0 0 0 2px rgba(219, 39, 119, 0.2);
            outline: none;
        }
        select option { background: #1a1a1a; color: white; }
    </style>
</head>
<body class="py-10 px-6">

    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tighter">INPUT <span class="text-pink-600">RETUR</span></h1>
            <p class="text-gray-500 text-xs tracking-[0.4em] uppercase font-semibold">Cinema Management System</p>
        </div>

        <div class="glass p-8 md:p-12 rounded-[2.5rem] shadow-2xl">
            <form method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">ID Retur</label>
                        <input type="text" name="id_retur" class="input-glass w-full px-4 py-3" placeholder="Contoh: RT001" required>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">ID Pembelian</label>
                        <input type="text" name="id_pembelian" class="input-glass w-full px-4 py-3" placeholder="Input ID Pembelian" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">ID Bahan Baku</label>
                    <input type="text" name="id_bhn_baku" class="input-glass w-full px-4 py-3" placeholder="Input ID Bahan Baku" required>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Jumlah Retur</label>
                        <input type="number" name="jumlah_retur" id="jumlah" class="input-glass w-full px-4 py-3" required>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Satuan</label>
                        <select name="satuan" class="input-glass w-full px-4 py-3" required>
                            <option value="">-- Pilih --</option>
                            <option value="Ekor">Ekor</option>
                            <option value="Kg">Kg</option>
                            <option value="Gram">Gram</option>
                            <option value="Pcs">Pcs</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Harga Satuan</label>
                        <input type="number" name="harga_satuan" id="harga" class="input-glass w-full px-4 py-3" required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Subtotal (Otomatis)</label>
                    <input type="text" id="subtotal_display" class="input-glass w-full px-4 py-3 bg-white/5 font-bold text-pink-500" readonly placeholder="Rp 0">
                </div>

                <div class="mb-10">
                    <label class="block text-[10px] uppercase tracking-widest font-bold text-gray-400 mb-2">Alasan Retur</label>
                    <textarea name="alasan" class="input-glass w-full px-4 py-3 h-24" placeholder="Alasan pengembalian barang..." required></textarea>
                </div>

                <div class="flex items-center justify-end gap-4">
                    <a href="view_retur.php" class="text-gray-500 hover:text-white text-xs uppercase font-bold tracking-widest transition">Batal</a>
                    <button type="submit" name="submit" class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-pink-900/20">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#jumlah, #harga').on('input', function() {
                var jml = $('#jumlah').val() || 0;
                var hrg = $('#harga').val() || 0;
                var total = jml * hrg;
                $('#subtotal_display').val("Rp " + total.toLocaleString('id-ID'));
            });
        });
    </script>
</body>
</html>