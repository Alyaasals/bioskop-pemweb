<?php
include "koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM Film WHERE id_film='$id'");
header("location:tampilFilm.php?success=hapus");
?>
