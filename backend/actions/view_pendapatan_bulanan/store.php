<?php
include '../../app.php';

$periode           = trim($_POST['periode'] ?? '');
$jumlah_reservasi  = trim($_POST['jumlah_reservasi'] ?? '');
$total_pendapatan  = trim($_POST['total_pendapatan'] ?? '');

// Validasi form (hanya field yg dipakai)
if ($periode === '' || $jumlah_reservasi === '' || $total_pendapatan === '' ) {
    echo "
    <script>
        alert('Semua field wajib diisi!');
        window.history.back();
    </script>";
    exit;
}

// Simpan data ke tabel laporan
$query = "INSERT INTO laporan (periode, jumlah_reservasi, total_pendapatan)
          VALUES ('$periode', '$jumlah_reservasi', '$total_pendapatan')";

if (mysqli_query($connect, $query)) {
    echo "
    <script>
        alert('Data laporan berhasil ditambahkan!');
        window.location.href='../../pages/view_pendapatan_bulanan/index.php';
    </script>";
} else {
    echo "
    <script>
        alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
        window.history.back();
    </script>";
}
