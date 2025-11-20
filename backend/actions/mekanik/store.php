<?php
include '../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil semua input dengan aman
    $user_id = intval($_POST['user_id']);
    $nama = $connect->real_escape_string($_POST['nama']);
    $skill = $connect->real_escape_string($_POST['skill']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $is_available = intval($_POST['is_available']);

    // Validasi wajib
    if ($user_id == 0 || $is_available === '') {
        echo "<script>
                alert('User ID dan Status Ketersediaan tidak boleh kosong!');
                window.history.back();
              </script>";
        exit;
    }

    // Query insert data mekanik
    $query = "
        INSERT INTO mekanik (user_id, nama, skill, phone, is_available)
        VALUES ('$user_id', '$nama', '$skill', '$phone', '$is_available')
    ";

    if ($connect->query($query)) {
        echo "<script>
                alert('Data mekanik berhasil ditambahkan!');
                window.location.href='../../pages/mekanik/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan: " . $connect->error . "');
                window.history.back();
              </script>";
    }
}
