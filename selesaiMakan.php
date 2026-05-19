<?php
require 'koneksi.php';

// Mengambil ID Penjualan Makan Minum dari parameter URL
$id_penj_mkn_min = $_GET['id_penj_mkn_min'];

// 1. Selesaikan transaksi (Mengubah status menjadi 'Selesai' dan update total_harga)
$hasil = SelesaiBelanjaMakanMinum($id_penj_mkn_min);

if ($hasil >= 1) { // Menggunakan >= 1 untuk mengantisipasi mysqli_affected_rows

    // 2. Generate header jurnal
    $tanggal = date('Y-m-d');
    $id_jurnal = GenerateJurnalHeaderMakanMinum($id_penj_mkn_min, $tanggal);

    // 3. Ambil total transaksi makan minum
    $total = GetTotalMakanMinum($id_penj_mkn_min);

    // 4. Detail jurnal
    // Akun 111: Kas (Debit)
    // Akun 412: Pendapatan Makan Minum (Kredit) -> Sesuaikan nomor akun dengan tabel akun Anda
    GenerateJurnalMakanMinum($id_jurnal, 111, $total, 0); 
    GenerateJurnalMakanMinum($id_jurnal, 412, 0, $total); 

    // 5. Simpan relasi jurnal ke penjualan_makan_minum
    // Sesuai database Anda: id_penj_mkn_min
    mysqli_query($conn, "UPDATE penjualan_makan_minum 
        SET id_jurnal = '$id_jurnal'
        WHERE id_penj_mkn_min = '$id_penj_mkn_min'");

    echo "<script>
        alert('Transaksi makan minum berhasil diselesaikan & jurnal tercatat');
        document.location='viewMakan.php';
    </script>";

} else {
    echo "<script>
        alert('Transaksi gagal diselesaikan');
        document.location='viewMakan.php';
    </script>";
}
?>