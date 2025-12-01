<?php
include '../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil semua input dengan aman
    $user_id = intval($_POST['user_id']);
    $nama = $connect->real_escape_string($_POST['nama']);
    $skill = $connect->real_escape_string($_POST['skill']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $is_available = intval($_POST['is_available']);

    // Validasi wajib
    if ($user_id == 0 || $is_available === '') {
        echo "<script>
                alert('User ID dan Status Ketersediaan tidak boleh kosong!');
                window.history.back();
              </script>";
        exit;
    }

    // Validasi file gambar
    if (!isset($_FILES['image']) || $_FILES['image']['error'] != 0) {
        echo "<script>alert('Silakan pilih gambar mekanik!'); window.history.back();</script>";
        exit;
    }

    $file_tmp = $_FILES['image']['tmp_name'];
    $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.'); window.history.back();</script>";
        exit;
    }

    // Buat nama file unik
    $imageName = time() . "_mekanik." . $file_ext;

    // Tentukan folder storages
    $storages = "../../../storages/mekanik/";

    // Pindahkan file ke folder storages
    if (!move_uploaded_file($file_tmp, $storages . $imageName)) {
        echo "<script>alert('Gagal upload gambar mekanik!'); window.history.back();</script>";
        exit;
    }

    // Query insert data mekanik termasuk nama file image
    $query = "
        INSERT INTO mekanik (user_id, nama, skill, phone, is_available, image)
        VALUES ('$user_id', '$nama', '$skill', '$phone', '$is_available', '$imageName')
    ";

    if ($connect->query($query)) {
        echo "<script>
                alert('Data mekanik berhasil ditambahkan!');
                window.location.href='../../pages/mekanik/index.php';
              </script>";
    } else {
        // Jika gagal insert, hapus gambar yang sudah di-upload
        if (file_exists($storages . $imageName)) {
            unlink($storages . $imageName);
        }
        echo "<script>
                alert('Terjadi kesalahan: " . $connect->error . "');
                window.history.back();
              </script>";
    }
}
