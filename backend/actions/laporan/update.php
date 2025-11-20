<?php
include '../../app.php'; // koneksi

if (isset($_POST['tombol'])) {

    // ambil id
    $id = intval($_POST['id'] ?? 0);

    // ambil input
    $periode           = trim($_POST['periode'] ?? '');
    $jumlah_reservasi  = trim($_POST['jumlah_reservasi'] ?? '');
    $total_pendapatan  = trim($_POST['total_pendapatan'] ?? '');
    $dibuat_oleh       = trim($_POST['dibuat_oleh'] ?? '');

    // validasi
    if ($id <= 0 || $periode === '' || $jumlah_reservasi === '' || $total_pendapatan === '' || $dibuat_oleh === '') {
        echo "
        <script>
            alert('Semua field wajib diisi!');
            window.history.back();
        </script>";
        exit;
    }

    // query
    $q = "UPDATE laporan SET
            periode = '$periode',
            jumlah_reservasi = '$jumlah_reservasi',
            total_pendapatan = '$total_pendapatan',
            dibuat_oleh = '$dibuat_oleh'
          WHERE id = '$id'";

    if (mysqli_query($connect, $q)) {
        echo "<script>
                alert('Data laporan berhasil diperbarui!');
                window.location.href='../../pages/laporan/index.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal update: " . mysqli_error($connect) . "');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Akses tidak valid!');
            window.location.href='../../pages/laporan/index.php';
          </script>";
}
