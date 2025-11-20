<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']); // Amankan nilai ID agar hanya angka

// Query untuk ambil detail layanan + reservasi yang terkait
$qSelect = "
    SELECT 
        mekanik.id AS id_mekanik,
        mekanik.user_id,
        mekanik.nama,
        mekanik.skill,
        mekanik.phone
    FROM mekanik
    LEFT JOIN reservasi
        ON reservasi.mekanik_id = mekanik.id
    WHERE mekanik.id = $id
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil data dalam bentuk object
$mekanik = $result->fetch_object();

// Jika data tidak ditemukan
if (!$mekanik) {
    echo "
    <script>
        alert('Data tidak ditemukan');
        window.location.href='../../pages/mekanik/index.php';
    </script>
    ";
    exit;
}
