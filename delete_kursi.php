<?php
require 'koneksi.php';

$id = $_GET["id"];  // Ambil id dari URL

// Query delete harus punya nilai ID
mysqli_query($koneksi, "DELETE FROM kursi WHERE id_kursi = '$id'");

// Cek apakah berhasil dihapus
if(mysqli_affected_rows($koneksi) > 0){
    echo "<script>alert('Data Terhapus'); location='tampil_kursi.php'</script>";
} else {
    echo "<script>alert('Data GAGAL terhapus (ID tidak ditemukan)'); location='tampil_kursi.php'</script>";
}
?>
