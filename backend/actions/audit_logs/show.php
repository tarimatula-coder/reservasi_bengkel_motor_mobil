<?php
include '../../app.php'; // Pastikan koneksi sudah tersedia

if (!isset($_GET['id'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/audit_logs/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); // Amankan ID dari GET

// Query dengan alias yang konsisten dan WHERE id
$qSelect = "
SELECT 
        user_id,
        action,
        object_type,
        object_id,
        message
    FROM audit_logs
    WHERE id = $id
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil hasil query dalam bentuk object
$audit_logs = $result->fetch_object();

// Jika data tidak ditemukan
if (!$audit_logs) {
    echo "
    <script>    
        alert('Data tidak ditemukan');
        window.location.href='../../pages/audit_logs/index.php';
    </script>
    ";
    exit;
}
