<?php
include 'koneksi.php';

$id = $_GET['id']; // ambil id dari parameter URL

// hapus data produk berdasarkan id
mysqli_query($koneksi, "DELETE FROM bahan_baku WHERE id_bhn_baku = '$id'");
echo "<script>alert('Data berhasil dihapus'); location='tampilBahanBaku.php'</script>"; // Tampilkan alert dan redirect ke tampilProduk.php

?>
