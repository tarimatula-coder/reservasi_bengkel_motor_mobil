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

    $role     = strtolower(trim($_POST['role'] ?? ''));
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($role) || empty($username) || empty($password)) {
        echo "<script>alert('Data login tidak lengkap!');history.back();</script>";
        exit;
    }

    // ================= LOGIN ADMIN & MEKANIK =================
    if ($role === 'admin' || $role === 'mekanik') {

        $usernameEsc = mysqli_real_escape_string($connect, $username);
        $roleEsc     = mysqli_real_escape_string($connect, $role);

        // LOGIN pakai USERNAME atau EMAIL
        $query = "
            SELECT * FROM users 
            WHERE (username='$usernameEsc' OR email='$usernameEsc')
            AND LOWER(role)='$roleEsc'
            LIMIT 1
        ";

        $result = mysqli_query($connect, $query);

        if ($result && mysqli_num_rows($result) === 1) {

            $row = mysqli_fetch_assoc($result);

            if (
                password_verify($password, $row['password']) ||
                $password === $row['password']
            ) {

                $_SESSION['id_user']  = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role']     = strtolower($row['role']);
                $_SESSION['nama']     = $row['full_name'];

                if ($_SESSION['role'] === 'admin') {
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
            echo "<script>alert('Username / Email atau Role tidak ditemukan!');history.back();</script>";
            exit;
        }
    }
}
