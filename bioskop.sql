-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Des 2025 pada 14.55
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bismillah`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `no_akun` int(11) NOT NULL,
  `nm_akun` varchar(100) NOT NULL,
  `header_akun` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`no_akun`, `nm_akun`, `header_akun`) VALUES
(1, 'Aktiva', NULL),
(2, 'Hutang', NULL),
(3, 'Modal', NULL),
(4, 'Pendapatan', NULL),
(5, 'Beban', NULL),
(11, 'Aktiva Lancar', 1),
(21, 'Hutang Lancar', 2),
(41, 'Pendapatan Usaha', 4),
(51, 'Beban Operasional', 5),
(111, 'Kas', 11),
(112, 'Piutang Dagang', 11),
(113, 'Persediaan Barang Dagang', 11),
(114, 'Sewa Dibayar Dimuka', 11),
(115, 'Asuransi Dibayar Dimuka', 11),
(116, 'Perlengkapan', 11),
(211, 'Utang Dagang', 21),
(311, 'Modal Tn X', 3),
(411, 'Penjualan Tiket', 41),
(412, 'Pendapatan Makanan/Minuman', 41),
(413, 'Retur Penjualan', 41),
(414, 'Potongan Penjualan', 41),
(511, 'Beban Listrik', 51),
(512, 'Beban Air', 51),
(513, 'Beban Telepon', 51),
(514, 'Beban Gaji', 51),
(516, 'Beban Sewa Royalti Film', 51),
(3112, 'Prive Tn X', 311),
(5111, 'Beban Pembelian Bahan Baku', 51),
(5112, 'Beban Penggunaan Bahan Baku', 51),
(5131, 'Beban Royalti Film', 51);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bhn_baku` varchar(10) NOT NULL,
  `nama_bhn_baku` varchar(100) DEFAULT NULL,
  `total` int(11) DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `keterangan` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `bahan_baku`
--

INSERT INTO `bahan_baku` (`id_bhn_baku`, `nama_bhn_baku`, `total`, `jumlah`, `keterangan`) VALUES
('Cam01', 'Gula', 15000, 5, 'kg'),
('Cam02', 'Garam', 10000, 5, 'kg'),
('Mak01', 'Ayam', 35000, 10, 'ekor'),
('Mak02', 'Beras', 12000, 25, 'kg'),
('Mak03', 'Cabai', 30000, 10, 'kg'),
('Min01', 'Susu', NULL, NULL, NULL),
('Min02', 'Teh', NULL, NULL, NULL),
('Min03', 'Kopi', 4000, 300, 'gram'),
('Min04', 'Sirup Melon', 20000, 10, 'botol'),
('Min05', 'Soda', 15000, 20, 'kaleng');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_jurnal_umum`
--

CREATE TABLE `detail_jurnal_umum` (
  `id_jurnal` varchar(20) NOT NULL,
  `no_akun` int(11) NOT NULL,
  `debit` decimal(15,2) DEFAULT 0.00,
  `kredit` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_jurnal_umum`
--

INSERT INTO `detail_jurnal_umum` (`id_jurnal`, `no_akun`, `debit`, `kredit`) VALUES
('J001', 111, 70000.00, 0.00),
('J001', 412, 0.00, 70000.00),
('J002', 111, 25000.00, 0.00),
('J002', 412, 0.00, 25000.00),
('J003', 111, 85000.00, 0.00),
('J003', 412, 0.00, 85000.00),
('J004', 111, 20000.00, 0.00),
('J004', 412, 0.00, 20000.00),
('J005', 111, 70000.00, 0.00),
('J005', 412, 0.00, 70000.00),
('J006', 111, 105000.00, 0.00),
('J006', 412, 0.00, 105000.00),
('J007', 111, 0.00, 350000.00),
('J007', 5111, 350000.00, 0.00),
('J008', 111, 0.00, 300000.00),
('J008', 5111, 300000.00, 0.00),
('J009', 111, 0.00, 300000.00),
('J009', 5111, 300000.00, 0.00),
('J010', 111, 0.00, 75000.00),
('J010', 5111, 75000.00, 0.00),
('J011', 111, 0.00, 50000.00),
('J011', 5111, 50000.00, 0.00),
('J012', 111, 0.00, 150000.00),
('J012', 5111, 150000.00, 0.00),
('J013', 111, 70000.00, 0.00),
('J013', 5111, 0.00, 70000.00),
('J014', 111, 15000.00, 0.00),
('J014', 5111, 0.00, 15000.00),
('J015', 111, 20000.00, 0.00),
('J015', 5111, 0.00, 20000.00),
('J016', 111, 0.00, 50000000.00),
('J016', 5131, 50000000.00, 0.00),
('J017', 111, 0.00, 1500000000.00),
('J017', 5131, 1500000000.00, 0.00),
('J018', 111, 90000.00, 0.00),
('J018', 411, 0.00, 90000.00),
('J019', 111, 45000.00, 0.00),
('J019', 411, 0.00, 45000.00),
('J020', 111, 55000.00, 0.00),
('J020', 411, 0.00, 55000.00),
('J021', 111, 90000.00, 0.00),
('J021', 411, 0.00, 90000.00),
('J022', 111, 55000.00, 0.00),
('J022', 411, 0.00, 55000.00),
('J023', 111, 45000.00, 0.00),
('J023', 411, 0.00, 45000.00),
('J026', 113, 0.00, 49000.00),
('J026', 5112, 49000.00, 0.00),
('J027', 113, 0.00, 25000.00),
('J027', 5112, 25000.00, 0.00),
('J028', 113, 0.00, 72000.00),
('J028', 5112, 72000.00, 0.00),
('J029', 113, 0.00, 20000.00),
('J029', 5112, 20000.00, 0.00),
('J030', 113, 0.00, 12000.00),
('J030', 5112, 12000.00, 0.00),
('J031', 113, 0.00, 55000.00),
('J031', 5112, 55000.00, 0.00),
('J032', 113, 0.00, 30000.00),
('J032', 5112, 30000.00, 0.00),
('J033', 113, 0.00, 80000.00),
('J033', 5112, 80000.00, 0.00),
('J034', 111, 200000.00, 0.00),
('J034', 411, 0.00, 200000.00),
('J035', 111, 45000.00, 0.00),
('J035', 411, 0.00, 45000.00),
('J036', 111, 90000.00, 0.00),
('J036', 411, 0.00, 90000.00),
('J037', 111, 45000.00, 0.00),
('J037', 411, 0.00, 45000.00),
('J038', 111, 45000.00, 0.00),
('J038', 411, 0.00, 45000.00),
('J039', 111, 110000.00, 0.00),
('J039', 411, 0.00, 110000.00),
('J040', 111, 45000.00, 0.00),
('J040', 411, 0.00, 45000.00),
('J041', 111, 50000.00, 0.00),
('J041', 411, 0.00, 50000.00),
('J043', 111, 0.00, 50000.00),
('J043', 5111, 50000.00, 0.00),
('J044', 111, 0.00, 120000.00),
('J044', 5111, 120000.00, 0.00),
('J045', 111, 0.00, 175000.00),
('J045', 5111, 175000.00, 0.00),
('J046', 111, 0.00, 60000.00),
('J046', 5111, 60000.00, 0.00),
('J047', 111, 50000.00, 0.00),
('J047', 411, 0.00, 50000.00),
('J057', 111, 40000.00, 0.00),
('J057', 412, 0.00, 40000.00),
('J058', 111, 50000.00, 0.00),
('J058', 412, 0.00, 50000.00),
('J059', 111, 45000.00, 0.00),
('J059', 412, 0.00, 45000.00),
('J060', 111, 18000.00, 0.00),
('J060', 412, 0.00, 18000.00),
('J061', 111, 80000.00, 0.00),
('J061', 412, 0.00, 80000.00),
('J062', 111, 40000.00, 0.00),
('J062', 412, 0.00, 40000.00),
('J063', 111, 72000.00, 0.00),
('J063', 412, 0.00, 72000.00),
('J064', 111, 30000.00, 0.00),
('J064', 412, 0.00, 30000.00),
('J066', 111, 10000.00, 0.00),
('J066', 5111, 0.00, 10000.00),
('J067', 111, 24000.00, 0.00),
('J067', 5111, 0.00, 24000.00),
('J068', 111, 35000.00, 0.00),
('J068', 5111, 0.00, 35000.00),
('J069', 111, 12000.00, 0.00),
('J069', 5111, 0.00, 12000.00),
('J070', 111, 15000.00, 0.00),
('J070', 5111, 0.00, 15000.00),
('J071', 111, 15000.00, 0.00),
('J071', 5111, 0.00, 15000.00),
('J072', 111, 10000.00, 0.00),
('J072', 5111, 0.00, 10000.00),
('J073', 111, 0.00, 5000000.00),
('J073', 5131, 5000000.00, 0.00),
('J074', 111, 0.00, 7000000.00),
('J074', 5131, 7000000.00, 0.00),
('J075', 111, 0.00, 10000000.00),
('J075', 5131, 10000000.00, 0.00),
('J076', 111, 0.00, 8500000.00),
('J076', 5131, 8500000.00, 0.00),
('J077', 111, 0.00, 6000000.00),
('J077', 5131, 6000000.00, 0.00),
('J078', 111, 0.00, 12000000.00),
('J078', 5131, 12000000.00, 0.00),
('J079', 111, 0.00, 9000000.00),
('J079', 5131, 9000000.00, 0.00),
('J080', 111, 0.00, 15000000.00),
('J080', 5131, 15000000.00, 0.00),
('J081', 113, 0.00, 24000.00),
('J081', 5112, 24000.00, 0.00),
('J082', 113, 0.00, 35000.00),
('J082', 5112, 35000.00, 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pembelian_bahan_baku`
--

CREATE TABLE `detail_pembelian_bahan_baku` (
  `id_pembelian` varchar(10) NOT NULL,
  `id_bhn_baku` varchar(10) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_pembelian_bahan_baku`
--

INSERT INTO `detail_pembelian_bahan_baku` (`id_pembelian`, `id_bhn_baku`, `jumlah`, `keterangan`, `harga_satuan`, `subtotal`) VALUES
('PB001', 'Mak01', 10.00, 'ekor', 35000, 350000),
('PB002', 'Mak02', 25.00, 'kg', 12000, 300000),
('PB003', 'Mak03', 10.00, 'kg', 30000, 300000),
('PB004', 'Cam01', 5.00, 'kg', 15000, 75000),
('PB005', 'Cam02', 5.00, 'kg', 10000, 50000),
('PB006', 'Min03', 300.00, 'gram', 500, 150000),
('PB007', 'Min03', 100.00, 'gram', 500, 50000),
('PB008', 'Min01', 5.00, 'liter', 24000, 120000),
('PB009', 'Mak01', 5.00, 'ekor', 35000, 175000),
('PB010', 'Mak02', 5.00, 'kg', 12000, 60000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penggunaan_bahan_baku`
--

CREATE TABLE `detail_penggunaan_bahan_baku` (
  `id_penggunaan` varchar(10) NOT NULL,
  `id_bhn_baku` varchar(10) NOT NULL,
  `jumlah` decimal(10,2) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_penggunaan_bahan_baku`
--

INSERT INTO `detail_penggunaan_bahan_baku` (`id_penggunaan`, `id_bhn_baku`, `jumlah`, `keterangan`, `harga_satuan`, `subtotal`) VALUES
('PG003', 'Mak01', 0.50, 'ekor', 35000, 17500),
('PG003', 'Mak02', 1.00, 'kg', 12000, 12000),
('PG003', 'Min03', 30.00, 'gram', 500, 15000),
('PG004', 'Cam01', 1.00, 'kg', 15000, 15000),
('PG004', 'Min02', 0.50, 'liter', 10000, 5000),
('PG005', 'Mak01', 1.50, 'ekor', 35000, 52500),
('PG005', 'Mak03', 0.20, 'kg', 30000, 6000),
('PG006', 'Cam02', 2.00, 'kg', 10000, 20000),
('PG007', 'Min01', 5.00, 'liter', 2400, 12000),
('PG008', 'Mak02', 3.00, 'kg', 12000, 36000),
('PG008', 'Mak03', 0.80, 'kg', 30000, 24000),
('PG009', 'Min02', 1.00, 'liter', 30000, 30000),
('PG010', 'Mak01', 2.00, 'ekor', 35000, 70000),
('PG010', 'Mak02', 4.00, 'kg', 12000, 48000),
('PG010', 'Mak03', 1.00, 'kg', 30000, 30000),
('PG011', 'Min01', 1.00, 'liter', 24000, 24000),
('PG012', 'Mak01', 1.00, 'ekor', 35000, 35000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penjualan_tiket`
--

CREATE TABLE `detail_penjualan_tiket` (
  `id_penjualan_tiket` varchar(10) NOT NULL,
  `id_jadwal` varchar(10) NOT NULL,
  `id_kursi` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_penjualan_tiket`
--

INSERT INTO `detail_penjualan_tiket` (`id_penjualan_tiket`, `id_jadwal`, `id_kursi`, `jumlah`) VALUES
('TIK009', 'JD03L', 'S2-A1', 1),
('TIK010', 'JD02L', 'S1-A2', 1),
('TIK010', 'JD05L', 'S1-A6', 1),
('TIK010', 'JD07L', 'S1-A8', 1),
('TIK010', 'JD07L', 'S1-A9', 1),
('TIK011', 'JD06L', 'S2-A3', 1),
('TIK012', 'JD02L', 'S1-A1', 1),
('TIK012', 'JD05L', 'S1-A8', 1),
('TIK013', 'JD01L', 'S1-A9', 1),
('TIK014', 'JD09L', 'S3-A2', 1),
('TIK015', 'JD03L', 'S2-A3', 1),
('TIK015', 'JD03L', 'S2-A4', 1),
('TIK016', 'JD05L', 'S1-A7', 1),
('TIK017', 'JD03L', 'S2-A2', 1),
('TIK018', 'JD01L', 'S1-A10', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_penj_mkn_min`
--

CREATE TABLE `detail_penj_mkn_min` (
  `id_penj_mkn_min` int(11) NOT NULL,
  `id_menu` varchar(10) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_penj_mkn_min`
--

INSERT INTO `detail_penj_mkn_min` (`id_penj_mkn_min`, `id_menu`, `jumlah`, `harga`, `subtotal`) VALUES
(1101, 'M001', 1, 40000, 40000),
(1101, 'M003', 2, 15000, 30000),
(1102, 'M003', 1, 15000, 15000),
(1102, 'M006', 1, 10000, 10000),
(1103, 'M002', 1, 45000, 45000),
(1103, 'M004', 2, 20000, 40000),
(1104, 'M006', 2, 10000, 20000),
(1105, 'M001', 1, 40000, 40000),
(1105, 'M005', 1, 20000, 20000),
(1105, 'M006', 1, 10000, 10000),
(1106, 'M002', 2, 45000, 90000),
(1106, 'M003', 1, 15000, 15000),
(1107, 'M001', 1, 40000, 40000),
(1108, 'M002', 2, 25000, 50000),
(1109, 'M003', 3, 15000, 45000),
(1110, 'M004', 1, 18000, 18000),
(1111, 'M001', 2, 40000, 80000),
(1112, 'M002', 1, 25000, 25000),
(1112, 'M003', 1, 15000, 15000),
(1113, 'M004', 4, 18000, 72000),
(1114, 'M003', 2, 15000, 30000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_retur_bahan_baku`
--

CREATE TABLE `detail_retur_bahan_baku` (
  `id_retur` varchar(10) NOT NULL,
  `id_bhn_baku` varchar(10) NOT NULL,
  `id_pembelian` varchar(10) NOT NULL,
  `jumlah_retur` decimal(10,2) NOT NULL,
  `keterangan` varchar(20) NOT NULL,
  `harga_satuan` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `alasan` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `detail_retur_bahan_baku`
--

INSERT INTO `detail_retur_bahan_baku` (`id_retur`, `id_bhn_baku`, `id_pembelian`, `jumlah_retur`, `keterangan`, `harga_satuan`, `subtotal`, `alasan`) VALUES
('RT001', 'Mak01', 'PB001', 2.00, 'ekor', 35000, 70000, 'Ayam tidak segar'),
('RT002', 'Cam01', 'PB004', 1.00, 'kg', 15000, 15000, 'Salah pengiriman'),
('RT003', 'Min03', 'PB006', 50.00, 'gram', 500, 25000, 'Jenis kopi tidak sesuai'),
('RT004', 'Min03', 'PB007', 20.00, 'gram', 500, 10000, 'Rusak'),
('RT005', 'Min01', 'PB008', 1.00, 'liter', 24000, 24000, 'Kadaluarsa'),
('RT006', 'Mak01', 'PB009', 1.00, 'ekor', 35000, 35000, 'Ayam tidak segar'),
('RT007', 'Mak02', 'PB010', 1.00, 'kg', 12000, 12000, 'Beras berkutu'),
('RT008', 'Min02', 'PB005', 50.00, 'gram', 300, 15000, 'Kemasan terbuka'),
('RT009', 'Cam01', 'PB001', 1.00, 'kg', 15000, 15000, 'Gula basah'),
('RT010', 'Cam02', 'PB002', 1.00, 'bungkus', 10000, 10000, 'Kerupuk melempem');

-- --------------------------------------------------------

--
-- Struktur dari tabel `film`
--

CREATE TABLE `film` (
  `id_film` varchar(10) NOT NULL,
  `nama_film` varchar(150) DEFAULT NULL,
  `genre` varchar(50) DEFAULT NULL,
  `durasi` int(11) DEFAULT NULL,
  `status_tayang` varchar(50) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `film`
--

INSERT INTO `film` (`id_film`, `nama_film`, `genre`, `durasi`, `status_tayang`, `harga`) VALUES
('F001', 'Barbie Fairytale', 'Kartun', 105, 'Ongoing', 45000),
('F002', 'Ada Apa Dengan Cinta', 'Horror', 145, 'Coming Soon', 0),
('F003', 'Who Knows?', 'Romance', 90, 'Ongoing', 55000),
('F004', 'Tetangga Masa Gitu', 'Comedy', 92, 'Ongoing', 45000),
('F005', 'Dilan', 'Romance', 120, 'Ongoing', 45000),
('F006', 'Avengers: The Last Stand', 'Action', 180, 'Expired', 0),
('F007', 'Spider-Man 4', 'Action', 130, 'Coming Soon', 0),
('F008', 'The Nun 3', 'Horror', 110, 'Ongoing', 50000),
('F009', 'Fast X', 'Action', 140, 'Ongoing', 55000),
('F010', 'Toy Story 5', 'Animation', 100, 'Coming Soon', 0);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_tayang`
--

CREATE TABLE `jadwal_tayang` (
  `id_jadwal` varchar(10) NOT NULL,
  `id_film` varchar(10) DEFAULT NULL,
  `id_studio` varchar(10) DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `jadwal_tayang`
--

INSERT INTO `jadwal_tayang` (`id_jadwal`, `id_film`, `id_studio`, `waktu_mulai`) VALUES
('JD01L', 'F005', 'S3', '15:20:00'),
('JD02L', 'F001', 'S1', '14:45:00'),
('JD03L', 'F003', 'S2', '12:15:00'),
('JD04L', 'F003', 'S3', '17:20:00'),
('JD05L', 'F005', 'S1', '18:15:00'),
('JD06L', 'F005', 'S2', '20:45:00'),
('JD07L', 'F003', 'S1', '11:05:00'),
('JD08L', 'F004', 'S3', '11:45:00'),
('JD09L', 'F004', 'S3', '20:05:00'),
('JD10L', 'F001', 'S4', '13:00:00'),
('JD11L', 'F003', 'S5', '15:30:00'),
('JD12L', 'F004', 'S6', '19:00:00'),
('JD13L', 'F005', 'S7', '21:15:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurnal_umum`
--

CREATE TABLE `jurnal_umum` (
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `jenis_transaksi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `jurnal_umum`
--

INSERT INTO `jurnal_umum` (`id_jurnal`, `tanggal`, `jenis_transaksi`) VALUES
('J001', '2025-01-01', 'Penjualan makanan/minuman (1101)'),
('J002', '2025-01-02', 'Penjualan makanan/minuman (1102)'),
('J003', '2025-01-02', 'Penjualan makanan/minuman (1103)'),
('J004', '2025-01-03', 'Penjualan makanan/minuman (1104)'),
('J005', '2025-01-04', 'Penjualan makanan/minuman (1105)'),
('J006', '2025-01-05', 'Penjualan makanan/minuman (1106)'),
('J007', '2025-01-05', 'Pembelian bahan baku (PB001)'),
('J008', '2025-01-06', 'Pembelian bahan baku (PB002)'),
('J009', '2025-01-06', 'Pembelian bahan baku (PB003)'),
('J010', '2025-01-07', 'Pembelian bahan baku (PB004)'),
('J011', '2025-01-08', 'Pembelian bahan baku (PB005)'),
('J012', '2025-01-08', 'Pembelian bahan baku (PB006)'),
('J013', '2025-01-06', 'Retur pembelian (RT001)'),
('J014', '2025-01-08', 'Retur pembelian (RT002)'),
('J015', '2025-01-09', 'Retur pembelian (RT003)'),
('J016', '2025-01-10', 'Pembayaran royalti (RYL001)'),
('J017', '2025-01-12', 'Pembayaran royalti (RYL002)'),
('J018', '2025-11-21', 'Penjualan tiket (TIK001)'),
('J019', '2025-11-21', 'Penjualan tiket (TIK002)'),
('J020', '2025-11-21', 'Penjualan tiket (TIK003)'),
('J021', '2025-11-21', 'Penjualan tiket (TIK004)'),
('J022', '2025-11-22', 'Penjualan tiket (TIK005)'),
('J023', '2025-11-22', 'Penjualan tiket (TIK006)'),
('J024', '2025-01-07', 'Penggunaan Bahan Baku (UBB001)'),
('J025', '2025-01-09', 'Penggunaan Bahan Baku (UBB002)'),
('J026', '2025-01-10', 'Penggunaan Bahan Baku (UBB003)'),
('J027', '2025-01-11', 'Penggunaan Bahan Baku (UBB004)'),
('J028', '2025-01-12', 'Penggunaan Bahan Baku (UBB005)'),
('J029', '2025-01-13', 'Penggunaan Bahan Baku (UBB006)'),
('J030', '2025-01-14', 'Penggunaan Bahan Baku (UBB007)'),
('J031', '2025-01-15', 'Penggunaan Bahan Baku (UBB008)'),
('J032', '2025-01-16', 'Penggunaan Bahan Baku (UBB009)'),
('J033', '2025-01-17', 'Penggunaan Bahan Baku (UBB010)'),
('J034', '2025-12-14', 'Penjualan tiket (TIK010)'),
('J035', '2025-12-14', 'Penjualan tiket (TIK011)'),
('J036', '2025-12-14', 'Penjualan tiket (TIK012)'),
('J037', '2025-12-14', 'Penjualan tiket (TIK013)'),
('J038', '2025-12-15', 'Penjualan tiket (TIK014)'),
('J039', '2025-12-15', 'Penjualan tiket (TIK015)'),
('J040', '2025-12-15', 'Penjualan tiket (TIK016)'),
('J041', '2025-12-17', 'Penjualan tiket (TIK017)'),
('J043', '2025-12-17', 'Pembelian bahan baku (PB007)'),
('J044', '2025-12-17', 'Pembelian bahan baku (PB008)'),
('J045', '2025-12-17', 'Pembelian bahan baku (PB009)'),
('J046', '2025-12-17', 'Pembelian bahan baku (PB010)'),
('J047', '2025-12-17', 'Penjualan tiket (TIK018)'),
('J057', '2025-12-17', 'Penjualan Mkn/Min (1107)'),
('J058', '2025-12-17', 'Penjualan Mkn/Min (1108)'),
('J059', '2025-12-17', 'Penjualan Mkn/Min (1109)'),
('J060', '2025-12-17', 'Penjualan Mkn/Min (1110)'),
('J061', '2025-12-17', 'Penjualan Mkn/Min (1111)'),
('J062', '2025-12-17', 'Penjualan Mkn/Min (1112)'),
('J063', '2025-12-17', 'Penjualan Mkn/Min (1113)'),
('J064', '2025-12-17', 'Penjualan Mkn/Min (1114)'),
('J065', '2025-12-17', 'Penjualan Mkn/Min (1115)'),
('J066', '2025-12-17', 'Retur Pembelian (RT004)'),
('J067', '2025-12-17', 'Retur Pembelian (RT005)'),
('J068', '2025-12-17', 'Retur Pembelian (RT006)'),
('J069', '2025-12-17', 'Retur Pembelian (RT007)'),
('J070', '2025-12-17', 'Retur Pembelian (RT008)'),
('J071', '2025-12-17', 'Retur Pembelian (RT009)'),
('J072', '2025-12-17', 'Retur Pembelian (RT010)'),
('J073', '2025-12-17', 'Bayar Royalti (RYL003)'),
('J074', '2025-12-17', 'Bayar Royalti (RYL004)'),
('J075', '2025-12-17', 'Bayar Royalti (RYL005)'),
('J076', '2025-12-17', 'Bayar Royalti (RYL006)'),
('J077', '2025-12-17', 'Bayar Royalti (RYL007)'),
('J078', '2025-12-17', 'Bayar Royalti (RYL008)'),
('J079', '2025-12-17', 'Bayar Royalti (RYL009)'),
('J080', '2025-12-17', 'Bayar Royalti (RYL010)'),
('J081', '2025-12-17', 'Penggunaan Bahan (PG011)'),
('J082', '2025-12-17', 'Penggunaan Bahan (PG012)');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kursi`
--

CREATE TABLE `kursi` (
  `id_kursi` varchar(10) NOT NULL,
  `id_studio` varchar(10) DEFAULT NULL,
  `no_kursi` varchar(5) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `kursi`
--

INSERT INTO `kursi` (`id_kursi`, `id_studio`, `no_kursi`) VALUES
('S1-A1', 'S1', 'A1'),
('S1-A10', 'S1', 'A10'),
('S1-A2', 'S1', 'A2'),
('S1-A3', 'S1', 'A3'),
('S1-A4', 'S1', 'A4'),
('S1-A5', 'S1', 'A5'),
('S1-A6', 'S1', 'A6'),
('S1-A7', 'S1', 'A7'),
('S1-A8', 'S1', 'A8'),
('S1-A9', 'S1', 'A9'),
('S10-A1', 'S10', 'A1'),
('S10-A10', 'S10', 'A10'),
('S10-A2', 'S10', 'A2'),
('S10-A3', 'S10', 'A3'),
('S10-A4', 'S10', 'A4'),
('S10-A5', 'S10', 'A5'),
('S10-A6', 'S10', 'A6'),
('S10-A7', 'S10', 'A7'),
('S10-A8', 'S10', 'A8'),
('S10-A9', 'S10', 'A9'),
('S2-A1', 'S2', 'A1'),
('S2-A10', 'S2', 'A10'),
('S2-A2', 'S2', 'A2'),
('S2-A3', 'S2', 'A3'),
('S2-A4', 'S2', 'A4'),
('S2-A5', 'S2', 'A5'),
('S2-A6', 'S2', 'A6'),
('S2-A7', 'S2', 'A7'),
('S2-A8', 'S2', 'A8'),
('S2-A9', 'S2', 'A9'),
('S3-A1', 'S3', 'A1'),
('S3-A10', 'S3', 'A10'),
('S3-A2', 'S3', 'A2'),
('S3-A3', 'S3', 'A3'),
('S3-A4', 'S3', 'A4'),
('S3-A5', 'S3', 'A5'),
('S3-A6', 'S3', 'A6'),
('S3-A7', 'S3', 'A7'),
('S3-A8', 'S3', 'A8'),
('S3-A9', 'S3', 'A9'),
('S4-A1', 'S4', 'A1'),
('S4-A10', 'S4', 'A10'),
('S4-A2', 'S4', 'A2'),
('S4-A3', 'S4', 'A3'),
('S4-A4', 'S4', 'A4'),
('S4-A5', 'S4', 'A5'),
('S4-A6', 'S4', 'A6'),
('S4-A7', 'S4', 'A7'),
('S4-A8', 'S4', 'A8'),
('S4-A9', 'S4', 'A9'),
('S5-A1', 'S5', 'A1'),
('S5-A10', 'S5', 'A10'),
('S5-A2', 'S5', 'A2'),
('S5-A3', 'S5', 'A3'),
('S5-A4', 'S5', 'A4'),
('S5-A5', 'S5', 'A5'),
('S5-A6', 'S5', 'A6'),
('S5-A7', 'S5', 'A7'),
('S5-A8', 'S5', 'A8'),
('S5-A9', 'S5', 'A9'),
('S6-A1', 'S6', 'A1'),
('S6-A10', 'S6', 'A10'),
('S6-A2', 'S6', 'A2'),
('S6-A3', 'S6', 'A3'),
('S6-A4', 'S6', 'A4'),
('S6-A5', 'S6', 'A5'),
('S6-A6', 'S6', 'A6'),
('S6-A7', 'S6', 'A7'),
('S6-A8', 'S6', 'A8'),
('S6-A9', 'S6', 'A9'),
('S7-A1', 'S7', 'A1'),
('S7-A10', 'S7', 'A10'),
('S7-A2', 'S7', 'A2'),
('S7-A3', 'S7', 'A3'),
('S7-A4', 'S7', 'A4'),
('S7-A5', 'S7', 'A5'),
('S7-A6', 'S7', 'A6'),
('S7-A7', 'S7', 'A7'),
('S7-A8', 'S7', 'A8'),
('S7-A9', 'S7', 'A9'),
('S8-A1', 'S8', 'A1'),
('S8-A10', 'S8', 'A10'),
('S8-A2', 'S8', 'A2'),
('S8-A3', 'S8', 'A3'),
('S8-A4', 'S8', 'A4'),
('S8-A5', 'S8', 'A5'),
('S8-A6', 'S8', 'A6'),
('S8-A7', 'S8', 'A7'),
('S8-A8', 'S8', 'A8'),
('S8-A9', 'S8', 'A9'),
('S9-A1', 'S9', 'A1'),
('S9-A10', 'S9', 'A10'),
('S9-A2', 'S9', 'A2'),
('S9-A3', 'S9', 'A3'),
('S9-A4', 'S9', 'A4'),
('S9-A5', 'S9', 'A5'),
('S9-A6', 'S9', 'A6'),
('S9-A7', 'S9', 'A7'),
('S9-A8', 'S9', 'A8'),
('S9-A9', 'S9', 'A9');

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` varchar(10) NOT NULL,
  `jenis` varchar(50) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `harga` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `jenis`, `nama`, `harga`) VALUES
('M001', 'Makanan', 'Nasi Goreng', 40000),
('M002', 'Makanan', 'Nasi Ayam Penyet', 45000),
('M003', 'Minuman', 'Es Teh Manis', 15000),
('M004', 'Minuman', 'Kopi Susu', 20000),
('M005', 'Minuman', 'Teh Susu', 20000),
('M006', 'Minuman', 'Teh Tawar', 10000),
('M007', 'Makanan', 'Mie Goreng Seafood', 35000),
('M008', 'Minuman', 'Juice Alpukat', 25000),
('M009', 'Makanan', 'Kentang Goreng', 20000),
('M010', 'Minuman', 'Soda Gembira', 22000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembelian_bahan_baku`
--

CREATE TABLE `pembelian_bahan_baku` (
  `id_pembelian` varchar(10) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `tgl_pembelian` date NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_selesai` varchar(50) DEFAULT 'Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `pembelian_bahan_baku`
--

INSERT INTO `pembelian_bahan_baku` (`id_pembelian`, `id_jurnal`, `tgl_pembelian`, `total_harga`, `status_selesai`) VALUES
('PB001', 'J007', '2025-01-05', 350000, 'Selesai'),
('PB002', 'J008', '2025-01-06', 300000, 'Selesai'),
('PB003', 'J009', '2025-01-06', 300000, 'Selesai'),
('PB004', 'J010', '2025-01-07', 75000, 'Selesai'),
('PB005', 'J011', '2025-01-08', 50000, 'Selesai'),
('PB006', 'J012', '2025-01-08', 150000, 'Selesai'),
('PB007', 'J043', '2025-12-17', 50000, 'Selesai'),
('PB008', 'J044', '2025-12-17', 120000, 'Selesai'),
('PB009', 'J045', '2025-12-17', 175000, 'Selesai'),
('PB010', 'J046', '2025-12-17', 60000, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggunaan_bahan_baku`
--

CREATE TABLE `penggunaan_bahan_baku` (
  `id_penggunaan` varchar(10) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `penggunaan_bahan_baku`
--

INSERT INTO `penggunaan_bahan_baku` (`id_penggunaan`, `id_jurnal`, `tanggal`, `total`) VALUES
('PG003', 'J026', '2025-01-10', 44500),
('PG004', 'J027', '2025-01-11', 20000),
('PG005', 'J028', '2025-01-12', 58500),
('PG006', 'J029', '2025-01-13', 20000),
('PG007', 'J030', '2025-01-14', 12000),
('PG008', 'J031', '2025-01-15', 60000),
('PG009', 'J032', '2025-01-16', 30000),
('PG010', 'J033', '2025-01-17', 148000),
('PG011', 'J081', '2025-12-17', 24000),
('PG012', 'J082', '2025-12-17', 35000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_makan_minum`
--

CREATE TABLE `penjualan_makan_minum` (
  `id_penj_mkn_min` int(11) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal` date NOT NULL,
  `total_harga` int(11) NOT NULL,
  `status_selesai` varchar(50) DEFAULT 'Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `penjualan_makan_minum`
--

INSERT INTO `penjualan_makan_minum` (`id_penj_mkn_min`, `id_jurnal`, `tanggal`, `total_harga`, `status_selesai`) VALUES
(1101, 'J001', '2025-01-01', 70000, 'Selesai'),
(1102, 'J002', '2025-01-02', 25000, 'Selesai'),
(1103, 'J003', '2025-01-02', 85000, 'Selesai'),
(1104, 'J004', '2025-01-03', 20000, 'Selesai'),
(1105, 'J005', '2025-01-04', 70000, 'Selesai'),
(1106, 'J006', '2025-01-05', 105000, 'Selesai'),
(1107, 'J057', '2025-12-17', 40000, 'Selesai'),
(1108, 'J058', '2025-12-17', 50000, 'Selesai'),
(1109, 'J059', '2025-12-17', 45000, 'Selesai'),
(1110, 'J060', '2025-12-17', 18000, 'Selesai'),
(1111, 'J061', '2025-12-17', 80000, 'Selesai'),
(1112, 'J062', '2025-12-17', 40000, 'Selesai'),
(1113, 'J063', '2025-12-17', 72000, 'Selesai'),
(1114, 'J064', '2025-12-17', 30000, 'Selesai'),
(1115, 'J065', '2025-12-17', 58000, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `penjualan_tiket`
--

CREATE TABLE `penjualan_tiket` (
  `id_penjualan_tiket` varchar(10) NOT NULL,
  `tanggal_transaksi` date DEFAULT NULL,
  `total_harga` int(11) DEFAULT 0,
  `status_selesai` varchar(50) DEFAULT 'Selesai',
  `id_jurnal` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `penjualan_tiket`
--

INSERT INTO `penjualan_tiket` (`id_penjualan_tiket`, `tanggal_transaksi`, `total_harga`, `status_selesai`, `id_jurnal`) VALUES
('TIK009', '2025-12-08', 55000, 'Selesai', NULL),
('TIK010', '2025-12-14', 200000, 'Selesai', 'J034'),
('TIK011', '2025-12-14', 45000, 'Selesai', 'J035'),
('TIK012', '2025-12-14', 90000, 'Selesai', 'J036'),
('TIK013', '2025-12-14', 45000, 'Selesai', 'J037'),
('TIK014', '2025-12-15', 45000, 'Selesai', 'J038'),
('TIK015', '2025-12-15', 110000, 'Selesai', 'J039'),
('TIK016', '2025-12-15', 45000, 'Selesai', 'J040'),
('TIK017', '2025-12-17', 50000, 'Selesai', 'J041'),
('TIK018', '2025-12-17', 50000, 'Selesai', 'J047');

-- --------------------------------------------------------

--
-- Struktur dari tabel `retur_pembelian_bahan_baku`
--

CREATE TABLE `retur_pembelian_bahan_baku` (
  `id_retur` varchar(10) NOT NULL,
  `id_pembelian` varchar(10) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `tgl_retur` date NOT NULL,
  `total_retur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `retur_pembelian_bahan_baku`
--

INSERT INTO `retur_pembelian_bahan_baku` (`id_retur`, `id_pembelian`, `id_jurnal`, `tgl_retur`, `total_retur`) VALUES
('RT001', 'PB001', 'J013', '2025-01-06', 70000),
('RT002', 'PB004', 'J014', '2025-01-08', 15000),
('RT003', 'PB006', 'J015', '2025-01-09', 25000),
('RT004', 'PB007', 'J066', '2025-12-17', 10000),
('RT005', 'PB008', 'J067', '2025-12-17', 24000),
('RT006', 'PB009', 'J068', '2025-12-17', 35000),
('RT007', 'PB010', 'J069', '2025-12-17', 12000),
('RT008', 'PB005', 'J070', '2025-12-17', 15000),
('RT009', 'PB001', 'J071', '2025-12-17', 15000),
('RT010', 'PB002', 'J072', '2025-12-17', 10000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `sewa_royalti`
--

CREATE TABLE `sewa_royalti` (
  `id_sewa` varchar(10) NOT NULL,
  `id_film` varchar(10) NOT NULL,
  `id_jurnal` varchar(20) NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_tutup_tayang` date NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `status_selesai` varchar(50) DEFAULT 'Selesai'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `sewa_royalti`
--

INSERT INTO `sewa_royalti` (`id_sewa`, `id_film`, `id_jurnal`, `tanggal_sewa`, `tanggal_tutup_tayang`, `harga`, `status_selesai`) VALUES
('RYL001', 'F001', 'J016', '2025-01-10', '2025-03-10', 50000000.00, 'Selesai'),
('RYL002', 'F003', 'J017', '2025-01-12', '2025-03-12', 1500000000.00, 'Selesai'),
('RYL003', 'F004', 'J073', '2025-12-17', '2026-01-17', 5000000.00, 'Selesai'),
('RYL004', 'F005', 'J074', '2025-12-17', '2026-01-17', 7000000.00, 'Selesai'),
('RYL005', 'F001', 'J075', '2025-12-17', '2026-01-17', 10000000.00, 'Selesai'),
('RYL006', 'F002', 'J076', '2025-12-17', '2026-01-17', 8500000.00, 'Selesai'),
('RYL007', 'F003', 'J077', '2025-12-17', '2026-01-17', 6000000.00, 'Selesai'),
('RYL008', 'F004', 'J078', '2025-12-17', '2026-01-17', 12000000.00, 'Selesai'),
('RYL009', 'F005', 'J079', '2025-12-17', '2026-01-17', 9000000.00, 'Selesai'),
('RYL010', 'F006', 'J080', '2025-12-17', '2026-01-17', 15000000.00, 'Selesai');

-- --------------------------------------------------------

--
-- Struktur dari tabel `studio`
--

CREATE TABLE `studio` (
  `id_studio` varchar(10) NOT NULL,
  `kapasitas` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data untuk tabel `studio`
--

INSERT INTO `studio` (`id_studio`, `kapasitas`) VALUES
('S1', 10),
('S10', 10),
('S2', 10),
('S3', 10),
('S4', 10),
('S5', 10),
('S6', 10),
('S7', 10),
('S8', 10),
('S9', 10);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`no_akun`);

--
-- Indeks untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id_bhn_baku`);

--
-- Indeks untuk tabel `detail_jurnal_umum`
--
ALTER TABLE `detail_jurnal_umum`
  ADD PRIMARY KEY (`id_jurnal`,`no_akun`),
  ADD KEY `no_akun` (`no_akun`);

--
-- Indeks untuk tabel `detail_pembelian_bahan_baku`
--
ALTER TABLE `detail_pembelian_bahan_baku`
  ADD PRIMARY KEY (`id_pembelian`,`id_bhn_baku`),
  ADD KEY `id_bhn_baku_dpbb` (`id_bhn_baku`);

--
-- Indeks untuk tabel `detail_penggunaan_bahan_baku`
--
ALTER TABLE `detail_penggunaan_bahan_baku`
  ADD PRIMARY KEY (`id_penggunaan`,`id_bhn_baku`),
  ADD KEY `id_bhn_baku_dpbb` (`id_bhn_baku`);

--
-- Indeks untuk tabel `detail_penjualan_tiket`
--
ALTER TABLE `detail_penjualan_tiket`
  ADD PRIMARY KEY (`id_penjualan_tiket`,`id_jadwal`,`id_kursi`),
  ADD KEY `id_penjualan_tiket_idx` (`id_penjualan_tiket`),
  ADD KEY `id_jadwal_idx` (`id_jadwal`),
  ADD KEY `id_kursi_idx` (`id_kursi`);

--
-- Indeks untuk tabel `detail_penj_mkn_min`
--
ALTER TABLE `detail_penj_mkn_min`
  ADD PRIMARY KEY (`id_penj_mkn_min`,`id_menu`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `detail_retur_bahan_baku`
--
ALTER TABLE `detail_retur_bahan_baku`
  ADD PRIMARY KEY (`id_retur`,`id_bhn_baku`),
  ADD KEY `id_bhn_baku_drbb` (`id_bhn_baku`),
  ADD KEY `id_pembelian_drbb` (`id_pembelian`);

--
-- Indeks untuk tabel `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id_film`);

--
-- Indeks untuk tabel `jadwal_tayang`
--
ALTER TABLE `jadwal_tayang`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_film` (`id_film`),
  ADD KEY `id_studio` (`id_studio`);

--
-- Indeks untuk tabel `jurnal_umum`
--
ALTER TABLE `jurnal_umum`
  ADD PRIMARY KEY (`id_jurnal`);

--
-- Indeks untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD PRIMARY KEY (`id_kursi`),
  ADD KEY `fk_studio` (`id_studio`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`);

--
-- Indeks untuk tabel `pembelian_bahan_baku`
--
ALTER TABLE `pembelian_bahan_baku`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `id_jurnal_pbb` (`id_jurnal`);

--
-- Indeks untuk tabel `penggunaan_bahan_baku`
--
ALTER TABLE `penggunaan_bahan_baku`
  ADD PRIMARY KEY (`id_penggunaan`),
  ADD KEY `id_jurnal_pbh` (`id_jurnal`);

--
-- Indeks untuk tabel `penjualan_makan_minum`
--
ALTER TABLE `penjualan_makan_minum`
  ADD PRIMARY KEY (`id_penj_mkn_min`),
  ADD KEY `id_jurnal_pmm` (`id_jurnal`);

--
-- Indeks untuk tabel `penjualan_tiket`
--
ALTER TABLE `penjualan_tiket`
  ADD PRIMARY KEY (`id_penjualan_tiket`),
  ADD KEY `fk_pt_jurnal` (`id_jurnal`);

--
-- Indeks untuk tabel `retur_pembelian_bahan_baku`
--
ALTER TABLE `retur_pembelian_bahan_baku`
  ADD PRIMARY KEY (`id_retur`),
  ADD KEY `id_pembelian` (`id_pembelian`),
  ADD KEY `id_jurnal_rpb` (`id_jurnal`);

--
-- Indeks untuk tabel `sewa_royalti`
--
ALTER TABLE `sewa_royalti`
  ADD PRIMARY KEY (`id_sewa`),
  ADD KEY `id_film_sr` (`id_film`),
  ADD KEY `id_jurnal_sr` (`id_jurnal`);

--
-- Indeks untuk tabel `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`id_studio`);

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_jurnal_umum`
--
ALTER TABLE `detail_jurnal_umum`
  ADD CONSTRAINT `fk_dju_akun` FOREIGN KEY (`no_akun`) REFERENCES `akun` (`no_akun`),
  ADD CONSTRAINT `fk_dju_ju` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);

--
-- Ketidakleluasaan untuk tabel `detail_pembelian_bahan_baku`
--
ALTER TABLE `detail_pembelian_bahan_baku`
  ADD CONSTRAINT `fk_dpbb_bb` FOREIGN KEY (`id_bhn_baku`) REFERENCES `bahan_baku` (`id_bhn_baku`),
  ADD CONSTRAINT `fk_dpbb_pbb` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian_bahan_baku` (`id_pembelian`);

--
-- Ketidakleluasaan untuk tabel `detail_penggunaan_bahan_baku`
--
ALTER TABLE `detail_penggunaan_bahan_baku`
  ADD CONSTRAINT `fk_dpbb_bb2` FOREIGN KEY (`id_bhn_baku`) REFERENCES `bahan_baku` (`id_bhn_baku`),
  ADD CONSTRAINT `fk_dpbb_pb` FOREIGN KEY (`id_penggunaan`) REFERENCES `penggunaan_bahan_baku` (`id_penggunaan`);

--
-- Ketidakleluasaan untuk tabel `detail_penjualan_tiket`
--
ALTER TABLE `detail_penjualan_tiket`
  ADD CONSTRAINT `fk_dpt_jadwal` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwal_tayang` (`id_jadwal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dpt_kursi` FOREIGN KEY (`id_kursi`) REFERENCES `kursi` (`id_kursi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_dpt_penjualan` FOREIGN KEY (`id_penjualan_tiket`) REFERENCES `penjualan_tiket` (`id_penjualan_tiket`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_penj_mkn_min`
--
ALTER TABLE `detail_penj_mkn_min`
  ADD CONSTRAINT `fk_dpmm_menu` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `fk_dpmm_pmm` FOREIGN KEY (`id_penj_mkn_min`) REFERENCES `penjualan_makan_minum` (`id_penj_mkn_min`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_retur_bahan_baku`
--
ALTER TABLE `detail_retur_bahan_baku`
  ADD CONSTRAINT `fk_drbb_bb` FOREIGN KEY (`id_bhn_baku`) REFERENCES `bahan_baku` (`id_bhn_baku`),
  ADD CONSTRAINT `fk_drbb_pbb` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian_bahan_baku` (`id_pembelian`),
  ADD CONSTRAINT `fk_drbb_rpb` FOREIGN KEY (`id_retur`) REFERENCES `retur_pembelian_bahan_baku` (`id_retur`);

--
-- Ketidakleluasaan untuk tabel `jadwal_tayang`
--
ALTER TABLE `jadwal_tayang`
  ADD CONSTRAINT `fk_jadwal_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  ADD CONSTRAINT `fk_jadwal_studio` FOREIGN KEY (`id_studio`) REFERENCES `studio` (`id_studio`);

--
-- Ketidakleluasaan untuk tabel `kursi`
--
ALTER TABLE `kursi`
  ADD CONSTRAINT `fk_studio` FOREIGN KEY (`id_studio`) REFERENCES `studio` (`id_studio`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembelian_bahan_baku`
--
ALTER TABLE `pembelian_bahan_baku`
  ADD CONSTRAINT `fk_pbb_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);

--
-- Ketidakleluasaan untuk tabel `penggunaan_bahan_baku`
--
ALTER TABLE `penggunaan_bahan_baku`
  ADD CONSTRAINT `fk_pb_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);

--
-- Ketidakleluasaan untuk tabel `penjualan_makan_minum`
--
ALTER TABLE `penjualan_makan_minum`
  ADD CONSTRAINT `fk_pmm_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);

--
-- Ketidakleluasaan untuk tabel `penjualan_tiket`
--
ALTER TABLE `penjualan_tiket`
  ADD CONSTRAINT `fk_pt_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);

--
-- Ketidakleluasaan untuk tabel `retur_pembelian_bahan_baku`
--
ALTER TABLE `retur_pembelian_bahan_baku`
  ADD CONSTRAINT `fk_rpb_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`),
  ADD CONSTRAINT `fk_rpb_pbb` FOREIGN KEY (`id_pembelian`) REFERENCES `pembelian_bahan_baku` (`id_pembelian`);

--
-- Ketidakleluasaan untuk tabel `sewa_royalti`
--
ALTER TABLE `sewa_royalti`
  ADD CONSTRAINT `fk_sr_film` FOREIGN KEY (`id_film`) REFERENCES `film` (`id_film`),
  ADD CONSTRAINT `fk_sr_jurnal` FOREIGN KEY (`id_jurnal`) REFERENCES `jurnal_umum` (`id_jurnal`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
