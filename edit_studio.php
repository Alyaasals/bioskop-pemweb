<?php
// --- LOGIKA ASLI (TIDAK DIUBAH) ---
include 'koneksi.php';

if (isset($_POST["submit"])) {  
    if (ubah_studio($_POST) > 0) {
        echo "
        <script>
        alert('Data berhasil diubah!');
        document.location.href='tampil_studio.php';
        </script>
        ";
    } else {
        echo "
        <script>
        alert('Data gagal diubah!');
        document.location.href='tampil_studio.php';
        </script>
        ";
    }
    exit;
}
// ambil id dari URL
$id = $_GET["id_studio"] ?? null;

// kalau ID tidak ada
if (!$id){
    echo "
    <script>
    alert('ID tidak ditemukan!');
    document.location.href='tampil_studio.php';
    </script>
    ";
    exit;
}
// ambil 1 data saja
$data = tampil("SELECT * FROM studio WHERE id_studio = '$id'")[0];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Studio - STATIC.</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        :root {
            --bg-dark: #0b0712;
            --navy-card: #161b33;
            --accent-pink: #e91e63;
            --accent-blue: #00d2ff;
            --text-light: #ffffff;
            --border-color: #2e2c3a;
        }

        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            background: var(--navy-card);
            padding: 40px;
            border-radius: 20px;
            border: 1px solid var(--border-color);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            width: 100%;
            max-width: 450px;
        }

        .form-control {
            background-color: #0f1224;
            border: 1px solid var(--border-color);
            color: white !important;
            border-radius: 8px;
            padding: 12px;
            height: auto;
        }

        .form-control:focus {
            background-color: #0f1224;
            border-color: var(--accent-pink);
            box-shadow: 0 0 0 0.2rem rgba(233, 30, 99, 0.25);
        }

        .form-control[readonly] {
            background-color: rgba(255,255,255,0.05);
            color: #888 !important;
            cursor: not-allowed;
        }

        label {
            font-weight: 600;
            color: var(--accent-blue);
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-submit {
            background-color: var(--accent-pink);
            border: none;
            color: white;
            font-weight: bold;
            padding: 14px;
            margin-top: 20px;
            transition: 0.3s;
            text-transform: uppercase;
        }

        .btn-submit:hover {
            background-color: #c2185b;
            transform: translateY(-2px);
            color: white;
        }

        .btn-back {
            color: #888;
            text-decoration: none;
            font-size: 0.9rem;
            transition: 0.3s;
        }

        .btn-back:hover { color: white; text-decoration: none; }
    </style>
</head>
<body>

<div class="form-container">
    <div class="text-center mb-4">
        <h3 class="font-weight-bold">UBAH STUDIO</h3>
        <div style="width: 40px; height: 3px; background: var(--accent-pink); margin: 10px auto;"></div>
    </div>

    <form method="POST" action="">
        <input type="hidden" name="id_lama" value="<?= htmlspecialchars($data['id_studio']); ?>">

        <div class="form-group">
            <label for="id_studio">ID Studio</label>
            <input type="text" name="id_studio" id="id_studio" class="form-control" value="<?= htmlspecialchars($data['id_studio']); ?>" required>
            <small class="text-muted mt-1 d-block">* Ubah ID jika diperlukan</small>
        </div>

        <div class="form-group">
            <label for="kapasitas">Kapasitas Kursi</label>
            <div class="input-group">
                <input type="number" name="kapasitas" id="kapasitas" class="form-control" value="<?= htmlspecialchars($data['kapasitas']); ?>" required>
            </div>
        </div>

        <button type="submit" name="submit" value="Ubah" class="btn btn-block btn-submit shadow-sm">
            Simpan Perubahan
        </button>

        <div class="text-center mt-4">
            <a href="tampil_studio.php" class="btn-back">
                <i class="fas fa-arrow-left mr-1"></i> Batal & Kembali
            </a>
        </div>
    </form>
</div>

</body>
</html>