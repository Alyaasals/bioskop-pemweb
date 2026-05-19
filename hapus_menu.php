<?php
require 'koneksi.php';

$id = $_GET["id_menu"];

if (hapusMenu($id) > 0){
    echo "
        <script>
            alert('data berhasil dihapus!');
            document.location.href='viewDaftarMenu.php';
        </script>
    ";
}else{
    echo "
        <script>
            alert('data gagal dihapus!');
            document.location.href='viewDaftarMenu.php';
        </script>
    ";
}

?>