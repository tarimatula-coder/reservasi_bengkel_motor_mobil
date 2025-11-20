<?php
include '../../app.php'; 

$nama  = trim($_POST['nama'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
$alamat = trim($_POST['alamat'] ?? '');
$email = trim($_POST['email'] ?? '');

// Validasi form
if ($nama === '' || $no_hp === '' || $alamat === '' || $email === '') {
    echo "
    <script>
        alert('Semua field wajib diisi!');
        window.history.back();
    </script>";
    exit;
}

// Simpan data ke tabel pelanggan
$query = "INSERT INTO pelanggan (nama, no_hp, alamat, email)
    VALUES ('$nama', '$no_hp', '$alamat',  '$email')
";

if (mysqli_query($connect, $query)) {
    echo "
    <script>
        alert('Data pelanggan berhasil ditambahkan!');
        window.location.href='../../pages/pelanggan/index.php';
    </script>";
} else {
    echo "
    <script>
        alert('Gagal menambahkan data: " . mysqli_error($connect) . "');
        window.history.back();
    </script>";
}
