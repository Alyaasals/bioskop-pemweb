<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']); // id_retur

    // Ambil id_pembelian terkait dari detail_retur
    $res = mysqli_query($koneksi, "SELECT id_pembelian FROM detail_retur_bahan_baku WHERE id_retur = '$id' LIMIT 1");
    $data_retur = mysqli_fetch_assoc($res);
    $id_pembelian = $data_retur['id_pembelian'];

    // Hitung total retur
    $total = mysqli_fetch_assoc(mysqli_query($koneksi,"
        SELECT SUM(subtotal) AS total
        FROM detail_retur_bahan_baku
        WHERE id_retur = '$id'
    "))['total'];

    // Update status di tabel pembelian
    mysqli_query($koneksi,"
        UPDATE pembelian_bahan_baku
        SET status_selesai = 'Selesai'
        WHERE id_pembelian = '$id_pembelian'
    ");

    header("Location: viewtransaksi.php");
    exit;
}
?>