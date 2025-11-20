<?php
include '../../app.php'; // koneksi

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid!');window.location.href='../../pages/user/index.php';</script>";
    exit;
}

$id         = intval($_POST['id']);
$user_id   = mysqli_real_escape_string($connect, $_POST['user_id']);
$action      = mysqli_real_escape_string($connect, $_POST['action']);
$object_type   = mysqli_real_escape_string($connect, $_POST['object_type']);
$object_id       = mysqli_real_escape_string($connect, $_POST['object_id']);
$message  = mysqli_real_escape_string($connect, $_POST['message']);

if (
    empty($id) || empty($user_id) || empty($object_type) || empty($object_id) ||
    empty($message) || empty($action) 
) {
    echo "<script>alert('Semua field wajib diisi!');history.back();</script>";
    exit;
}

// update data
$query = " UPDATE audit_logs SET
        user_id='$user_id',
        action='$action',
        object_type='$object_type',
        object_id='$object_id',
        message='$message'
    WHERE id='$id'
";

if (mysqli_query($connect, $query)) {
    echo "<script>
        alert('User berhasil diperbarui!');
        window.location.href='../../pages/audit_logs/index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal update audit_logs: " . mysqli_error($connect) . "');
        history.back();
    </script>";
}
