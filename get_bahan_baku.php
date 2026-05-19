<?php
include 'koneksi.php';

if(isset($_GET['id_pembelian'])) {
    $id_pembelian = mysqli_real_escape_string($koneksi, $_GET['id_pembelian']);
    
    // Join ke tabel bahan_baku untuk ambil namanya
    $query = mysqli_query($koneksi, "
        SELECT p.id_bhn_baku, b.nama_bhn_baku 
        FROM pembelian_bahan_baku p
        JOIN bahan_baku b ON p.id_bhn_baku = b.id_bhn_baku
        WHERE p.id_pembelian = '$id_pembelian'
    ");
    
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data);
}
?>