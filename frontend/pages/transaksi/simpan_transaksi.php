<?php
// ===============================================
// FILE: simpan_transaksi.php (Riwayat Reservasi)
// ===============================================

// Include koneksi
include '../../app.php';

// Cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ===============================================================
// FIX: Buat default whereClause agar tidak undefined
// ===============================================================
$whereClause = ""; // Jika ingin filter tanggal / pelanggan tinggal isi di sini.

// ===============================================================
// QUERY JOIN RIWAYAT RESERVASI
// ===============================================================
$queryReservasi = "
    SELECT 
        r.id, 
        r.tanggal, 
        r.waktu, 
        r.total_harga,
        p.nama AS nama_pelanggan,
        k.plat_nomor AS plat_kendaraan,
        l.nama_layanan,
        m.nama AS nama_mekanik
    FROM 
        reservasi r 
    LEFT JOIN pelanggan p ON r.pelanggan_id = p.id
    LEFT JOIN kendaraan k ON r.kendaraan_id = k.id
    LEFT JOIN layanan l ON r.layanan_id = l.id
    LEFT JOIN mekanik m ON r.mekanik_id = m.id
    $whereClause
    ORDER BY r.tanggal DESC, r.waktu DESC
";

// Eksekusi Query
$qReservasi = mysqli_query($connect, $queryReservasi);
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

        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .table thead th {
            font-weight: 600;
            color: #1a4d94;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <div class="content-wrapper py-5 px-3">
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col-xl-12">
                        <h2 class="pageheader-title deep-blue-accent">
                            <i class="fas fa-history me-2"></i> Riwayat Transaksi Reservasi Bengkel
                        </h2>
                        <p class="pageheader-text text-secondary">
                            Daftar lengkap semua transaksi reservasi berdasarkan tanggal terbaru.
                        </p>
                    </div>
                </div>

                <hr class="mb-4">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white d-flex flex-column flex-md-row justify-content-between align-items-center p-4">
                        <h5 class="mb-3 mb-md-0 deep-blue-accent fw-bold">Tabel Transaksi</h5>
                        <a href="./transaksi.php" class="btn btn-primary px-4 rounded-3 shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Baru
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-table-header">
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Tanggal/Waktu</th>
                                        <th>Pelanggan</th>
                                        <th>Kendaraan</th>
                                        <th>Layanan / Mekanik</th>
                                        <th class="text-end">Harga</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (mysqli_num_rows($qReservasi) > 0): ?>
                                        <?php while ($res = mysqli_fetch_object($qReservasi)): ?>
                                            <tr>
                                                <th class="text-center text-primary"><?= htmlspecialchars($res->id) ?></th>
                                                <td class="text-center">
                                                    <small class="text-muted">
                                                        <i class="far fa-calendar-alt me-1"></i>
                                                        <?= date('d M Y', strtotime($res->tanggal)) ?>
                                                    </small><br>
                                                    <span class="fw-bold text-dark">
                                                        <i class="far fa-clock me-1"></i>
                                                        <?= htmlspecialchars($res->waktu) ?>
                                                    </span>
                                                </td>

                                                <td><?= htmlspecialchars($res->nama_pelanggan) ?></td>
                                                <td><?= htmlspecialchars($res->plat_kendaraan) ?></td>

                                                <td>
                                                    <span class="fw-bold"><?= htmlspecialchars($res->nama_layanan) ?></span><br>
                                                    <small class="text-secondary">
                                                        (Mekanik: <?= htmlspecialchars($res->nama_mekanik ?: 'N/A') ?>)
                                                    </small>
                                                </td>

                                                <td class="text-end fw-bold">
                                                    Rp<?= number_format($res->total_harga, 0, ',', '.') ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>

                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-database fa-2x d-block mb-2"></i>
                                                Tidak ditemukan data reservasi.
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