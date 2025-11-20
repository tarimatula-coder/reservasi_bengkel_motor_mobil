<?php
include '../../app.php';

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
        alert('ID reservasi tidak ditemukan!');
        window.location.href='../../pages/reservasi/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// CEK apakah reservasi digunakan di TRANSAKSI
$cekTransaksi = mysqli_query(
    $connect,
    "SELECT id FROM transaksi WHERE reservasi_id = $id LIMIT 1"
);

if (mysqli_num_rows($cekTransaksi) > 0) {
    echo "<script>
        alert('Tidak bisa menghapus! Reservasi ini sudah memiliki Data Transaksi.');
        window.location.href='../../pages/reservasi/index.php';
    </script>";
    exit;
}

// Jika aman → hapus reservasi
$q = "DELETE FROM reservasi WHERE id = $id";
$res = mysqli_query($connect, $q);

if ($res) {
    echo "<script>
        alert('Reservasi berhasil dihapus!');
        window.location.href='../../pages/reservasi/index.php';
    </script>";
} else {
    $err = mysqli_error($connect);
    echo "<script>
        alert('Gagal menghapus reservasi: $err');
        window.location.href='../../pages/reservasi/index.php';
    </script>";
}
