<?php

require 'koneksi.php';

$id = $_GET["id_jadwal"];

if (hapusJadwal($id) > 0){
    echo "
        <script>
            alert('data berhasil dihapus!');
            document.location.href='tampil_jadwal.php';
        </script>
    ";
}else{
    echo "
        <script>
            alert('data gagal dihapus!');
            document.location.href='tampil_jadwal.php';
        </script>
    ";
}

?>
