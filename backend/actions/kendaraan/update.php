<?php
include '../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_kendaraan = intval($_POST['id_kendaraan'] ?? 0);

    $pelanggan_id  = intval($_POST['pelanggan_id'] ?? 0);
    $jenis         = escapeString($_POST['jenis'] ?? '');
    $merk          = escapeString($_POST['merk'] ?? '');
    $model         = escapeString($_POST['model'] ?? '');
    $plat_nomor    = escapeString($_POST['plat_nomor'] ?? '');
    $tahun         = escapeString($_POST['tahun'] ?? '');
    $catatan       = escapeString($_POST['catatan'] ?? '');

    // cek ID kendaraan
    if ($id_kendaraan <= 0) {
        echo "<script>alert('ID kendaraan tidak ditemukan'); window.history.back();</script>";
        exit;
    }

    // cek field wajib - catatan BUKAN WAJIB
    if ($pelanggan_id == 0 || $jenis == '' || $merk == '' || $model == '' || $plat_nomor == '' || $tahun == '') {
        echo "<script>alert('Semua field wajib diisi kecuali catatan!'); window.history.back();</script>";
        exit;
    }

    $q = "UPDATE kendaraan SET
            pelanggan_id = '$pelanggan_id',
            jenis        = '$jenis',
            merk         = '$merk',
            model        = '$model',
            plat_nomor   = '$plat_nomor',
            tahun        = '$tahun',
            catatan      = '$catatan'
          WHERE id = '$id_kendaraan'";

    if (mysqli_query($connect, $q)) {
        echo "<script>
                alert('Data kendaraan berhasil diperbarui!');
                window.location.href='../../pages/kendaraan/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update: " . mysqli_error($connect) . "');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>alert('Akses tidak valid!'); window.location.href='../../pages/kendaraan/index.php';</script>";
}
