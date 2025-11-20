<?php
include '../../app.php';

if (isset($_POST['tombol'])) {

    $id             = intval($_POST['id'] ?? 0);
    $pelanggan_id   = intval($_POST['pelanggan_id'] ?? 0);
    $kendaraan_id   = intval($_POST['kendaraan_id'] ?? 0); // <-- tambah ini
    $layanan_id     = intval($_POST['layanan_id'] ?? 0);
    $mekanik_id     = intval($_POST['mekanik_id'] ?? 0);
    $tanggal        = mysqli_real_escape_string($connect, trim($_POST['tanggal'] ?? ''));
    $waktu          = mysqli_real_escape_string($connect, trim($_POST['waktu'] ?? ''));
    $durasi_minutes = intval($_POST['durasi_minutes'] ?? 0);
    $status         = mysqli_real_escape_string($connect, trim($_POST['status'] ?? ''));
    $total_harga    = floatval($_POST['total_harga'] ?? 0);
    $catatan        = mysqli_real_escape_string($connect, trim($_POST['catatan'] ?? ''));

    if ($id <= 0) {
        echo "<script>alert('ID Reservasi tidak valid!'); window.history.back();</script>";
        exit;
    }

    // UPDATE
    $q = "
UPDATE reservasi SET
    pelanggan_id   = '$pelanggan_id',
    kendaraan_id   = '$kendaraan_id',     -- <-- tambah ini
    layanan_id     = '$layanan_id',
    mekanik_id     = '$mekanik_id',
    tanggal        = '$tanggal',
    waktu          = '$waktu',
    durasi_minutes = '$durasi_minutes',
    status         = '$status',
    total_harga    = '$total_harga',
    catatan        = '$catatan'
WHERE id = '$id'
";

    if (mysqli_query($connect, $q)) {
        echo "<script>alert('Berhasil update reservasi'); window.location.href='../../pages/reservasi/index.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . mysqli_error($connect) . "'); window.history.back();</script>";
    }
}
