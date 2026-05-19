<!DOCTYPE html>
<html lang="id">
<head>
    <title>Transaksi Selesai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center">
    <div class="container mt-5">
        <div class="alert alert-success shadow">
            <h4 class="alert-heading">Berhasil!</h4>
            <p>Transaksi penggunaan bahan baku dengan ID <strong><?= $_GET['id']; ?></strong> telah berhasil disimpan.</p>
            <hr>
            <a href="form_peng_bb.php" class="btn btn-success">Tambah Lagi</a>
            <a href="view_pengg.php" class="btn btn-outline-dark">Lihat Laporan</a>
        </div>
    </div>
</body>
</html>