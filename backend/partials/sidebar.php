<?php
// Pastikan sesi dimulai hanya sekali
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
?>

<div id="sidebar-wrapper" data-simplebar="" data-simplebar-auto-hide="true">

    <!-- LOGO + TEXT DALAM 1 BARIS -->
    <div class="brand-logo d-flex align-items-center"
        style="width: 100%; padding: 10px; gap: 10px;">

        <!-- LOGO -->
        <img src="../../templates_admin/assets/images/logo_bengkel.jpg"
            alt="Logo Bengkel"
            style="
                width: 45px;
                height: 45px;
                object-fit: cover;
                border-radius: 50%;
                border: 2px solid white;
                padding: 2px;
            ">

        <!-- TEXT -->
        <a href="index.php" class="text-decoration-none text-white">
            <h6 class="logo-text mb-0 fw-semibold" style="font-size: 13px; line-height: 1.1;">
                Reservasi Bengkel<br>
                <span style="font-size: 12px;">Motor & Mobil</span>
            </h6>
        </a>

    </div>

    <ul class="sidebar-menu do-nicescrol">

        <li class="sidebar-header">Menu</li>

        <li><a href="../dashboard/index.php"><i class="zmdi zmdi-view-dashboard"></i> <span>Dashboard</span></a></li>

        <?php if ($role == 'admin'): ?>

            <li><a href="../pelanggan/index.php"><i class="zmdi zmdi-account-box"></i> <span>Data Pelanggan</span></a></li>

            <li><a href="../mekanik/index.php"><i class="zmdi zmdi-accounts-outline"></i> <span>Data Mekanik</span></a></li>

            <li><a href="../layanan_bengkel/index.php"><i class="zmdi zmdi-wrench"></i> <span>Layanan Bengkel</span></a></li>

            <li><a href="../kendaraan/index.php"><i class="zmdi zmdi-car"></i> <span>Data Kendaraan</span></a></li>

            <li><a href="../reservasi/index.php"><i class="zmdi zmdi-calendar-check"></i> <span>Reservasi</span></a></li>

            <li><a href="../jadwal_servis/index.php"><i class="zmdi zmdi-time"></i> <span>Jadwal Servis</span></a></li>

            <li><a href="../status_perbaikan/index.php"><i class="zmdi zmdi-wrench"></i> <span>Status Perbaikan</span></a></li>

            <li><a href="../transaksi/index.php"><i class="zmdi zmdi-money"></i> <span>Transaksi</span></a></li>

            <li><a href="../laporan/index.php"><i class="zmdi zmdi-file-text"></i> <span>Laporan</span></a></li>

            <li><a href="../user/index.php"><i class="zmdi zmdi-accounts"></i> <span>User</span></a></li>

            <!-- <li><a href="../view_pendapatan_bulanan/index.php"><i class="zmdi zmdi-chart"></i> <span>Pendapatan Bulanan</span></a></li> -->

        <?php endif; ?>


        <?php if ($role == 'mekanik'): ?>

            <li><a href="../reservasi/index.php"><i class="zmdi zmdi-calendar"></i> <span>Lihat Reservasi</span></a></li>

            <li><a href="../jadwal_servis/index.php"><i class="zmdi zmdi-time"></i> <span>Jadwal Servis</span></a></li>

            <li><a href="../status_perbaikan/index.php"><i class="zmdi zmdi-wrench"></i> <span>Ubah Status Perbaikan</span></a></li>

        <?php endif; ?>


        <?php if ($role == 'pelanggan'): ?>

            <li><a href="../reservasi/create.php"><i class="zmdi zmdi-calendar-add"></i><span>Buat Reservasi</span></a></li>

            <li><a href="../reservasi/index.php"><i class="zmdi zmdi-calendar-check"></i> <span>Riwayat Reservasi</span></a></li>

            <li><a href="../jadwal_servis/index.php"><i class="zmdi zmdi-time"></i> <span>Jadwal Servis</span></a></li>

            <li><a href="../status_perbaikan/index.php"><i class="zmdi zmdi-wrench"></i> <span>Status Perbaikan</span></a></li>

            <li><a href="../transaksi/index.php"><i class="zmdi zmdi-money"></i> <span>Riwayat Pembayaran</span></a></li>

        <?php endif; ?>

        <li class="sidebar-header">Akses</li>

        <?php if (empty($role)): ?>
            <li><a href="../auth/login.php"><i class="zmdi zmdi-lock-outline"></i> <span>Login</span></a></li>
        <?php endif; ?>

        <?php if (!empty($role)): ?>
            <li>
                <a href="../../actions/auth/logout.php"><i class="zmdi zmdi-power"></i> <span>Logout</span></a>
            </li>
        <?php endif; ?>

    </ul>
</div>