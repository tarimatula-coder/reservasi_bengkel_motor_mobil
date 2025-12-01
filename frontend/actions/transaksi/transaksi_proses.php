<?php
include '../../app.php';

if (!isset($_POST['tombol'])) {
    echo "<script>alert('Tidak ada data dikirim!');history.back();</script>";
    exit;
}

// ambil input
$reservasi_id       = mysqli_real_escape_string($connect, $_POST['reservasi_id']);
$tipe_pembayaran    = strtolower(mysqli_real_escape_string($connect, $_POST['tipe_pembayaran']));
$nominal            = mysqli_real_escape_string($connect, $_POST['nominal']);
$tanggal_pembayaran = mysqli_real_escape_string($connect, $_POST['tanggal_pembayaran']);
$status             = strtolower(mysqli_real_escape_string($connect, $_POST['status']));

// validasi ENUM tipe_pembayaran sesuai DB
$valid_tipe = ['tunai', 'transfer', 'e-wallet'];
if (!in_array($tipe_pembayaran, $valid_tipe)) {
    echo "<script>alert('Tipe Pembayaran TIDAK valid!');history.back();</script>";
    exit;
}

// validasi ENUM status sesuai DB
$valid_status = ['pending', 'confirmed', 'rejected'];
if (!in_array($status, $valid_status)) {
    echo "<script>alert('Status Pembayaran TIDAK valid!');history.back();</script>";
    exit;
}

// upload bukti transfer wajib
if ($_FILES['bukti_transfer']['error'] != 0) {
    echo "<script>alert('Bukti transfer wajib diupload!');history.back();</script>";
    exit;
}

$ext = strtolower(pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION));
$bukti_transferNew = time() . "." . $ext;

$storages = "../../../storages/bukti_transfer/";

if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $storages . $bukti_transferNew)) {

    $query = "INSERT INTO transaksi 
        (reservasi_id, tipe_pembayaran, nominal, tanggal_pembayaran, status, bukti_transfer)
        VALUES
        ('$reservasi_id','$tipe_pembayaran','$nominal','$tanggal_pembayaran','$status','$bukti_transferNew')
    ";

    if (mysqli_query($connect, $query)) {
        echo "<script>alert('Transaksi berhasil ditambahkan!');window.location.href='../../pages/transaksi/simpan_transaksi.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan transaksi, cek query!');history.back();</script>";
    }
} else {
    echo "<script>alert('Upload bukti transfer gagal!');history.back();</script>";
}
