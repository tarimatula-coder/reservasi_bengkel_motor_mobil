<?php
include '../../app.php';

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
  echo "<script>
      alert('ID kendaraan tidak ditemukan!');
      window.location.href='../../pages/kendaraan/index.php';
  </script>";
  exit;
}

$id = intval($_GET['id']);

// cek apakah kendaraan ini dipakai di reservasi
$cek = mysqli_query($connect, "SELECT id FROM reservasi WHERE kendaraan_id = $id LIMIT 1");

if (mysqli_num_rows($cek) > 0) {
  echo "<script>
      alert('Tidak bisa hapus! Kendaraan ini masih dipakai di Data Reservasi.');
      window.location.href='../../pages/kendaraan/index.php';
  </script>";
  exit;
}

// kalau aman → baru hapus kendaraan
$q = "DELETE FROM kendaraan WHERE id = $id";
$res = mysqli_query($connect, $q);

if ($res) {
  echo "<script>
      alert('Kendaraan berhasil dihapus!');
      window.location.href='../../pages/kendaraan/index.php';
  </script>";
} else {
  $err = mysqli_error($connect);
  echo "<script>
      alert('Gagal hapus kendaraan: $err');
      window.location.href='../../pages/kendaraan/index.php';
  </script>";
}
