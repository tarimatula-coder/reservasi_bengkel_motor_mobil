<?php
include '../../app.php';

if (isset($_POST['tombol'])) {

    // ambil id dari form
    $layanan_id = intval($_POST['layanan_id'] ?? 0);

    if ($layanan_id <= 0) {
        echo "<script>alert('ID layanan tidak ditemukan'); window.history.back();</script>";
        exit;
    }

    // Ambil data dari form
    $nama_layanan   = mysqli_real_escape_string($connect, trim($_POST['nama_layanan']));
    $kategori       = mysqli_real_escape_string($connect, trim($_POST['kategori']));
    $durasi_minutes = intval($_POST['durasi_minutes']);
    $harga          = floatval($_POST['harga']);
    $deskripsi      = mysqli_real_escape_string($connect, trim($_POST['deskripsi']));

    // Query update
    $qUpdateLayanan = "UPDATE layanan SET
            nama_layanan='$nama_layanan',
            kategori='$kategori',
            durasi_minutes='$durasi_minutes',
            harga='$harga',
            deskripsi='$deskripsi'
        WHERE id='$layanan_id'";

    if (mysqli_query($connect, $qUpdateLayanan)) {
        echo "<script>
            alert('Data layanan berhasil diperbarui');
            window.location.href='../../pages/layanan_bengkel/index.php';
        </script>";
    } else {
        echo "<script>
            alert('Gagal update: " . mysqli_error($connect) . "');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>alert('Akses tidak valid'); window.location.href='../../pages/layanan_bengkel/index.php';</script>";
}
