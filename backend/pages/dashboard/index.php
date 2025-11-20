<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil total data dari masing-masing tabel
$totalKendaraan = $connect->query("SELECT COUNT(*) AS total FROM kendaraan")->fetch_assoc()['total'];
$totalMekanik   = $connect->query("SELECT COUNT(*) AS total FROM mekanik")->fetch_assoc()['total'];
$totalReservasi = $connect->query("SELECT COUNT(*) AS total FROM reservasi")->fetch_assoc()['total'];
$totalTransaksi = $connect->query("SELECT COUNT(*) AS total FROM transaksi")->fetch_assoc()['total'];
$totalPelanggan = $connect->query("SELECT COUNT(*) AS total FROM pelanggan")->fetch_assoc()['total'];
$totalLayanan   = $connect->query("SELECT COUNT(*) AS total FROM layanan")->fetch_assoc()['total'];

// Data contoh bulanan
$bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'];
$reservasiBulanan = [5, 8, 6, 10, 7, 12];
$transaksiBulanan = [3, 6, 4, 9, 6, 11];
?>

<style>
    /* --- Tambahan styling dashboard --- */
    .card-metric {
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        border-radius: 10px;
        transition: transform 0.2s;
    }

    .card-metric:hover {
        transform: translateY(-3px);
    }

    .card-body h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
    }

    .card-body h5 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .content-wrapper {
        min-height: calc(100vh - 100px);
        /* supaya footer tidak ikut ke tengah */
    }

    footer {
        position: relative;
        bottom: 0;
        width: 100%;
    }
</style>
<div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
            <div class="loader"></div>
        </div>
    </div>
</div>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="text-center my-4">
                <h2 class="fw-bold text-primary">Dashboard Reservasi Bengkel Motor & Mobil</h2>
                <hr class="mx-auto" style="width: 200px;">
            </div>

            <!-- Statistik Box -->
            <div class="row justify-content-center">
                <?php
                $cards = [
                    ['title' => 'Kendaraan', 'value' => $totalKendaraan, 'color' => 'primary'],
                    ['title' => 'Mekanik', 'value' => $totalMekanik, 'color' => 'success'],
                    ['title' => 'Reservasi', 'value' => $totalReservasi, 'color' => 'warning'],
                    ['title' => 'Transaksi', 'value' => $totalTransaksi, 'color' => 'danger'],
                    ['title' => 'Pelanggan', 'value' => $totalPelanggan, 'color' => 'info'],
                    ['title' => 'Layanan', 'value' => $totalLayanan, 'color' => 'secondary']
                ];
                foreach ($cards as $c): ?>
                    <div class="col-6 col-md-4 col-lg-2 mb-4">
                        <div class="card shadow-sm border-0 card-metric bg-light">
                            <div class="card-body text-center">
                                <h5 class="fw-semibold text-<?= $c['color'] ?>"><?= $c['title'] ?></h5>
                                <h3 class="fw-bold text-dark"><?= $c['value'] ?></h3>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Grafik -->
            <div class="row my-4">
                <!-- Diagram Batang -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100" style="height: 400px;">
                        <div class="card-header bg-primary text-white fw-semibold">
                            Diagram Batang Reservasi vs Transaksi
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Diagram Bulat -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100" style="height: 400px;">
                        <div class="card-header bg-success text-white fw-semibold">
                            Diagram Bulat Komposisi Data
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Diagram Gelombang -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark fw-semibold">Diagram Gelombang Reservasi</div>
                        <div class="card-body">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Diagram Zig-Zag -->
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white fw-semibold">Diagram Zig-Zag Transaksi</div>
                        <div class="card-body">
                            <canvas id="areaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const bulan = <?= json_encode($bulan) ?>;
        const reservasiData = <?= json_encode($reservasiBulanan) ?>;
        const transaksiData = <?= json_encode($transaksiBulanan) ?>;

        // Diagram Batang
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Reservasi',
                    data: reservasiData,
                    backgroundColor: '#007bff'
                }, {
                    label: 'Transaksi',
                    data: transaksiData,
                    backgroundColor: '#dc3545'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Diagram Bulat
        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Kendaraan', 'Mekanik', 'Reservasi', 'Transaksi', 'Pelanggan', 'Layanan'],
                datasets: [{
                    data: [
                        <?= $totalKendaraan ?>,
                        <?= $totalMekanik ?>,
                        <?= $totalReservasi ?>,
                        <?= $totalTransaksi ?>,
                        <?= $totalPelanggan ?>,
                        <?= $totalLayanan ?>
                    ],
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6c757d']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Diagram Gelombang
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Reservasi',
                    data: reservasiData,
                    borderColor: '#ffc107',
                    fill: false,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

        // Diagram Zig-Zag
        new Chart(document.getElementById('areaChart'), {
            type: 'line',
            data: {
                labels: bulan,
                datasets: [{
                    label: 'Transaksi',
                    data: transaksiData,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220,53,69,0.3)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
    <style>
        /* --- Tambahan styling dashboard --- */
        body,
        html {
            overflow-x: hidden;
            /* 🔒 Hilangkan scroll ke kanan */
            width: 100%;
        }

        .container-fluid {
            max-width: 100%;
            overflow-x: hidden;
            /* Hindari elemen meluber */
        }

        .card-metric {
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border-radius: 10px;
            transition: transform 0.2s;
        }

        .card-metric:hover {
            transform: translateY(-3px);
        }

        .card-body h3 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .card-body h5 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .content-wrapper {
            min-height: calc(100vh - 100px);
            overflow-x: hidden;
            /* 🔒 Tidak bisa geser kanan */
        }

        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }

        /* Agar grafik responsif dan tidak keluar layar */
        canvas {
            max-width: 100% !important;
            height: auto !important;
        }

        /* Hapus margin tambahan dari row */
        .row {
            margin-left: 0;
            margin-right: 0;
        }

        .text-center h2 {
            color: white !important;
        }

        .card.shadow-sm.h-100 {
            height: 400px !important;
            /* tinggi card sama */
        }

        .card-body canvas {
            max-height: 300px;
            /* biar grafik pas di dalam */
        }
    </style>


    <?php
    include '../../partials/footer.php';
    include '../../partials/script.php';
    ?>