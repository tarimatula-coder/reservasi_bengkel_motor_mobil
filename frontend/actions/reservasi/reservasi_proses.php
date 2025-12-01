<?php
include '../../app.php';

if (!isset($_POST['tombol'])) {
    echo "<script>alert('Tidak ada data dikirim!');history.back();</script>";
    exit;
}
$pelanggan_id  = trim($_POST['pelanggan_id'] ?? '');
$kendaraan_id  = trim($_POST['kendaraan_id'] ?? '');
$layanan_id    = trim($_POST['layanan_id'] ?? '');
$mekanik_id    = trim($_POST['mekanik_id'] ?? '');
$tanggal       = trim($_POST['tanggal'] ?? '');
$waktu         = trim($_POST['waktu'] ?? '');
$durasi_minutes = trim($_POST['durasi_minutes'] ?? '');
// $status        = trim($_POST['status_reservasi'] ?? '');
$total_harga   = trim($_POST['total_harga'] ?? '');
$catatan       = trim($_POST['catatan'] ?? '');

// Validasi form
if (
    $pelanggan_id === '' || $kendaraan_id === '' || $layanan_id === '' ||
    $mekanik_id === '' || $tanggal === '' || $waktu === '' ||
    $durasi_minutes === '' || $total_harga === ''
) {
    echo "
    <script>
        alert('Semua field WAJIB diisi termasuk kendaraan!');
        window.history.back();
    </script>";
    exit;
}

// Insert ke database
$query = "INSERT INTO reservasi (
        pelanggan_id, kendaraan_id, layanan_id, mekanik_id, 
        tanggal, waktu, durasi_minutes,  total_harga, catatan
    ) VALUES (
        '$pelanggan_id','$kendaraan_id','$layanan_id','$mekanik_id',
        '$tanggal','$waktu','$durasi_minutes','$total_harga','$catatan'
    )
";

if (mysqli_query($connect, $query)) {
    echo "
    <script>
        alert('Data reservasi berhasil ditambahkan!');
        window.location.href='../../pages/reservasi/simpan_reservasi.php';
    </script>";
} else {
    echo "
    <script>
        alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
        window.history.back();
    </script>";
}
