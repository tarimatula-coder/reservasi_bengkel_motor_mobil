<?php
include '../../app.php'; // koneksi database

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $pelanggan_id = trim($_POST['pelanggan_id']);
    $jenis        = trim($_POST['jenis']);
    $merk         = trim($_POST['merk']);
    $model        = trim($_POST['model']);
    $plat_nomor   = trim($_POST['plat_nomor']);
    $tahun        = trim($_POST['tahun']);
    $catatan      = trim($_POST['catatan']);

    // Validasi sederhana
    if (
        empty($pelanggan_id) || empty($jenis) || empty($merk) ||
        empty($model) || empty($plat_nomor) || empty($tahun)
    ) {
        echo "
        <script>
            alert('Semua field wajib diisi!');
            window.history.back();
        </script>";
        exit;
    }

    // Simpan ke database
    $query = $connect->prepare("
        INSERT INTO kendaraan (pelanggan_id, jenis, merk, model, plat_nomor, tahun, catatan)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $query->bind_param('issssis', $pelanggan_id, $jenis, $merk, $model, $plat_nomor, $tahun, $catatan);

    if ($query->execute()) {
        echo "
        <script>
            alert('Data kendaraan berhasil ditambahkan!');
            window.location.href='../../pages/kendaraan/index.php';
        </script>";
    } else {
        echo "
        <script>
            alert('Gagal menambahkan data kendaraan!');
            window.history.back();
        </script>";
    }

    $query->close();
} else {
    echo "
    <script>
        alert('Akses tidak valid!');
        window.location.href='../../pages/kendaraan/index.php';
    </script>";
}
