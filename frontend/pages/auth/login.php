<?php
session_start();
$home_redirect = '../index.php';

// if (isset($_SESSION['level'])) {
//     $redirect = $home_redirect;

//     echo "<script>alert('Anda sudah login!');window.location.href='$redirect';</script>";
//     exit;
// }
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Bengkel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="../../templates_user/assets/img/logo_bengkel.jpg" type="image/logo_bengkel.jpg">
    <style>
        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #1b263b;
            /* Menggunakan font sistem yang umum jika Poppins tidak tersedia */
            font-family: 'Inter', Poppins, sans-serif;
        }

        .card {
            padding: 2rem;
            border-radius: 12px;
            width: 25rem;
            background: #f8f9fa;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        h3 {
            text-align: center;
            color: #1b263b;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background: #1b263b;
            border: none;
        }

        .btn-primary:hover {
            background: #0d1b2a;
        }

        /* Responsive adjustments for smaller screens */
        @media (max-width: 576px) {
            .card {
                width: 90%;
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="card">
        <h3>Login Aplikasi Bengkel</h3>
        <!-- Asumsi action="../../actions/auth/login.php" mengarah ke process_login.php yang baru saja kita edit -->
        <form action="../../index.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Login Sebagai</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Administrator</option>
                    <option value="mekanik">Mekanik</option>
                    <option value="pelanggan">Pelanggan</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Username / Email</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username atau email..." required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password..." required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>
</body>

</html>