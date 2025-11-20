<?php
include '../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id']);
    $user_id = intval($_POST['user_id']);
    $nama = $connect->real_escape_string($_POST['nama']);
    $skill = $connect->real_escape_string($_POST['skill']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $is_available = intval($_POST['is_available']);

    $query = "
        UPDATE mekanik
        SET 
            user_id = '$user_id',
            nama = '$nama',
            skill = '$skill',
            phone = '$phone',
            is_available = '$is_available'
        WHERE id = $id
    ";

    if ($connect->query($query)) {
        echo "<script>
                alert('Data mekanik berhasil diperbarui!');
                window.location.href='../../pages/mekanik/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui: " . $connect->error . "');
                window.history.back();
              </script>";
    }
}
