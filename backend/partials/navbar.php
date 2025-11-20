<?php
// Ambil nama sesuai role
$nama_user = 'Pengguna';

if (isset($_SESSION['role'])) {
    switch ($_SESSION['role']) {
        case 'admin':
            $nama_user = $_SESSION['nama'] ?? 'Admin';
            break;

        case 'mekanik':
            $nama_user = $_SESSION['nama'] ?? 'Mekanik';
            break;

        case 'pelanggan':
            $nama_user = $_SESSION['nama_pelanggan'] ?? 'Pelanggan';
            break;
    }
}
?>

<!--Start topbar header-->
<header class="topbar-nav">
    <nav class="navbar navbar-expand fixed-top">

        <ul class="navbar-nav mr-auto align-items-center"></ul>

        <ul class="navbar-nav align-items-center right-nav-link">

            <!-- Dropdown -->
            <li class="nav-item dropdown d-flex align-items-center" style="margin-right: 15px;">

                <!-- Trigger Dropdown -->
                <a class="nav-link dropdown-toggle dropdown-toggle-nocaret d-flex align-items-center"
                    data-toggle="dropdown" href="#" style="cursor: pointer;">

                    <!-- Foto -->
                    <img src="../../templates_admin/assets/images/user.jpeg"
                        style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">

                    <div style="line-height: 1;">
                        <!-- Nama -->
                        <span style="color: #fff; font-size: 15px; font-weight: 600;">
                            <?= htmlspecialchars($nama_user) ?>
                        </span>
                        <br>

                        <!-- Badge role -->
                        <span style="
                            background: #8b4dff;
                            padding: 3px 10px;
                            border-radius: 6px;
                            font-size: 12px;
                            color: #fff;
                            text-transform: lowercase;
                        ">
                            <?= htmlspecialchars($_SESSION['role'] ?? '-') ?>
                        </span>
                    </div>

                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-right">

                    <li class="dropdown-item">
                        <i class="icon-user mr-2"></i> Profil
                    </li>

                    <li class="dropdown-divider"></li>

                    <li class="dropdown-item">
                        <a href="../../logout.php" style="color:#333; text-decoration:none;">
                            <i class="icon-power mr-2"></i> Logout
                        </a>
                    </li>

                </ul>

            </li>

        </ul>

    </nav>
</header>
<!--End topbar header-->

<div class="clearfix"></div>