<?php
include '../../app.php';

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
        alert('ID pelanggan tidak ditemukan!');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// cek apakah pelanggan ini dipakai di KENDARAAN
$cekKendaraan = mysqli_query($connect, "SELECT id FROM kendaraan WHERE pelanggan_id = $id LIMIT 1");

if (mysqli_num_rows($cekKendaraan) > 0) {
    echo "<script>
        alert('Tidak bisa hapus! Pelanggan ini masih memiliki data Kendaraan.');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
    exit;
}

// cek apakah pelanggan ini dipakai di RESERVASI
$cekReservasi = mysqli_query($connect, "SELECT id FROM reservasi WHERE pelanggan_id = $id LIMIT 1");

if (mysqli_num_rows($cekReservasi) > 0) {
    echo "<script>
        alert('Tidak bisa hapus! Pelanggan ini masih memiliki Data Reservasi.');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
    exit;
}

// kalau aman → hapus
$q = "DELETE FROM pelanggan WHERE id = $id";
$res = mysqli_query($connect, $q);

if ($res) {
    echo "<script>
        alert('Pelanggan berhasil dihapus!');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
} else {
    $err = mysqli_error($connect);
    echo "<script>
        alert('Gagal hapus pelanggan: $err');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
}
