<?php
session_start();
include '../../../config/connection.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mekanik') {
    echo "<script>alert('Akses ditolak!');window.location.href='../../pages/reservasi/index.php';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id'] ?? 0);
    $status = strtolower(trim($_POST['status'] ?? ''));

    $valid_status = ['booked', 'in-progress', 'completed', 'cancelled'];
    if (!in_array($status, $valid_status)) {
        echo "<script>alert('Status tidak valid!');window.location.href='../../pages/reservasi/index.php';</script>";
        exit;
    }

    $user_id = $_SESSION['id_user'];
    $q = mysqli_query($connect, "SELECT id FROM mekanik WHERE user_id='$user_id' LIMIT 1");
    $r = mysqli_fetch_assoc($q);
    $mekanik_id = $r['id'] ?? 0;

    // Pastikan reservasi milik mekanik
    $check = mysqli_query($connect, "SELECT mekanik_id FROM reservasi WHERE id='$id' LIMIT 1");
    $row = mysqli_fetch_assoc($check);
    if (!$row || $row['mekanik_id'] != $mekanik_id) {
        echo "<script>alert('Reservasi ini bukan milik Anda!');window.location.href='../../pages/reservasi/index.php';</script>";
        exit;
    }

    // Update status
    $stmt = $connect->prepare("UPDATE reservasi SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    if ($stmt->execute()) {
        echo "<script>alert('Status berhasil diubah!');window.location.href='../../pages/reservasi/index.php';</script>";
    } else {
        echo "<script>alert('Gagal mengubah status: " . $stmt->error . "');window.location.href='../../pages/reservasi/index.php';</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Akses tidak valid!');window.location.href='../../pages/reservasi/index.php';</script>";
}
