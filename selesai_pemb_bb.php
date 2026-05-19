<?php
include 'koneksi.php';

$id = $_GET['id'];

$total = tampil("
    SELECT SUM(subtotal) AS total
    FROM detail_pembelian_bahan_baku
    WHERE id_pembelian = '$id'
")[0]['total'];

mysqli_query($koneksi,"
UPDATE pembelian_bahan_baku
SET total_harga = '$total',
    status_selesai = 'Selesai'
WHERE id_pembelian = '$id'
");

header("Location: view_pemb_bb.php");
