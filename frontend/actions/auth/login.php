<?php
session_start();
include '../../../config/connection.php';

// ================= CEGAH LOGIN ULANG =================
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] === 'pelanggan') {
        header("Location: ../frontend/index.php");
        exit;
    }
}
// ======================================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    $username = mysqli_real_escape_string($connect, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // ================= Admin & Mekanik =================
    if (in_array($role, ['admin', 'mekanik'])) {
        $query = "SELECT * FROM users WHERE username='$username' AND role='$role' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                $_SESSION['id_user'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['nama'] = $row['full_name'];
                $_SESSION['level'] = ucfirst($row['role']);

                $redirect = ($role === 'admin') ? '../../pages/dashboard/index.php' : '../../pages/jadwal_servis/index.php';
                echo "<script>alert('Login berhasil sebagai " . ucfirst($role) . "');window.location.href='$redirect';</script>";
                exit;
            } else {
                echo "<script>alert('Password salah!');history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Username atau role tidak ditemukan!');history.back();</script>";
            exit;
        }
    }

    // ================= Pelanggan =================
    elseif ($role === 'pelanggan') {
        $query = "SELECT * FROM pelanggan WHERE email='$username' OR no_hp='$username' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (!isset($row['password']) || password_verify($password, $row['password']) || $password === $row['password']) {
                $_SESSION['id_pelanggan'] = $row['id'];
                $_SESSION['nama_pelanggan'] = $row['nama'];
                $_SESSION['role'] = 'pelanggan';
                $_SESSION['level'] = 'Pelanggan';

                echo "<script>alert('Login berhasil sebagai Pelanggan!');window.location.href='../../pages/jadwal_servis/index.php';</script>";
                exit;
            } else {
                echo "<script>alert('Password salah!');history.back();</script>";
                exit;
            }
        } else {
            echo "<script>alert('Pelanggan tidak ditemukan!');history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Silakan pilih role!');history.back();</script>";
        exit;
    }
} else {
    echo "<script>alert('Akses tidak valid!');history.back();</script>";
    exit;
}
