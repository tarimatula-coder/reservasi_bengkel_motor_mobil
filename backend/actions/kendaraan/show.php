<?php
include '../../app.php'; // Pastikan koneksi sudah tersedia

if (!isset($_GET['id'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/kendaraan/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); // Amankan ID dari GET

// Query dengan alias yang konsisten dan WHERE id
$qSelect = "SELECT 
        k.id AS kendaraan_id,
        k.pelanggan_id,
        k.jenis,
        k.merk,
        k.model,
        k.plat_nomor,
        k.tahun,
        k.catatan AS catatan_kendaraan,
        p.nama AS nama_pelanggan,
        p.no_hp,
        p.alamat,
        p.email,
        r.tanggal,
        r.waktu,
        r.durasi_minutes,
        r.status,
        r.total_harga,
        r.catatan AS catatan_reservasi
    FROM kendaraan k
    LEFT JOIN pelanggan p ON p.id = k.pelanggan_id
    LEFT JOIN reservasi r ON r.kendaraan_id = k.id
    WHERE k.id = '$id'
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil hasil query dalam bentuk object
$kendaraan = $result->fetch_object();

// Jika data tidak ditemukan
if (!$kendaraan) {
    echo "
    <script>    
        alert('Data tidak ditemukan');
        window.location.href='../../pages/kendaraan/index.php';
    </script>
    ";
    exit;
}
