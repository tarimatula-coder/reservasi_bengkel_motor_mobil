<?php
include '../../app.php';

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
        alert('ID layanan tidak ditemukan!');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// ===========================
// 1. Hapus TRANSAKSI dulu
// ===========================
// transaksi → ambil id reservasi yg punya layanan_id ini
$q1 = "DELETE transaksi FROM transaksi
       JOIN reservasi ON transaksi.reservasi_id = reservasi.id
       WHERE reservasi.layanan_id = $id";
mysqli_query($connect, $q1);

// ===========================
// 2. Hapus RESERVASI nya
// ===========================
$q2 = "DELETE FROM reservasi WHERE layanan_id = $id";
mysqli_query($connect, $q2);

// ===========================
// 3. Baru hapus LAYANAN
// ===========================
$q3 = "DELETE FROM layanan WHERE id = $id";
$res = mysqli_query($connect, $q3);

if ($res) {
    echo "<script>
        alert('Layanan & data yang terkait berhasil dihapus!');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>";
} else {
    $err = mysqli_error($connect);
    echo "<script>
        alert('Gagal hapus layanan: $err');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>";
}
