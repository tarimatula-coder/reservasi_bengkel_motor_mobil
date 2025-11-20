<?php
include '../../app.php';

// pastikan ini POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Tidak ada data dikirim!');history.back();</script>";
    exit;
}

// ambil input
$username   = mysqli_real_escape_string($connect, $_POST['username']);
$password   = mysqli_real_escape_string($connect, $_POST['password']);
$role       = mysqli_real_escape_string($connect, $_POST['role']);
$full_name  = mysqli_real_escape_string($connect, $_POST['full_name']);
$phone      = mysqli_real_escape_string($connect, $_POST['phone']);
$email      = mysqli_real_escape_string($connect, $_POST['email']);
$is_active  = mysqli_real_escape_string($connect, $_POST['is_active']);

// HASH PASSWORD
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// INSERT
$query = "INSERT INTO users 
(username, password, role, full_name, phone, email, is_active)
VALUES
('$username', '$hashed_password', '$role', '$full_name', '$phone', '$email', '$is_active')";

$insert = mysqli_query($connect, $query);

if ($insert) {
    echo "<script>
        alert('User berhasil ditambahkan!');
        window.location.href='../../pages/user/index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal menambah user! cek ulang input / query');
        history.back();
    </script>";
}
