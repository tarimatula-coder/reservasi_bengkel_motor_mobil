<?php
include '../../../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = intval($_POST['id']);
    $user_id = intval($_POST['user_id']);
    $nama = $connect->real_escape_string($_POST['nama']);
    $skill = $connect->real_escape_string($_POST['skill']);
    $phone = $connect->real_escape_string($_POST['phone']);
    $is_available = intval($_POST['is_available']);

    // Ambil image lama dari database
    $qOldImage = $connect->query("SELECT image FROM mekanik WHERE id = $id LIMIT 1");
    $oldImage = '';
    if ($qOldImage && $qOldImage->num_rows > 0) {
        $row = $qOldImage->fetch_assoc();
        $oldImage = $row['image'];
    }

    $imageName = $oldImage; // default tetap image lama

    // Jika user upload file baru
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_ext)) {
            echo "<script>alert('Format gambar tidak diperbolehkan. Hanya jpg, jpeg, png, gif.'); window.history.back();</script>";
            exit;
        }

        // Buat nama file unik
        $imageName = time() . "_mekanik." . $file_ext;
        $storages = "../../../storages/mekanik/";

        // Pindahkan file baru
        if (!move_uploaded_file($file_tmp, $storages . $imageName)) {
            echo "<script>alert('Gagal upload gambar baru!'); window.history.back();</script>";
            exit;
        }

        // Hapus file lama jika ada
        if ($oldImage && file_exists($storages . $oldImage)) {
            unlink($storages . $oldImage);
        }
    }

    // Update database
    $query = "
        UPDATE mekanik
        SET 
            user_id = '$user_id',
            nama = '$nama',
            skill = '$skill',
            phone = '$phone',
            is_available = '$is_available',
            image = '$imageName'
        WHERE id = $id
    ";

    if ($connect->query($query)) {
        echo "<script>
                alert('Data mekanik berhasil diperbarui!');
                window.location.href='../../pages/mekanik/index.php';
              </script>";
    } else {
        // Jika gagal update dan file baru diupload, hapus file baru
        if ($imageName != $oldImage && file_exists($storages . $imageName)) {
            unlink($storages . $imageName);
        }
        echo "<script>
                alert('Gagal memperbarui: " . $connect->error . "');
                window.history.back();
              </script>";
    }
}
