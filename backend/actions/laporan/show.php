<?php
include '../../app.php'; // Pastikan koneksi sudah tersedia

if (!isset($_GET['id'])) {
    echo "
    <script>    
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/laporan/index.php';
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
        total_pendapatan,
        dibuat_oleh
    FROM laporan
    WHERE id = $id
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil hasil query dalam bentuk object
$laporan = $result->fetch_object();

// Jika data tidak ditemukan
if (!$laporan) {
    echo "
    <script>    
        alert('Data tidak ditemukan');
        window.location.href='../../pages/laporan/index.php';
    </script>
    ";
    exit;
}
