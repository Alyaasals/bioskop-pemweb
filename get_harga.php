<?php
include 'koneksi.php';

header('Content-Type: application/json');

if (isset($_GET['id_bahan_baku'])) {
    // Sanitize input
    $id_bb = mysqli_real_escape_string($koneksi, $_GET['id_bahan_baku']);

    // Query untuk mengambil harga beli dari tabel bahan_baku
    $query = "SELECT harga_beli FROM bahan_baku WHERE id_bahan_baku = '$id_bb'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode(['success' => true, 'harga' => $data['harga_beli']]);
    } else {
        echo json_encode(['success' => false, 'harga' => 0, 'message' => 'Bahan baku tidak ditemukan.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'ID Bahan Baku tidak diterima.']);
}
?>