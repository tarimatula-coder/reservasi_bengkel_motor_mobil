<?php
include '../../app.php';

// cek id
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
      alert('ID user tidak ditemukan!');
      window.location.href='../../pages/user/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// hapus user
$q = "DELETE FROM users WHERE id = $id";
$res = mysqli_query($connect, $q);

if ($res) {
    echo "<script>
      alert('User berhasil dihapus!');
      window.location.href='../../pages/user/index.php';
    </script>";
} else {
    $err = mysqli_error($connect);
    echo "<script>
      alert('Gagal hapus user: $err');
      window.location.href='../../pages/user/index.php';
    </script>";
}
