<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/jadwal_servis/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']);

$qSelect = "
   SELECT 
        reservasi.id AS id,
        pelanggan.nama_pelanggan AS nama_pelanggan,
        pelanggan.no_hp AS no_hp_pelanggan,
        mekanik.nama_mekanik AS nama_mekanik,
        layanan.nama_layanan AS nama_layanan,
        layanan.kategori AS kategori_layanan,
        reservasi.tanggal AS tanggal_reservasi,
        reservasi.waktu AS waktu_reservasi,
        reservasi.durasi_minutes AS durasi_reservasi,
        reservasi.status AS status_reservasi,
        reservasi.total_harga AS total_harga_reservasi,
        reservasi.catatan AS catatan_reservasi
    FROM reservasi
    LEFT JOIN pelanggan ON reservasi.pelanggan_id = pelanggan.id
    LEFT JOIN mekanik ON reservasi.mekanik_id = mekanik.id
    LEFT JOIN layanan ON reservasi.layanan_id = layanan.id
    WHERE reservasi.id = $id
    LIMIT 1
";

// Jalankan query
$result = mysqli_query($connect, $qSelect) or die(mysqli_error($connect));

// Ambil data dalam bentuk object
$reservasi = $result->fetch_object();

// Jika data tidak ditemukan
if (!$reservasi) {
    echo "
    <script>
        alert('Data tidak ditemukan');
        window.location.href='../../pages/jadwal_servis/index.php';
    </script>
    ";
    exit;
}
