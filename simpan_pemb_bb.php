<?php
include 'koneksi.php';

$id = $_POST['id_pembelian'];
$bhn = $_POST['id_bhn_baku'];
$jml = $_POST['jumlah'];
$harga = $_POST['harga_satuan'];
$ket = $_POST['keterangan'];

$subtotal = $jml * $harga;

mysqli_query($koneksi,"
INSERT INTO detail_pembelian_bahan_baku
(id_pembelian,id_bhn_baku,jumlah,keterangan,harga_satuan,subtotal)
VALUES
('$id','$bhn','$jml','$ket','$harga','$subtotal')
");

header("Location: detail_pemb_bb.php?id=$id");
