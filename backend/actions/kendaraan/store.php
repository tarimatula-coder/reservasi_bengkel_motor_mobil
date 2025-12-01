<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data pelanggan untuk dropdown
$qPelanggan = $connect->query("SELECT id, nama FROM pelanggan ORDER BY nama ASC");

// Jika form disubmit
if (isset($_POST['tombol'])) {
    $pelanggan_id = trim($_POST['pelanggan_id']);
    $jenis        = trim($_POST['jenis']);
    $merk         = trim($_POST['merk']);
    $model        = trim($_POST['model']);
    $plat_nomor   = trim($_POST['plat_nomor']);
    $tahun        = trim($_POST['tahun']);
    $catatan      = trim($_POST['catatan']);

    // Validasi field wajib
    if (empty($pelanggan_id) || empty($jenis) || empty($merk) || empty($model) || empty($plat_nomor) || empty($tahun)) {
        echo "<script>alert('Semua field wajib diisi!');</script>";
        exit;
    }

    // Validasi file gambar dulu
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        echo "<script>alert('Silakan pilih gambar kendaraan!');</script>";
        exit;
    }

    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.');</script>";
        exit;
    }

    // Buat nama file unik
    $imageName = time() . "_kendaraan." . $file_ext;

    // Tentukan folder storages
    $storages = "../../../storages/kendaraan/";

    // Pindahkan file ke storages
    if (!move_uploaded_file($file_tmp, $storages . $imageName)) {
        echo "<script>alert('Gagal upload gambar kendaraan!');</script>";
        exit;
    }

    // Setelah file berhasil dipindahkan, simpan data ke database
    $stmt = $connect->prepare("
        INSERT INTO kendaraan (pelanggan_id, jenis, merk, model, plat_nomor, tahun, catatan, image)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->bind_param("isssssss", $pelanggan_id, $jenis, $merk, $model, $plat_nomor, $tahun, $catatan, $imageName);


    if ($stmt->execute()) {
        echo "<script>
                alert('Data kendaraan berhasil ditambahkan!');
                window.location.href='../../pages/kendaraan/index.php';
              </script>";
    } else {
        // Jika gagal insert database, hapus file yang sudah di-upload supaya tidak menganggur
        if (file_exists($storages . $imageName)) {
            unlink($storages . $imageName);
        }
        echo "<script>alert('Gagal menambahkan data kendaraan!');</script>";
    }

    $stmt->close();
}
