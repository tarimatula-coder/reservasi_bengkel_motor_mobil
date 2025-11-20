<?php
include '../../app.php'; // koneksi database

// Pastikan parameter ID tersedia
if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('ID pelanggan tidak ditemukan!');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data dari form
$nama = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validasi input
if ($nama === '' || $no_hp === '' || $alamat === '' || $email === '') {
    echo "
    <script>
        alert('Semua field wajib diisi!');
        window.history.back();
    </script>";
    exit;
}

// Update data mekanik
$queryUpdate = "
    UPDATE pelanggan
    SET 
        nama = '$nama',
        no_hp = '$no_hp',
        alamat = '$alamat',
        email = '$email'
    WHERE id = $id
";

if (mysqli_query($connect, $queryUpdate)) {
    echo "
    <script>
        alert('Data pelanggan berhasil diperbarui!');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
} else {
    echo "
    <script>
        alert('Gagal memperbarui data mekanik: " . mysqli_error($connect) . "');
        window.history.back();
    </script>";
}
