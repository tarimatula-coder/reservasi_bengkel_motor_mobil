<?php
session_start();
include '../../../config/connection.php';

// ================= CEGAH LOGIN ULANG =================
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] === 'admin') {
        header("Location: ../../pages/dashboard/index.php");
        exit;
    } elseif ($_SESSION['role'] === 'mekanik') {
        header("Location: ../../pages/jadwal_servis/index.php");
        exit;
    }
}

// ================= PROSES LOGIN =================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $role     = strtolower($_POST['role'] ?? '');
    $username = mysqli_real_escape_string($connect, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validasi input
    if (empty($role) || empty($username) || empty($password)) {
        echo "<script>alert('Data login tidak lengkap!');history.back();</script>";
        exit;
    }

    // ================= LOGIN ADMIN & MEKANIK =================
    if ($role === 'admin' || $role === 'mekanik') {

        $query  = "SELECT * FROM users WHERE username='$username' AND role='$role' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            // Verifikasi password
            if (
                password_verify($password, $row['password']) ||
                $password === $row['password']
            ) {

                // SET SESSION
                $_SESSION['id_user']  = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role']     = $row['role'];
                $_SESSION['nama']     = $row['full_name'];

                // REDIRECT SESUAI ROLE
                if ($row['role'] === 'admin') {
                    header("Location: ../../pages/dashboard/index.php");
                } else {
                    header("Location: ../../pages/jadwal_servis/index.php");
                }
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
}
