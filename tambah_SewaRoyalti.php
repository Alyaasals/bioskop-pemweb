<?php
include "koneksi.php";

$idFilm = $_POST['id_film'];
$tanggalSewa = $_POST['tanggal_sewa'];
$tanggalTutupTayang = $_POST['tanggal_tutup_tayang'];
$hargaRoyalti = $_POST['harga_royalti'];

/* ===============================
   Generate ID Sewa Royalti
================================ */
$queryLastSewaRoyalti = mysqli_query(
    $koneksi,
    "SELECT id_sewa FROM sewa_royalti ORDER BY id_sewa DESC LIMIT 1"
);

$dataLastSewaRoyalti = mysqli_fetch_assoc($queryLastSewaRoyalti);

$nomorUrutSewa = isset($dataLastSewaRoyalti['id_sewa'])
    ? (int)substr($dataLastSewaRoyalti['id_sewa'], 3) + 1
    : 1;

$idSewaRoyalti = "RYL" . str_pad($nomorUrutSewa, 3, "0", STR_PAD_LEFT);

/* ===============================
   Generate ID Jurnal
================================ */
$queryLastJurnal = mysqli_query(
    $koneksi,
    "SELECT id_jurnal FROM jurnal_umum ORDER BY id_jurnal DESC LIMIT 1"
);

$dataLastJurnal = mysqli_fetch_assoc($queryLastJurnal);

$nomorUrutJurnal = isset($dataLastJurnal['id_jurnal'])
    ? (int)substr($dataLastJurnal['id_jurnal'], 1) + 1
    : 1;

$idJurnal = "J" . str_pad($nomorUrutJurnal, 3, "0", STR_PAD_LEFT);

/* ===============================
   Insert ke Jurnal Umum
================================ */
mysqli_query($koneksi, "
    INSERT INTO jurnal_umum (id_jurnal, tanggal, jenis_transaksi)
    VALUES (
        '$idJurnal',
        CURDATE(),
        'Sewa Royalti Film ($idSewaRoyalti)'
    )
");

/* ===============================
   Insert ke Sewa Royalti
   STATUS LANGSUNG SELESAI
================================ */
mysqli_query($koneksi, "
    INSERT INTO sewa_royalti
    (id_sewa, id_film, id_jurnal, tanggal_sewa, tanggal_tutup_tayang, harga, status_selesai)
    VALUES (
        '$idSewaRoyalti',
        '$idFilm',
        '$idJurnal',
        '$tanggalSewa',
        '$tanggalTutupTayang',
        '$hargaRoyalti',
        'Selesai'
    )
");

/* ===============================
   Update Status Film → Ongoing
================================ */
mysqli_query($koneksi, "
    UPDATE film
    SET status_tayang = 'Ongoing'
    WHERE id_film = '$idFilm'
");

/* ===============================
   Redirect
================================ */
header("Location: view_transaksiSewaRoyalti.php");
