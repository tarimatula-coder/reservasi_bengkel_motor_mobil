<?php
include '../../../config/connection.php'; // pastikan path koneksi benar

// Pastikan form dikirim dengan tombol submit
if (isset($_POST['tombol'])) {

    // Ambil data dari form dan lakukan sanitasi
    $nama_layanan = mysqli_real_escape_string($connect, trim($_POST['nama_layanan']));
    $kategori = mysqli_real_escape_string($connect, trim($_POST['kategori']));
    $durasi_minutes = intval($_POST['durasi_minutes']); // pastikan angka
    $harga = floatval($_POST['harga']); // ubah jadi angka (boleh desimal)
    $deskripsi = mysqli_real_escape_string($connect, trim($_POST['deskripsi']));

    // Validasi sederhana
    if (empty($nama_layanan) || empty($kategori) || empty($durasi_minutes) || empty($harga) || empty($deskripsi)) {
        echo "
        <script>
            alert('Semua kolom wajib diisi!');
            window.history.back();
        </script>
        ";
        exit;
    }

    // Query simpan ke database
    $query = "INSERT INTO layanan (nama_layanan, kategori, durasi_minutes, harga, deskripsi)
        VALUES ('$nama_layanan', '$kategori', '$durasi_minutes', '$harga', '$deskripsi')
    ";

    // Eksekusi query
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "
        <script>
            alert('Data layanan berhasil ditambahkan!');
            window.location.href='../../pages/layanan_bengkel/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
            window.history.back();
        </script>
        ";
    }
} else {
    // Jika tidak ada tombol yang dikirim
    echo "
    <script>
        alert('Akses tidak valid!');
        window.location.href='../../pages/layanan_bengkel/index.php';
    </script>
    ";
}
