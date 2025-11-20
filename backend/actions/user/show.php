<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/user/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); // Amankan nilai ID agar hanya angka

// Query untuk ambil detail layanan + reservasi yang terkait
$qSelect = "
    SELECT 
        user.id AS id_user,
        user.username,
        user.password,
        user.role,
        user.full_name,
        user.phone,
        user.email,
        user.is_active
    FROM user
    WHERE user.id = $id
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil data dalam bentuk object
$user = $result->fetch_object();

// Jika data tidak ditemukan
if (!$user) {
    echo "
    <script>
        alert('Data tidak ditemukan');
        window.location.href='../../pages/user/index.php';
    </script>
    ";
    exit;
}
