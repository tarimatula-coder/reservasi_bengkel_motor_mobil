<?php
include '../../app.php';

$storages = "../../../storages/bukti_transfer/";

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
  echo "<script>
      alert('ID transaksi tidak ditemukan!');
      window.location.href='../../pages/transaksi/index.php';
    </script>";
  exit;
}

$id = intval($_GET['id']);

// ambil data transaksi dulu
$qSelect = "SELECT * FROM transaksi WHERE id = $id";
$resSelect = mysqli_query($connect, $qSelect);

if ($resSelect && mysqli_num_rows($resSelect) > 0) {
  $transaksi = mysqli_fetch_object($resSelect);

  // hapus file bukti transfer jika ada
  if (!empty($transaksi->bukti_transfer) && file_exists($storages . $transaksi->bukti_transfer)) {
    unlink($storages . $transaksi->bukti_transfer);
  }

  // hapus data transaksi
  $qDelete = "DELETE FROM transaksi WHERE id = $id";
  $resDelete = mysqli_query($connect, $qDelete);

  if ($resDelete) {
    echo "<script>
            alert('Transaksi berhasil dihapus!');
            window.location.href='../../pages/transaksi/index.php';
        </script>";
  } else {
    $err = mysqli_error($connect);
    echo "<script>
            alert('Gagal hapus transaksi: $err');
            window.location.href='../../pages/transaksi/index.php';
        </script>";
  }
} else {
  echo "<script>
        alert('Data transaksi tidak ditemukan!');
        window.location.href='../../pages/transaksi/index.php';
    </script>";
}
