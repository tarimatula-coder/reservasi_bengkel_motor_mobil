<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/pelanggan/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); 

$qSelect = "
    SELECT 
        pelanggan.id AS id_pelanggan,
        pelanggan.nama,
        pelanggan.no_hp,
        pelanggan.alamat,
        pelanggan.email
    FROM pelanggan
    LEFT JOIN reservasi
        ON reservasi.pelanggan_id = pelanggan.id
    WHERE pelanggan.id = $id
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil data dalam bentuk object
$pelanggan = $result->fetch_object();

// Jika data tidak ditemukan
if (!$pelanggan) {
    echo "
    <script>
        alert('Data tidak ditemukan');
        window.location.href='../../pages/pelanggan/index.php';
    </script>
    ";
    exit;
}
