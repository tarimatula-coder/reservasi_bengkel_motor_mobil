<?php
session_start();
include '../../app.php'; // koneksi database

// ambil user login
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] <= 0) {
    echo "<script>alert('User belum login!'); window.history.back();</script>";
    exit;
}

$user_id    = intval($_SESSION['user_id']);
$action     = trim($_POST['action'] ?? '');
$objectType = trim($_POST['object_type'] ?? '');
$objectId   = intval($_POST['object_id'] ?? 0);
$message    = trim($_POST['message'] ?? '');

// validasi
if ($action === '' || $objectType === '' || $objectId == 0 || $message === '') {
    echo "<script>alert('Semua field wajib diisi!'); window.history.back();</script>";
    exit;
}

// insert sesuai relasi
$sql = "INSERT INTO audit_logs (user_id, action, object_type, object_id, message)
        VALUES ($user_id, '$action', '$objectType', $objectId, '$message')";

if (mysqli_query($connect, $sql)) {
    echo "<script>alert('Audit Log berhasil ditambahkan!'); window.location.href='../../pages/audit_logs/index.php';</script>";
} else {
    echo "<script>alert('Gagal: " . mysqli_error($connect) . "'); window.history.back();</script>";
}
