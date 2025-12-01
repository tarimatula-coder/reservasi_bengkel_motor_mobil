<?php

// Asumsi berkas ini berada di frontend/pages/transaksi/riwayat_reservasi.php
// dan app.php berada dua tingkat di atasnya.
// Pastikan path ke app.php sudah benar dan koneksi ($connect) berhasil.
include '../../app.php';

// Cek koneksi
if (!$connect) {
    // Logika penanganan error koneksi
    die("Koneksi gagal: " . mysqli_connect_error());
}

// =========================================================================
// 1. Logika Filtering Status
// =========================================================================
$statusFilter = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$whereClause = "";

if (!empty($statusFilter) && $statusFilter !== 'all') {
    // Sanitasi input status untuk keamanan SQL Injection
    $safeStatus = mysqli_real_escape_string($connect, $statusFilter);
    $whereClause = " WHERE r.status = '$safeStatus' ";
}

// =========================================================================
// 2. Query untuk mengambil semua data reservasi beserta detailnya (JOIN)
// =========================================================================
// Query telah diperbaiki dari masalah karakter tersembunyi.
$queryReservasi = "
    SELECT 
        r.id, 
        r.tanggal, 
        r.waktu, 
        r.status,
        r.total_harga,
        p.nama AS nama_pelanggan,
        k.plat_nomor AS plat_kendaraan,
        l.nama_layanan,
        m.nama AS nama_mekanik
    FROM 
        reservasi r 
    LEFT JOIN 
        pelanggan p ON r.pelanggan_id = p.id
    LEFT JOIN 
        kendaraan k ON r.kendaraan_id = k.id
    LEFT JOIN 
        layanan l ON r.layanan_id = l.id
    LEFT JOIN 
        mekanik m ON r.mekanik_id = m.id
    " . $whereClause . "
    ORDER BY 
        r.tanggal DESC, r.waktu DESC
";

// Eksekusi Query
$qReservasi = mysqli_query($connect, $queryReservasi);

// Daftar semua status yang mungkin (sesuai ENUM di database Anda)
$allStatuses = ['Booked', 'Confirmed', 'In-Progress', 'Completed', 'Cancelled'];

// Fungsi untuk mendapatkan kelas CSS status
function getStatusClass($status)
{
    // Mengganti spasi menjadi hyphen dan huruf kecil untuk mencocokkan kelas CSS
    $normalizedStatus = strtolower(str_replace(' ', '-', $status));
    return "bg-$normalizedStatus";
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="../../templates_user/assets/img/logo_bengkel.jpg" type="image/logo_bengkel.jpg">
    <style>
        /* Desain Kustom */
        body {
            background-color: #f7f9fc;
        }

        .deep-blue-accent {
            color: #1a4d94 !important;
        }

        .bg-table-header {
            background-color: #e9f0ff !important;
        }

        .content-wrapper {
            max-width: 1300px;
            margin: auto;
        }

        /* Style untuk Badge Status */
        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
        }

        /* Definisi Warna Status */
        .bg-booked {
            background-color: #ffc107;
            color: #000;
        }

        .bg-confirmed {
            background-color: #17a2b8;
            color: #fff;
        }

        .bg-in-progress {
            background-color: #0d6efd;
            color: #fff;
        }

        .bg-completed {
            background-color: #198754;
            color: #fff;
        }

        .bg-cancelled {
            background-color: #dc3545;
            color: #fff;
        }

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .table thead th {
            font-weight: 600;
            color: #1a4d94;
        }

        .aksi-col {
            width: 1%;
            white-space: nowrap;
            text-align: center;
        }

        .text-date-time {
            text-align: center;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <div class="content-wrapper py-5 px-3">
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col-xl-12">
                        <h2 class="pageheader-title deep-blue-accent"><i class="fas fa-history me-2"></i> Riwayat Transaksi Reservasi Bengkel</h2>
                        <p class="pageheader-text text-secondary">Daftar lengkap semua transaksi reservasi yang masuk, berdasarkan tanggal terbaru.</p>
                    </div>
                </div>

                <hr class="mb-4">

                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Data reservasi berhasil diproses.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Gagal memproses data. Pesan: <?= htmlspecialchars($_GET['msg'] ?? 'Kesalahan tidak diketahui.') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
                        <h5 class="mb-3 mb-md-0 deep-blue-accent fw-bold">Tabel Transaksi</h5>

                        <div class="d-flex align-items-center">
                            <form method="GET" class="me-3">
                                <select name="filter_status" onchange="this.form.submit()" class="form-select rounded-3 shadow-sm">
                                    <option value="all">-- Semua Status --</option>
                                    <?php foreach ($allStatuses as $status): ?>
                                        <option value="<?= htmlspecialchars($status) ?>" <?= $statusFilter == $status ? 'selected' : '' ?>>
                                            <?= ucwords(str_replace('-', ' ', $status)) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </form>

                            <a href="./transaksi.php" class="btn btn-primary px-4 rounded-3 shadow-sm">
                                <i class="fas fa-plus-circle me-2"></i> Tambah Baru
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-table-header">
                                    <tr>
                                        <th scope="col" class="text-center">No</th>
                                        <th scope="col" class="text-center">Tanggal/Waktu</th>
                                        <th scope="col">Pelanggan</th>
                                        <th scope="col">Kendaraan</th>
                                        <th scope="col">Layanan/Mekanik</th>
                                        <th scope="col" class="text-end">Harga</th>
                                        <th scope="col" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($qReservasi) > 0): ?>
                                        <?php while ($res = mysqli_fetch_object($qReservasi)): ?>
                                            <tr>
                                                <th scope="row" class="text-center text-primary"><?= htmlspecialchars($res->id) ?></th>
                                                <td class="text-date-time">
                                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($res->tanggal)) ?></small><br>
                                                    <span class="fw-bold text-dark"><i class="far fa-clock me-1"></i> <?= htmlspecialchars($res->waktu) ?></span>
                                                </td>
                                                <td><?= htmlspecialchars($res->nama_pelanggan) ?></td>
                                                <td><?= htmlspecialchars($res->plat_kendaraan) ?></td>
                                                <td>
                                                    <span class="fw-bold"><?= htmlspecialchars($res->nama_layanan) ?></span> <br>
                                                    <small class="text-secondary">(Mekanik: <?= htmlspecialchars($res->nama_mekanik) ?: 'N/A' ?>)</small>
                                                </td>
                                                <td class="text-end fw-bold">Rp<?= number_format($res->total_harga, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <span class="status-badge <?= getStatusClass($res->status) ?>">
                                                        <?= ucwords(str_replace('-', ' ', htmlspecialchars($res->status))) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-database fa-2x d-block mb-2"></i>
                                                <p class="mb-0">Tidak ditemukan data reservasi dengan filter saat ini.</p>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>