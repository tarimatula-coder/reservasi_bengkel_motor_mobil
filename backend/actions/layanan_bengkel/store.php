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

    // Validasi field wajib
    if (empty($nama_layanan) || empty($kategori) || empty($durasi_minutes) || empty($harga) || empty($deskripsi)) {
        echo "
        <script>
            alert('Semua kolom wajib diisi!');
            window.history.back();
        </script>";
        exit;
    }

    // Validasi file gambar
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        echo "<script>
                alert('Silakan pilih gambar layanan!');
                window.history.back();
              </script>";
        exit;
    }

    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>
                alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.');
                window.history.back();
              </script>";
        exit;
    }

    // Buat nama file unik
    $imageName = time() . "_layanan." . $file_ext;

    // Tentukan folder storages
    $storages = "../../../storages/layanan/";

    // Pindahkan file ke folder storages
    if (!move_uploaded_file($file_tmp, $storages . $imageName)) {
        echo "<script>
                alert('Gagal upload gambar layanan!');
                window.history.back();
              </script>";
        exit;
    }

    // Query simpan ke database termasuk nama file
    $query = "INSERT INTO layanan (nama_layanan, kategori, durasi_minutes, harga, deskripsi, image)
              VALUES ('$nama_layanan', '$kategori', '$durasi_minutes', '$harga', '$deskripsi', '$imageName')";

    // Eksekusi query
    $result = mysqli_query($connect, $query);

    if ($result) {
        echo "<script>
                alert('Data layanan berhasil ditambahkan!');
                window.location.href='../../pages/layanan_bengkel/index.php';
              </script>";
    } else {
        // Hapus file yang sudah di-upload jika query gagal
        if (file_exists($storages . $imageName)) {
            unlink($storages . $imageName);
        }
        echo "<script>
                alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
                window.history.back();
              </script>";
    }
} else {
    echo "<script>
            alert('Akses tidak valid!');
            window.location.href='../../pages/layanan_bengkel/index.php';
          </script>";
}
