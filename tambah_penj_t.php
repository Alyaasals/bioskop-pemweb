<?php
require'koneksi.php';

$IdPenjualanTiket = $_POST['id_penjualan_tiket'] ?? AmbilIPenjualanTiket();

if (isset($_POST["submit"])) {

    $detail = GetDataDetailPenjTiket($IdPenjualanTiket);
    InsertDetailPenjT();
    echo "
        <script>
            alert('barang berhasil ditambahkan!');
            document.location.href='form_penj_t.php?id_penjualan_tiket={$IdPenjualanTiket}'; 
        </script>
    ";
    
} else {

    $detail = GetDataDetailPenjTiket($IdPenjualanTiket); 
    echo "
        <script>
            alert('barang tidak berhasil ditambahkan!');
            document.location.href='form_penj_t.php?id_penjualan_tiket={$IdPenjualanTiket}'; 
        </script>
    ";
    echo "luarbatas";
}

exit;
?>