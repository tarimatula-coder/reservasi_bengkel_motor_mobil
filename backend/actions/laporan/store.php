<?php
include '../../app.php';

$periode           = trim($_POST['periode'] ?? '');
$jumlah_reservasi  = trim($_POST['jumlah_reservasi'] ?? '');
$total_pendapatan  = trim($_POST['total_pendapatan'] ?? '');
$dibuat_oleh       = trim($_POST['dibuat_oleh'] ?? '');

// Validasi form (hanya field yg dipakai)
if ($periode === '' || $jumlah_reservasi === '' || $total_pendapatan === '' || $dibuat_oleh === '') {
    echo "
    <script>
        alert('Semua field wajib diisi!');
        window.history.back();
    </script>";
    exit;
}

// Simpan data ke tabel laporan
$query = "INSERT INTO laporan (periode, jumlah_reservasi, total_pendapatan, dibuat_oleh)
          VALUES ('$periode', '$jumlah_reservasi', '$total_pendapatan', '$dibuat_oleh')";

if (mysqli_query($connect, $query)) {
    echo "
    <script>
        alert('Data laporan berhasil ditambahkan!');
        window.location.href='../../pages/laporan/index.php';
    </script>";
} else {
    echo "
    <script>
        alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
        window.history.back();
    </script>";
}
