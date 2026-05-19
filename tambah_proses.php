<?php 
include 'koneksi.php'; 

if (isset($_POST['simpan'])) {
    $id_penggunaan = $_POST['id_penggunaan'];
    $id_jurnal = $_POST['id_jurnal'];
    $tanggal = $_POST['tanggal'];
    $total = $_POST['total'];

    $query = "INSERT INTO penggunaan_bahan_baku (id_penggunaan, id_jurnal, tanggal, total) 
              VALUES ('$id_penggunaan', '$id_jurnal', '$tanggal', '$total')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: selesai_penggunaan.php?id=$id_penggunaan");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>