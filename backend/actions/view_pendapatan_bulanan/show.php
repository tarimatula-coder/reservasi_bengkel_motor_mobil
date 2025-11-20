<?php
include '../../app.php'; // Pastikan koneksi sudah tersedia

if (!isset($_GET['id'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/view_pendapatan_bulanan/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); // Amankan ID dari GET

// Query dengan alias yang konsisten dan WHERE id
$qSelect = "
SELECT 
        id,
        periode,
        jumlah_reservasi,
        total_pendapatan
    FROM view_pendapatan_bulanan
    WHERE id = $id
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil hasil query dalam bentuk object
$view_pendapatan_bulanan = $result->fetch_object();

// Jika data tidak ditemukan
if (!$view_pendapatan_bulanan) {
    echo "
    <script>    
        alert('Data tidak ditemukan');
        window.location.href='../../pages/view_pendapatan_bulanan/index.php';
    </script>
    ";
    exit;
}
