<?php
include '../../app.php';

if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('Tidak bisa memilih ID ini');
        window.location.href='../../pages/transaksi/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']);

$qSelect = "
   SELECT 
        transaksi.id AS id_transaksi,
        transaksi.reservasi_id,
        transaksi.tipe_pembayaran,
        transaksi.nominal,
        transaksi.tanggal_pembayaran,
        transaksi.status AS status_transaksi,
        transaksi.bukti_transfer,
        reservasi.tanggal AS tanggal_reservasi,
        reservasi.waktu AS waktu_reservasi,
        reservasi.total_harga,
        pelanggan.nama AS nama_pelanggan,
        layanan.nama_layanan AS nama_layanan,
        mekanik.nama AS nama_mekanik
    FROM transaksi
    LEFT JOIN reservasi ON transaksi.reservasi_id = reservasi.id
    LEFT JOIN pelanggan ON reservasi.pelanggan_id = pelanggan.id
    LEFT JOIN layanan ON reservasi.layanan_id = layanan.id
    LEFT JOIN mekanik ON reservasi.mekanik_id = mekanik.id
    WHERE transaksi.id = $id
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
        window.location.href='../../pages/reservasi/index.php';
    </script>
    ";
    exit;
}
