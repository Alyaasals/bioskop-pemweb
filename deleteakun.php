<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "DELETE FROM akun WHERE no_akun='$id'");

header("Location: tampilakun.php");
?>