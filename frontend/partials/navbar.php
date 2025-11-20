
<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center">
            <h1 class="sitename m-0">BENGKEL MOTOR MOBIL</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#home" class="active">Beranda</a></li>
                <li><a href="#kendaraan">Kendaraan</a></li>
                <li><a href="#mekanik">Mekanik</a></li>
                <li><a href="pages/reservasi/reservasi.php">Reservasi</a></li>
                <li><a href="#layanan">Layanan</a></li>
                <li><a href="pages/transaksi/transaksi.php">Transaksi</a></li>
                <li><a href="pages/auth/login.php">Login</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

    </div>
</header>

<style>
    /* Navbar tetap di atas */
    .header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        z-index: 999;
        background-color: rgba(0, 0, 0, 0.8);
        /* bisa diganti sesuai tema */
        padding: 10px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        transition: background 0.3s;
    }

    /* Tambahkan padding-top agar konten tidak tertutup navbar */
    body {
        padding-top: 70px;
        /* sesuaikan dengan tinggi navbar */
    }

    .navmenu ul {
        list-style: none;
        display: flex;
        margin: 0;
        padding: 0;
        gap: 20px;
    }

    .navmenu ul li a {
        color: white;
        font-weight: 500;
        text-decoration: none !important;
        transition: color 0.3s;
    }

    .navmenu ul li a:hover,
    .navmenu ul li a.active {
        color: #ffcc00;
    }

    .logo h1 {
        color: white;
        font-size: 20px;
        font-weight: 700;
    }

    /* Mobile nav toggle */
    .mobile-nav-toggle {
        font-size: 24px;
        color: white;
        cursor: pointer;
    }
</style>