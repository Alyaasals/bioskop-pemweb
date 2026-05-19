<?php
// =========================================================================
// 1. PENGATURAN KONEKSI GLOBAL DAN UTILITY
// =========================================================================

mysqli_report(MYSQLI_REPORT_OFF); 

$host = "localhost";
$user = "root";
$pass = "";
$db = "bioskop";

$conn = mysqli_connect($host, $user, $pass, $db);

$koneksi = $conn; 

if (!$conn) {
    die("Koneksi gagal ke database 'bioskop': " . mysqli_connect_error());
}

$tanggal_transaksi_saat_ini = date('Y-m-d'); 

function formatRp($angka){
    $hasil_rupiah = "Rp " . number_format($angka, 0,',','.'); 
    return $hasil_rupiah;
}
function tampil($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    if (!$result) { return []; } 
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

// =========================================================================
// 2. FUNGSI JURNAL UMUM (JU)
// =========================================================================

function GenerateJurnalHeader($id_transaksi, $tanggal){
    global $conn;

    $q_max = "SELECT MAX(CAST(SUBSTRING(id_jurnal, 2) AS UNSIGNED)) AS max_num 
              FROM jurnal_umum";
    $res = mysqli_fetch_assoc(mysqli_query($conn, $q_max));
    $next = ($res['max_num'] ?? 0) + 1;

    $id_jurnal = 'J' . str_pad($next, 3, '0', STR_PAD_LEFT);
    $jenis = "Transaksi ID: $id_transaksi";

    $q_insert = "INSERT INTO jurnal_umum (id_jurnal, tanggal, jenis_transaksi, id_transaksi)
                 VALUES ('$id_jurnal', '$tanggal', '$jenis', '$id_transaksi')";
    mysqli_query($conn, $q_insert);

    return $id_jurnal;
}

function GenerateJurnal($id_jurnal, $no_akun, $debit, $kredit){
    global $conn;
    $q_insert = "INSERT INTO detail_jurnal_umum (id_jurnal, no_akun, debit, kredit)
                 VALUES ('$id_jurnal', '$no_akun', $debit, $kredit)";
    mysqli_query($conn, $q_insert);
    return mysqli_affected_rows($conn);
}

function GetDataJurnal($tglAwal, $tglAkhir, $filterTransaksi = 'Semua'){
    global $conn; // Sesuaikan jika variabel koneksi Anda $koneksi
    
    $query = "SELECT dju.id_jurnal, ju.tanggal, dju.no_akun, a.nm_akun, dju.debit, dju.kredit, ju.jenis_transaksi
              FROM detail_jurnal_umum dju
              INNER JOIN jurnal_umum ju ON ju.id_jurnal = dju.id_jurnal
              INNER JOIN akun a ON a.no_akun = dju.no_akun 
              WHERE ju.tanggal BETWEEN STR_TO_DATE('$tglAwal', '%Y-%m-%d') AND STR_TO_DATE('$tglAkhir', '%Y-%m-%d')";

    // Tambahkan filter jika user memilih transaksi tertentu
    if ($filterTransaksi != 'Semua') {
        $query .= " AND ju.jenis_transaksi LIKE '%$filterTransaksi%'";
    }

    $query .= " ORDER BY ju.tanggal, ju.id_jurnal, dju.debit DESC";
    return tampil($query);
}

// =========================================================================
// 3. FUNGSI MODUL PENJUALAN TIKET (TIK)
// =========================================================================

function AmbilIPenjualanTiket() {
    
    global $conn;
    
    $query=mysqli_query($conn,"SELECT id_penjualan_tiket FROM penjualan_tiket WHERE status_selesai='Dalam Proses' ORDER BY id_penjualan_tiket DESC LIMIT 1");
    
    if(mysqli_num_rows($query) == 0){ 
        $noTerakhir=mysqli_query($conn,"SELECT MAX(CAST(SUBSTRING(id_penjualan_tiket, 4) AS UNSIGNED)) AS maxNoTrns FROM penjualan_tiket");
        $cekIdPenjualan=mysqli_fetch_assoc($noTerakhir);
        $IdTerakhirNum = $cekIdPenjualan["maxNoTrns"] ?? 0;
        $angkaBaru = $IdTerakhirNum + 1;
        $IdPenjualanTiket = 'TIK' . str_pad($angkaBaru, 3, '0', STR_PAD_LEFT); 
        $noTrans = $IdPenjualanTiket;
        $tglTrans = date('Y-m-d'); 
        $totTrans = 0;
        $statusTrans='Dalam Proses'; 
        // Insert transaksi baru ke tabel penjualan_tiket
        $query ="INSERT INTO penjualan_tiket (id_penjualan_tiket, tanggal_transaksi, total_harga, status_selesai) 
                  VALUES('$noTrans', '$tglTrans', '$totTrans', '$statusTrans')";
        mysqli_query($conn,$query);
        return $noTrans;
        
    } else {
        // Jika sudah ada transaksi 'Dalam Proses', ambil ID-nya
        $data = mysqli_fetch_assoc($query);
        return $data['id_penjualan_tiket'];
    }
}


// 4. FUNGSI UNTUK MENGAMBIL DATA REFERENSI
function GetDataJadwalTayang() {
    global $conn;
    
    $query="SELECT jt.id_jadwal, jt.waktu_mulai, s.id_studio, f.nama_film, f.harga
            FROM jadwal_tayang jt
            JOIN film f ON jt.id_film = f.id_film
            JOIN studio s ON jt.id_studio = s.id_studio
            ORDER BY jt.waktu_mulai ASC";
    return tampil($query, $conn);
}

function GetAllSoldSeats() {
    global $conn;
    
    $query = "SELECT dpt.id_jadwal, k.id_kursi, k.no_kursi
              FROM detail_penjualan_tiket dpt
              JOIN kursi k ON dpt.id_kursi = k.id_kursi
              JOIN penjualan_tiket pt ON dpt.id_penjualan_tiket = pt.id_penjualan_tiket
              WHERE pt.status_selesai IN ('Selesai', 'Dalam Proses')"; 
    
    return tampil($query,$conn);
}

function InsertDetailPenjT() {
    global $conn;
    $id_penjualan_tiket = $_POST['id_penjualan_tiket'];
    $id_jadwal = $_POST['id_jadwal'];
    $id_kursi = $_POST['id_kursi'];
    $jumlah = 1; 
    $cek = mysqli_query($conn, "SELECT d.id_kursi FROM detail_penjualan_tiket d 
                                JOIN penjualan_tiket p ON d.id_penjualan_tiket = p.id_penjualan_tiket 
                                WHERE d.id_jadwal = '$id_jadwal' 
                                AND d.id_kursi = '$id_kursi' 
                                AND p.status_selesai = 'Selesai'");
    
    if (mysqli_num_rows($cek) > 0) {
        return 0; 
    }
    $query_ins = "INSERT INTO detail_penjualan_tiket (id_penjualan_tiket, id_jadwal, id_kursi, jumlah) 
                  VALUES ('$id_penjualan_tiket', '$id_jadwal', '$id_kursi', '$jumlah')";
    
    $eksekusi = mysqli_query($conn, $query_ins);
    if ($eksekusi) {
        $q_harga = mysqli_query($conn, "SELECT f.harga FROM jadwal_tayang jt 
                                        JOIN film f ON jt.id_film = f.id_film 
                                        WHERE jt.id_jadwal = '$id_jadwal'");
        $data_h = mysqli_fetch_assoc($q_harga);
        $harga_tiket = $data_h['harga'];
        mysqli_query($conn, "UPDATE penjualan_tiket SET total_harga = total_harga + $harga_tiket 
                             WHERE id_penjualan_tiket = '$id_penjualan_tiket'");
    }

    return mysqli_affected_rows($conn);
}
function GetDetailPenjualan($id) {
    global $conn;
    
    $query = "SELECT 
        pt.tanggal_transaksi, 
        dt.id_kursi, 
        pt.status_selesai, 
        f.nama_film, 
        f.harga, 
        j.waktu_mulai, 
        k.id_studio, 
        dt.jumlah, 
        (dt.jumlah * f.harga) AS subtotal
        FROM detail_penjualan_tiket dt
        JOIN penjualan_tiket pt ON dt.id_penjualan_tiket = pt.id_penjualan_tiket
        JOIN jadwal_tayang j ON dt.id_jadwal = j.id_jadwal
        JOIN film f ON j.id_film = f.id_film
        JOIN kursi k ON dt.id_kursi = k.id_kursi
        WHERE dt.id_penjualan_tiket = '$id'
    ";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function TotalPenjualan($id_penjualan_tiket) {
    global $conn;
    $query = "SELECT total_harga FROM penjualan_tiket WHERE id_penjualan_tiket = '$id_penjualan_tiket'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_harga'] ?? 0;
}

function SelesaiBelanja($id_penjualan_tiket) {
    global $conn;

    $total = GetTotalPenjTiket($id_penjualan_tiket); 

    if ($total <= 0) {
        return 0;
    }

    $tanggal = date('Y-m-d');
    
    $q_update = "UPDATE penjualan_tiket SET
        tanggal_transaksi = '$tanggal',
        total_harga = $total,
        status_selesai = 'Selesai'
        WHERE id_penjualan_tiket = '$id_penjualan_tiket'";

    mysqli_query($conn, $q_update);

    return mysqli_affected_rows($conn);
}

function GetTotalPenjTiket($id) {
    global $conn;
    
    $query = "SELECT SUM(f.harga * dpt.jumlah) AS totalTrans 
              FROM detail_penjualan_tiket dpt
              JOIN jadwal_tayang jt ON dpt.id_jadwal = jt.id_jadwal
              JOIN film f ON jt.id_film = f.id_film
              WHERE dpt.id_penjualan_tiket='$id'";
              
    $totTrans = mysqli_query($conn, $query);
    
    $hasil=mysqli_fetch_assoc($totTrans);
    
    return $totalBelanja = $hasil["totalTrans"] ?? 0;
}

function GetDataDetailPenjTiket($id_p) {
    global $conn;
    $query = "SELECT 
                f.nama_film, 
                jt.waktu_mulai, 
                jt.id_studio, 
                dpt.id_kursi, 
                f.harga as harga_tiket,
                (f.harga * dpt.jumlah) as subtotal
              FROM detail_penjualan_tiket dpt
              JOIN jadwal_tayang jt ON dpt.id_jadwal = jt.id_jadwal
              JOIN film f ON jt.id_film = f.id_film
              WHERE dpt.id_penjualan_tiket = '$id_p'";
    
    return tampil($query,$conn);
}
// =========================================================================
// 4. FUNGSI MODUL JADWAL TAYANG (JAD)
// =========================================================================

function GenerateIdJadwal() { 

    global $conn;
    $query = "SELECT MAX(CAST(SUBSTRING(id_jadwal, 3, 3) AS UNSIGNED)) AS max_id FROM jadwal_tayang";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $next = ($data['max_id'] ?? 0) + 1;
    return 'JD' . str_pad($next, 3, '0', STR_PAD_LEFT) . 'L';

 }

 function tampil_jadwal($query) {
    global $conn;
    $result = mysqli_query($conn, $query); 
    if (!$result) {
        return []; 
    }

    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows; 
}

function tambahJadwal($data){
    global $conn;
    $idJadwal=htmlspecialchars($data['id_jadwal']);
    $idFilm=htmlspecialchars($data['id_film']);
    $idStudio=htmlspecialchars($data['id_studio']);
    $waktu=htmlspecialchars($data['waktu_mulai']);
    $query="INSERT INTO jadwal_tayang VALUES ('$idJadwal','$idFilm','$idStudio','$waktu')";
    mysqli_query($conn,$query);
    return mysqli_affected_rows($conn);
}

function ubahJadwal($data){
    global $conn;
    $idJadwal=htmlspecialchars($data['id_jadwal']);
    $idFilm=htmlspecialchars($data['id_film']);
    $idStudio=htmlspecialchars($data['id_studio']);
    $waktu=htmlspecialchars($data['waktu_mulai']);
    $query = "UPDATE jadwal_tayang SET id_film='$idFilm', id_studio='$idStudio', waktu_mulai='$waktu' WHERE id_jadwal='$idJadwal'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusJadwal($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM jadwal_tayang WHERE id_jadwal='$id'");
    return mysqli_affected_rows($conn);
}

// =========================================================================
// 5. FUNGSI MODUL BAHAN BAKU
// =========================================================================

function tambah_bb($data){
    global $koneksi;

    $id_bhn_baku   = $data["id_bhn_baku"];
    $nama_bhn_baku = $data["nama_bhn_baku"];
    $total         = $data["total"];
    $jumlah = $data["jumlah"];
    $keterangan         = $data["keterangan"];

    $query = "INSERT INTO bahan_baku (id_bhn_baku, nama_bhn_baku, total, jumlah, keterangan)
              VALUES ('$id_bhn_baku', '$nama_bhn_baku', '$total', '$jumlah', '$keterangan')";

    $hasil = mysqli_query($koneksi, $query);

    if (!$hasil) {
        return 0;
    }
    return mysqli_affected_rows($koneksi);
}

function ubah_bb($data){
    global $koneksi;
    
    $id_bb      = mysqli_real_escape_string($koneksi, $data['id_bhn_baku']);
    $nama_bb    = mysqli_real_escape_string($koneksi, $data['nama_bhn_baku']);
    $total      = mysqli_real_escape_string($koneksi, $data['total']); // Kolom Harga
    $jumlah     = mysqli_real_escape_string($koneksi, $data['jumlah']); // Kolom Stok
    $keterangan = mysqli_real_escape_string($koneksi, $data['keterangan']);

    // Query UPDATE menggunakan NAMA KOLOM LAMA
    $query = "UPDATE bahan_baku SET
                nama_bhn_baku = '$nama_bb',
                total         = '$total',
                jumlah        = '$jumlah',
                keterangan    = '$keterangan'
              WHERE id_bhn_baku = '$id_bb'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


// =========================================================================
// 6. FUNGSI MODUL PENJUALAN F&B (FNBB)
// =========================================================================
function AmbilIPenjualanMakanMinum() {
    global $conn;
    
    // 1. Cek apakah ada transaksi yang masih 'Dalam Proses'
    $query = mysqli_query($conn, "SELECT id_penj_mkn_min FROM penjualan_makan_minum WHERE status_selesai='Dalam Proses' ORDER BY id_penj_mkn_min DESC LIMIT 1");
    
    if(mysqli_num_rows($query) == 0){ 
        // 2. Ambil angka tertinggi langsung dari kolom ID
        $noTerakhir = mysqli_query($conn, "SELECT MAX(id_penj_mkn_min) AS maxNoTrns FROM penjualan_makan_minum");
        $cekIdPenjualan = mysqli_fetch_assoc($noTerakhir);
        
        $IdTerakhirNum = $cekIdPenjualan["maxNoTrns"] ?? 0;
        
        // Jika tabel kosong, tentukan mau mulai dari angka berapa (contoh mulai dari 1100)
        if($IdTerakhirNum == 0){
            $id_baru = 1101; 
        } else {
            $id_baru = $IdTerakhirNum + 1; // Jika terakhir 1115, maka jadi 1116
        }
        
        $tglTrans = date('Y-m-d'); 
        $statusTrans = 'Dalam Proses'; 
        $id_jurnal_dummy = "J000"; // Supaya tidak error Foreign Key

        // 3. Insert transaksi baru
        $sql_insert = "INSERT INTO penjualan_makan_minum (id_penj_mkn_min, tanggal, total_harga, status_selesai, id_jurnal) 
                       VALUES ('$id_baru', '$tglTrans', 0, '$statusTrans', '$id_jurnal_dummy')";
        
        mysqli_query($conn, $sql_insert);
        return $id_baru;
        
    } else {
        // Jika ada yang menggantung, ambil ID tersebut
        $data = mysqli_fetch_assoc($query);
        return $data['id_penj_mkn_min'];
    }
}
    

function GetTotalMakanMinum($id) {
    global $conn;
    
    // Menghitung total harga berdasarkan subtotal yang ada di tabel detail_penj_mkn_min
    // Sesuai struktur tabel: id_penj_mkn_min, id_menu, jumlah, harga, subtotal
    $query = "SELECT SUM(subtotal) AS totalTrans 
              FROM detail_penj_mkn_min 
              WHERE id_penj_mkn_min = '$id'";
              
    $result = mysqli_query($conn, $query);
    $hasil = mysqli_fetch_assoc($result);
    
    // Mengembalikan total belanja, jika kosong maka 0
    return $hasil["totalTrans"] ?? 0;
}

function GetDataMenu() {
    global $conn;
    
    // Mengambil data dari tabel menu
    // Berisi kolom: id_menu, jenis, nama, harga
    $query = "SELECT id_menu, jenis, nama, harga 
              FROM menu 
              ORDER BY jenis ASC, nama ASC";
              
    return tampil($query);
}

// FUNGSI UNTUK MENGAMBIL DETAIL TRANSAKSI MAKAN MINUM (MENGGUNAKAN JOIN)
function GetDataDetailMakanMinum($id_penj_mkn_min) {
    global $conn;
    
    // Kita JOIN ke tabel menu untuk mendapatkan Nama Menu
    $query = "SELECT 
                m.nama as nama_menu, 
                d.harga, 
                d.jumlah, 
                d.subtotal
              FROM detail_penj_mkn_min d
              JOIN menu m ON d.id_menu = m.id_menu
              WHERE d.id_penj_mkn_min = '$id_penj_mkn_min'";
    
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

function InsertDetailMakanMinum() {
    global $conn;
    
    // Ambil data dari $_POST
    $id_penj_mkn_min = $_POST['id_penj_mkn_min'];
    $id_menu = $_POST['id_menu'];
    $jumlah = $_POST['jumlah']; // Untuk makan minum, jumlah biasanya dinamis (input user)

    // 1. AMBIL DATA HARGA DARI TABEL MENU
    $q_menu = mysqli_query($conn, "SELECT harga FROM menu WHERE id_menu = '$id_menu'");
    $data_m = mysqli_fetch_assoc($q_menu);
    
    if (!$data_m) {
        return 0; // Menu tidak ditemukan
    }

    $harga_satuan = $data_m['harga'];
    $subtotal = $harga_satuan * $jumlah;

    // 2. CEK APAKAH MENU YANG SAMA SUDAH ADA DI DETAIL (Opsional)
    // Jika sudah ada, kita bisa update jumlahnya, jika belum kita insert baru
    $cek_item = mysqli_query($conn, "SELECT * FROM detail_penj_mkn_min 
                                     WHERE id_penj_mkn_min = '$id_penj_mkn_min' 
                                     AND id_menu = '$id_menu'");

    if (mysqli_num_rows($cek_item) > 0) {
        // UPDATE jika item sudah ada di keranjang
        $query_upd = "UPDATE detail_penj_mkn_min 
                      SET jumlah = jumlah + $jumlah, 
                          subtotal = subtotal + $subtotal 
                      WHERE id_penj_mkn_min = '$id_penj_mkn_min' AND id_menu = '$id_menu'";
        $eksekusi = mysqli_query($conn, $query_upd);
    } else {
        // INSERT baru jika item belum ada
        $query_ins = "INSERT INTO detail_penj_mkn_min (id_penj_mkn_min, id_menu, jumlah, harga, subtotal) 
                      VALUES ('$id_penj_mkn_min', '$id_menu', '$jumlah', '$harga_satuan', '$subtotal')";
        $eksekusi = mysqli_query($conn, $query_ins);
    }

    // 3. UPDATE TOTAL HARGA DI TABEL INDUK (penjualan_makan_minum)
    if ($eksekusi) {
        mysqli_query($conn, "UPDATE penjualan_makan_minum 
                             SET total_harga = total_harga + $subtotal 
                             WHERE id_penj_mkn_min = '$id_penj_mkn_min'");
    }

    return mysqli_affected_rows($conn);
}

// Asumsi $conn adalah koneksi mysqli global

function GetDetailMakanMinum($id_penj_mkn_min) {
    global $conn;
    
    // Query mengambil detail makan minum dan nama menu dari tabel menu
    // Mengambil nama menu, harga satuan, jumlah beli, dan subtotal
    $query = "SELECT 
                m.nama AS nama_menu, 
                d.harga, 
                d.jumlah, 
                d.subtotal,
                p.status_selesai
              FROM detail_penj_mkn_min d
              JOIN penjualan_makan_minum p ON d.id_penj_mkn_min = p.id_penj_mkn_min
              JOIN menu m ON d.id_menu = m.id_menu
              WHERE d.id_penj_mkn_min = '$id_penj_mkn_min'";
    
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    return $data;
}

function TotalMakanMinum($id_penj_mkn_min) {
    global $conn;
    
    // Mengambil total harga keseluruhan dari tabel induk penjualan_makan_minum
    $query = "SELECT total_harga FROM penjualan_makan_minum WHERE id_penj_mkn_min = '$id_penj_mkn_min'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    
    return $row['total_harga'] ?? 0;
}

function SelesaiBelanjaMakanMinum($id_penj_mkn_min) {
    global $conn;

    // 1. Ambil total nominal belanja dari detail_penj_mkn_min
    $total = GetTotalMakanMinum($id_penj_mkn_min);
    $tanggal = date('Y-m-d');

    // Validasi: Jika tidak ada item (total 0), jangan selesaikan
    if ($total <= 0) {
        return 0;
    }

    // 2. Update data di tabel penjualan_makan_minum
    // Catatan: Menggunakan nama kolom 'tanggal' sesuai database Anda
    $q_update = "UPDATE penjualan_makan_minum SET
        tanggal = '$tanggal',
        total_harga = $total,
        status_selesai = 'Selesai'
        WHERE id_penj_mkn_min = '$id_penj_mkn_min'";

    mysqli_query($conn, $q_update);

    // Mengembalikan jumlah baris yang berubah (1 jika berhasil, 0 jika gagal)
    return mysqli_affected_rows($conn);
}

function tampil_lap_m($query_laporan) {
    global $conn; 

    $result = mysqli_query($conn, $query_laporan);

    
    if (!$result) {
        echo "<div style='background-color: #A50024; color: white; padding: 10px; margin: 10px; border-radius: 5px; font-weight: bold;'>";
        echo "🚨 ERROR QUERY: " . mysqli_error($conn) . "<br>";
        echo "QUERY GAGAL: <code style='color: yellow;'>" . htmlspecialchars($query_laporan) . "</code>";
        echo "</div>";
        return []; 
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows; 
}

// =========================================================================
// 7. FUNGSI MODUL RETUR BB
// =========================================================================


function isValidReturId($id_retur) {
    global $koneksi;
    $id = mysqli_real_escape_string($koneksi, $id_retur);
    $query = "SELECT COUNT(*) as count FROM retur_pembelian_bahan_baku WHERE id_retur = '$id'";
    $result = mysqli_query($koneksi, $query);
    
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['count'] > 0;
    }
    return false;
}

function tambahData($data) {
    global $koneksi;

    $id_retur     = mysqli_real_escape_string($koneksi, $data['id_retur']);
    $id_bhn_baku  = mysqli_real_escape_string($koneksi, $data['id_bhn_baku']);
    $id_pembelian = mysqli_real_escape_string($koneksi, $data['id_pembelian']);
    $jumlah_retur = $data['jumlah_retur'];
    $keterangan   = mysqli_real_escape_string($koneksi, $data['keterangan']);
    $harga_satuan = $data['harga_satuan'];
    $subtotal     = $jumlah_retur * $harga_satuan;
    $alasan       = mysqli_real_escape_string($koneksi, $data['alasan']);

    $query = "INSERT INTO detail_retur_bahan_baku 
              (id_retur, id_bhn_baku, id_pembelian, jumlah_retur, keterangan, harga_satuan, subtotal, alasan) 
              VALUES 
              ('$id_retur', '$id_bhn_baku', '$id_pembelian', '$jumlah_retur', '$keterangan', '$harga_satuan', '$subtotal', '$alasan')";
    
    return mysqli_query($koneksi, $query);
}

// =========================================================================
// 8. FUNGSI MODUL PEMBELIAN BAHAN BAKU
// =========================================================================

//fungsi transaksi bahan baku
function tambahPembelian($data){
    global $koneksi;

    $id_pembelian = $data["id_pembelian"];
    $id_jurnal = $data["id_jurnal"];
    $tgl_pembelian = $data["tgl_pembelian"];
    $total_harga = $data["total_harga"];

    $query = "INSERT INTO pembelian_bahan_baku
             (id_pembelian, id_jurnal, tgl_pembelian, total_harga)
             VALUES
             ('$id_pembelian', '$id_jurnal', '$tgl_pembelian', '$total_harga')";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// =========================================================================
// 8. FUNGSI MODUL STUDIO
// =========================================================================

function tambah_studio($data){
    global $koneksi;

    $id_studio = $data["id_studio"];
    $kapasitas = $data["kapasitas"];

    $query = "INSERT INTO studio (id_studio, kapasitas)
              VALUES ('$id_studio', '$kapasitas')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}
function ubah_studio($data){
    global $koneksi;

    $id_lama   = $data["id_lama"];  
    $id_baru   = $data["id_studio"]; 
    $kapasitas = $data["kapasitas"];

    $query = "UPDATE studio SET 
                id_studio = '$id_baru',
                kapasitas = '$kapasitas'
              WHERE id_studio = '$id_lama'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

// =========================================================================
// 9. FUNGSI MODUL KURSI
// =========================================================================

function ubah_kursi($data) {
    global $koneksi;

    $id_lama   = $data["id_lama"];    // ID kursi sebelum diubah
    $id_kursi  = $data["id_kursi"];
    $id_studio = $data["id_studio"];
    $no_kursi  = $data["no_kursi"];

    $query = "UPDATE kursi SET 
                id_kursi = '$id_kursi',
                id_studio = '$id_studio',
                no_kursi = '$no_kursi'
              WHERE id_kursi = '$id_lama'";

    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}


function tambah_kursi($data){
    global $koneksi;

    $id_kursi = $data["id_kursi"];
    $id_studio = $data["id_studio"];
    $no_kursi = $data["no_kursi"];

    $query = "INSERT INTO kursi (id_kursi, id_studio, no_kursi)
              VALUES ('$id_kursi','$id_studio', '$no_kursi')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

// =========================================================================
// 9. FUNGSI MODUL Menu
// =========================================================================

function tambah_menu($data){
    global $koneksi;

    $id_menu = mysqli_real_escape_string($koneksi, $data["id_menu"]);
    $jenis   = mysqli_real_escape_string($koneksi, $data["jenis"]);
    $nama    = mysqli_real_escape_string($koneksi, $data["nama"]);
    $harga   = mysqli_real_escape_string($koneksi, $data["harga"]);

    // Pastikan nama tabel adalah 'menu'
    $query = "INSERT INTO menu (id_menu, jenis, nama, harga)
              VALUES ('$id_menu', '$jenis', '$nama', '$harga')";

    mysqli_query($koneksi, $query);
    return mysqli_affected_rows($koneksi);
}

function GenerateIdMenu() { 

    global $conn;
    $query = "SELECT MAX(CAST(SUBSTRING(id_menu, 3, 3) AS UNSIGNED)) AS max_id FROM menu";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
    $next = ($data['max_id'] ?? 0) + 1;
    return 'M' . str_pad($next, 3, '0', STR_PAD_LEFT);

 }

 function tampil_menu($query) {
    global $conn;
    $result = mysqli_query($conn, $query); 
    if (!$result) {
        return []; 
    }

    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    
    return $rows; 
}

function ubahMenu($data){
    global $conn;
    $idMenu=htmlspecialchars($data['id_menu']);
    $nama=htmlspecialchars($data['nama']);
    $jenis=htmlspecialchars($data['jenis']);
    $harga=htmlspecialchars($data['harga']);
    $query = "UPDATE menu SET id_menu='$idMenu', nama='$nama', jenis='$jenis' , harga='$harga' WHERE id_menu='$idMenu'";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

function hapusMenu($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM menu WHERE id_menu='$id'");
    return mysqli_affected_rows($conn);
}

?>