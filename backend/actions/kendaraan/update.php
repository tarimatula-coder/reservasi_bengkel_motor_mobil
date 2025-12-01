<?php
include '../../app.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_kendaraan = intval($_POST['id_kendaraan'] ?? 0);

    $pelanggan_id  = intval($_POST['pelanggan_id'] ?? 0);
    $jenis         = escapeString($_POST['jenis'] ?? '');
    $merk          = escapeString($_POST['merk'] ?? '');
    $model         = escapeString($_POST['model'] ?? '');
    $plat_nomor    = escapeString($_POST['plat_nomor'] ?? '');
    $tahun         = escapeString($_POST['tahun'] ?? '');
    $catatan       = escapeString($_POST['catatan'] ?? '');

    // cek ID kendaraan
    if ($id_kendaraan <= 0) {
        echo "<script>alert('ID kendaraan tidak ditemukan'); window.history.back();</script>";
        exit;
    }

    // cek field wajib - catatan BUKAN WAJIB
    if ($pelanggan_id == 0 || $jenis == '' || $merk == '' || $model == '' || $plat_nomor == '' || $tahun == '') {
        echo "<script>alert('Semua field wajib diisi kecuali catatan!'); window.history.back();</script>";
        exit;
    }

    // tentukan folder storage
    $storages = "../../../storages/kendaraan/";

    // ambil data lama untuk gambar
    $qOld = mysqli_query($connect, "SELECT image FROM kendaraan WHERE id = '$id_kendaraan'");
    $oldData = mysqli_fetch_object($qOld);
    $oldImage = $oldData->image ?? '';

    $newImage = $oldImage; // default pakai gambar lama

    // cek jika ada file gambar baru di-upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_ext  = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.'); window.history.back();</script>";
            exit;
        }

        // buat nama file unik
        $newImage = time() . "_kendaraan." . $file_ext;

        // pindahkan file baru
        if (!move_uploaded_file($file_tmp, $storages . $newImage)) {
            echo "<script>alert('Gagal upload gambar baru!'); window.history.back();</script>";
            exit;
        }

        // hapus gambar lama jika ada
        if (!empty($oldImage) && file_exists($storages . $oldImage)) {
            unlink($storages . $oldImage);
        }
    }

    // update data kendaraan termasuk nama file
    $stmt = $connect->prepare("
        UPDATE kendaraan SET
            pelanggan_id = ?,
            jenis        = ?,
            merk         = ?,
            model        = ?,
            plat_nomor   = ?,
            tahun        = ?,
            catatan      = ?,
            image        = ?
        WHERE id = ?
    ");
    $stmt->bind_param("issssissi", $pelanggan_id, $jenis, $merk, $model, $plat_nomor, $tahun, $catatan, $newImage, $id_kendaraan);

    if ($stmt->execute()) {
        echo "<script>
                alert('Data kendaraan berhasil diperbarui!');
                window.location.href='../../pages/kendaraan/index.php';
              </script>";
    } else {
        // hapus gambar baru jika update gagal
        if ($newImage !== $oldImage && file_exists($storages . $newImage)) {
            unlink($storages . $newImage);
        }
        echo "<script>
                alert('Gagal update: " . mysqli_error($connect) . "');
                window.history.back();
              </script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Akses tidak valid!'); window.location.href='../../pages/kendaraan/index.php';</script>";
}
