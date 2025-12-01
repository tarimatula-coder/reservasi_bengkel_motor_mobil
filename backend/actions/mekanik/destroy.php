<?php
include '../../app.php';

// cek id mekanik
if (!isset($_GET['id']) || $_GET['id'] == '') {
    echo "<script>
        alert('ID Mekanik tidak ditemukan!');
        window.location.href='../../pages/mekanik/index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// cek apakah mekanik dipakai di tabel reservasi
$cek = mysqli_query($connect, "
    SELECT id 
    FROM reservasi 
    WHERE mekanik_id = $id 
    LIMIT 1
");

if (mysqli_num_rows($cek) > 0) {
    echo "<script>
        alert('Tidak bisa hapus! Mekanik ini masih dipakai di Data Reservasi.');
        window.location.href='../../pages/mekanik/index.php';
    </script>";
    exit;
}

// ambil nama file image mekanik sebelum dihapus
$qImage = mysqli_query($connect, "SELECT image FROM mekanik WHERE id = $id LIMIT 1");
$imageName = '';
if ($qImage && mysqli_num_rows($qImage) > 0) {
    $row = mysqli_fetch_assoc($qImage);
    $imageName = $row['image'];
}

// jika aman → hapus mekanik
$query = "DELETE FROM mekanik WHERE id = $id";
$result = mysqli_query($connect, $query);

if ($result) {
    // hapus file image dari storages jika ada
    $storages = "../../storages/mekanik/";
    if ($imageName && file_exists($storages . $imageName)) {
        unlink($storages . $imageName);
    }

    echo "<script>
        alert('Mekanik berhasil dihapus!');
        window.location.href='../../pages/mekanik/index.php';
    </script>";
} else {
    $err = mysqli_error($connect);
    echo "<script>
        alert('Gagal hapus mekanik: $err');
        window.location.href='../../pages/mekanik/index.php';
    </script>";
}
