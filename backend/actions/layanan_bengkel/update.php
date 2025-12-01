<?php
include '../../app.php';

if (isset($_POST['tombol'])) {

    // ambil id dari form
    $layanan_id = intval($_POST['layanan_id'] ?? 0);

    if ($layanan_id <= 0) {
        echo "<script>alert('ID layanan tidak ditemukan'); window.history.back();</script>";
        exit;
    }

    // Ambil data dari form
    $nama_layanan   = mysqli_real_escape_string($connect, trim($_POST['nama_layanan']));
    $kategori       = mysqli_real_escape_string($connect, trim($_POST['kategori']));
    $durasi_minutes = intval($_POST['durasi_minutes']);
    $harga          = floatval($_POST['harga']);
    $deskripsi      = mysqli_real_escape_string($connect, trim($_POST['deskripsi']));

    // Ambil nama file lama dari database
    $qOld = mysqli_query($connect, "SELECT image FROM layanan WHERE id='$layanan_id' LIMIT 1");
    $oldData = mysqli_fetch_assoc($qOld);
    $oldImage = $oldData['image'] ?? '';

    $imageName = $oldImage; // default pakai file lama

    // Jika ada file baru yang di-upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.'); window.history.back();</script>";
            exit;
        }

        // Buat nama file baru
        $imageName = time() . "_layanan." . $file_ext;

        $storages = "../../../storages/layanan/";

        // Pindahkan file ke storages
        if (!move_uploaded_file($file_tmp, $storages . $imageName)) {
            echo "<script>alert('Gagal upload gambar baru!'); window.history.back();</script>";
            exit;
        }

        // Hapus gambar lama jika ada
        if ($oldImage && file_exists($storages . $oldImage)) {
            unlink($storages . $oldImage);
        }
    }

    // Query update
    $qUpdateLayanan = "UPDATE layanan SET
            nama_layanan='$nama_layanan',
            kategori='$kategori',
            durasi_minutes='$durasi_minutes',
            harga='$harga',
            deskripsi='$deskripsi',
            image='$imageName'
        WHERE id='$layanan_id'";

    if (mysqli_query($connect, $qUpdateLayanan)) {
        echo "<script>
            alert('Data layanan berhasil diperbarui');
            window.location.href='../../pages/layanan_bengkel/index.php';
        </script>";
    } else {
        // Jika gagal, hapus file baru kalau ada
        if ($imageName != $oldImage && file_exists($storages . $imageName)) {
            unlink($storages . $imageName);
        }
        echo "<script>
            alert('Gagal update: " . mysqli_error($connect) . "');
            window.history.back();
        </script>";
    }
} else {
    echo "<script>alert('Akses tidak valid'); window.location.href='../../pages/layanan_bengkel/index.php';</script>";
}
