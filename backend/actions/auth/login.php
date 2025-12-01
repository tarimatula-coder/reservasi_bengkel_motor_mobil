<?php
session_start();
include '../../../config/connection.php';

// ================= CEGAH LOGIN ULANG =================
if (isset($_SESSION['role'])) {

    if ($_SESSION['role'] === 'admin') {
        header("Location: ../../pages/dashboard/index.php");
        exit;
    }

    if ($_SESSION['role'] === 'mekanik') {
        header("Location: ../../pages/jadwal_servis/index.php");
        exit;
    }
}
// ======================================================


// ======================================================
// ================ PROSES LOGIN ========================
// ======================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $role = $_POST['role'] ?? '';
    $username = mysqli_real_escape_string($connect, $_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';


    // ================= ADMIN & MEKANIK =================
    if (in_array($role, ['admin', 'mekanik'])) {

        $query = "SELECT * FROM users WHERE username='$username' AND role='$role' LIMIT 1";
        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) > 0) {

            $row = mysqli_fetch_assoc($result);

            // Password verifikasi (hash atau plain text)
            if (password_verify($password, $row['password']) || $password === $row['password']) {

                $_SESSION['id_user']   = $row['id'];
                $_SESSION['username']  = $row['username'];
                $_SESSION['role']      = $row['role'];
                $_SESSION['nama']      = $row['full_name'];
                $_SESSION['level']     = ucfirst($row['role']);

                // Redirect berdasarkan role
                $redirect = ($role === 'admin')
                    ? '../../pages/dashboard/index.php'
                    : '../../pages/jadwal_servis/index.php';

                echo "<script>
                        alert('Login berhasil sebagai " . ucfirst($role) . "');
                        window.location.href='$redirect';
                      </script>";
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

    
