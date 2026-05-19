<?php
require 'koneksi.php';

// Mengambil ID Penjualan Makan Minum dari POST atau generate otomatis jika belum ada
$id_penj_mkn_min = $_POST['id_penj_mkn_min'] ?? AmbilIPenjualanMakanMinum();

if (isset($_POST["submit"])) {
    // Memanggil fungsi insert khusus makan minum yang sudah dibuat sebelumnya
    // Fungsi ini menghitung subtotal otomatis dan update total_harga di tabel induk
    $hasil = InsertDetailMakanMinum(); 
    
    if ($hasil > 0) {
        echo "
            <script>
                alert('Menu berhasil ditambahkan ke keranjang!');
                document.location.href='formMakan.php?id_penj_mkn_min={$id_penj_mkn_min}'; 
            </script>
        ";
    } else {
        echo "
            <script>
                alert('Gagal menambahkan menu! Periksa kembali pilihan Anda.');
                document.location.href='formMakan.php?id_penj_mkn_min={$id_penj_mkn_min}'; 
            </script>
        ";
    }
    
} else {
    // Logika jika file diakses tanpa melalui tombol submit
    echo "
        <script>
            alert('Akses ditolak! Gunakan form untuk menambah barang.');
            document.location.href='formMakan.php?id_penj_mkn_min={$id_penj_mkn_min}'; 
        </script>
    ";
}

exit;
?>