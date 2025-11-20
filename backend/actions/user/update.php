<?php
include '../../app.php'; // koneksi

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "<script>alert('Akses tidak valid!');window.location.href='../../pages/user/index.php';</script>";
    exit;
}

$id         = intval($_POST['id']);
$username   = mysqli_real_escape_string($connect, $_POST['username']);
$password   = trim($_POST['password']); // password bisa kosong jika tidak diubah
$role       = mysqli_real_escape_string($connect, $_POST['role']);
$full_name  = mysqli_real_escape_string($connect, $_POST['full_name']);
$phone      = mysqli_real_escape_string($connect, $_POST['phone']);
$email      = mysqli_real_escape_string($connect, $_POST['email']);
$is_active  = mysqli_real_escape_string($connect, $_POST['is_active']);

// validasi wajib isi (password boleh kosong untuk tidak diubah)
if (
    empty($id) || empty($username) || empty($role) ||
    empty($full_name) || empty($phone) || empty($email) || $is_active === ""
) {
    echo "<script>alert('Semua field wajib diisi kecuali password jika tidak ingin diubah!');history.back();</script>";
    exit;
}

// Jika password diisi, hash dulu
$updatePasswordSQL = '';
if (!empty($password)) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $updatePasswordSQL = ", password='$hashed_password'";
}

// update data
$query = "
    UPDATE users SET
        username='$username'
        $updatePasswordSQL,
        role='$role',
        full_name='$full_name',
        phone='$phone',
        email='$email',
        is_active='$is_active'
    WHERE id='$id'
";

if (mysqli_query($connect, $query)) {
    echo "<script>
        alert('User berhasil diperbarui!');
        window.location.href='../../pages/user/index.php';
    </script>";
} else {
    echo "<script>
        alert('Gagal update user: " . mysqli_error($connect) . "');
        history.back();
    </script>";
}
