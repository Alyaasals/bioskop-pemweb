<?php
require 'koneksi.php';

$id_penjualan_tiket = $_GET['id_penjualan_tiket'];

// 1. Selesaikan transaksi
$hasil = SelesaiBelanja($id_penjualan_tiket);

if ($hasil == 1) {

    // 2. Generate header jurnal
    $tanggal = date('Y-m-d');
    $id_jurnal = GenerateJurnalHeader($id_penjualan_tiket, $tanggal);

    // 3. Ambil total transaksi
    $total = GetTotalTransaksi($id_penjualan_tiket);

    // 4. Detail jurnal
    GenerateJurnal($id_jurnal, 111, $total, 0); // Kas (Debit)
    GenerateJurnal($id_jurnal, 411, 0, $total); // Pendapatan (Kredit)

    // 5. Simpan relasi jurnal ke penjualan_tiket
    mysqli_query($conn,"UPDATE penjualan_tiket 
        SET id_jurnal='$id_jurnal'
        WHERE id_penjualan_tiket='$id_penjualan_tiket'");

    echo "<script>
        alert('Transaksi berhasil diselesaikan & jurnal tercatat');
        document.location='view_penj_t.php';
    </script>";

} else {
    echo "<script>
        alert('Transaksi gagal diselesaikan');
        document.location='view_penj_t.php';
    </script>";
}
?>
