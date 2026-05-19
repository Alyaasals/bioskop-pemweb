<?php
require 'koneksi.php';

$id = $_GET["id"]; // Ambil id studio dari URL

mysqli_query($koneksi, "DELETE FROM jadwal_tayang WHERE id_studio = '$id'");

mysqli_query($koneksi, "DELETE FROM studio WHERE id_studio = '$id'");

if (mysqli_affected_rows($koneksi) > 0) {
    echo "<script>alert('Data Terhapus'); location='tampil_studio.php'</script>";
} else {
    echo "<script>alert('Data GAGAL dihapus!'); location='tampil_studio.php'</script>";
}
?>
