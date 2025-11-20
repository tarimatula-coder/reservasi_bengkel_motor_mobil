<?php
include '../../app.php'; // Pastikan koneksi database sudah tersedia

// Cek apakah ada parameter ID yang dikirim lewat URL
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
        layanan.id AS layanan_id,
        layanan.nama_layanan,
        layanan.kategori,
        layanan.durasi_minutes AS durasi_layanan,
        layanan.harga AS harga_layanan,
        layanan.deskripsi,
        reservasi.tanggal,
        reservasi.waktu,
        reservasi.durasi_minutes AS durasi_reservasi,
        reservasi.status,
        reservasi.total_harga,
        reservasi.catatan AS catatan_reservasi
    FROM layanan
    LEFT JOIN reservasi
        ON reservasi.layanan_id = layanan.id
    WHERE layanan.id = $id
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil data dalam bentuk object
$layanan = $result->fetch_object();

// Jika data tidak ditemukan
if (!$layanan) {
    echo "
    <script>
        alert('Data tidak ditemukan');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>
    ";
    exit;
}
