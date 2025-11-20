<?php
include '../../app.php';

// Cek koneksi
if (!$connect) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Query untuk mengambil semua data reservasi beserta detailnya (JOIN)
$qReservasi = mysqli_query($connect, "
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
    ORDER BY 
        r.tanggal DESC, r.waktu DESC
");

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        /* Menggunakan warna background yang sangat terang */
        body {
            background-color: #f7f9fc;
        }

        /* Definisi Warna Biru Tua Kustom untuk Aksen Utama */
        .deep-blue-accent {
            color: #1a4d94 !important;
        }

        /* Warna Header Tabel Biru Muda */
        .bg-table-header {
            background-color: #e9f0ff !important;
        }

        .content-wrapper {
            max-width: 1300px;
            /* Lebar maksimum untuk tabel lebih luas */
            margin: auto;
        }

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

        /* Warna Status (Dipertahankan agar berbeda) */
        .bg-booked {
            background-color: #ffc107;
            /* Kuning */
            color: #000;
        }

        .bg-confirmed {
            background-color: #17a2b8;
            /* Cyan */
            color: #fff;
        }

        .bg-in-progress {
            background-color: #0d6efd;
            /* Biru */
            color: #fff;
        }

        .bg-completed {
            background-color: #198754;
            /* Hijau */
            color: #fff;
        }

        .bg-cancelled {
            background-color: #dc3545;
            /* Merah */
            color: #fff;
        }

        /* Perbaikan Tabel */
        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .table thead th {
            font-weight: 600;
            color: #1a4d94;
            /* Text header menggunakan deep blue */
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
                        <!-- Judul utama menggunakan warna deep blue kustom -->
                        <h2 class="pageheader-title deep-blue-accent">Daftar Data Reservasi</h2>
                        <p class="pageheader-text text-secondary">Lihat, kelola, dan tambahkan reservasi bengkel baru di sini.</p>
                    </div>
                </div>

                <hr class="mb-4">

                <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
                    <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-2"></i> Data reservasi berhasil disimpan! (ID: <?= htmlspecialchars($_GET['id']) ?>)
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
                    <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i> Gagal menyimpan data. Pesan: <?= htmlspecialchars($_GET['msg']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>


                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-4">
                        <!-- Judul Card menggunakan warna deep blue kustom -->
                        <h5 class="mb-0 deep-blue-accent fw-bold">Data Reservasi Bengkel</h5>
                        <!-- Tombol Tambah menggunakan warna primary (biru Bootstrap) -->
                        <a href="./reservasi.php" class="btn btn-primary px-4 rounded-3 shadow-sm">
                            <i class="fas fa-plus-circle me-2"></i> Tambah Reservasi Baru
                        </a>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <!-- Header Tabel menggunakan custom light blue background -->
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
                                                <!-- ID menggunakan warna primary (biru Bootstrap) -->
                                                <th scope="row" class="text-center text-primary"><?= $res->id ?></th>
                                                <td class="text-date-time">
                                                    <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> <?= date('d M Y', strtotime($res->tanggal)) ?></small><br>
                                                    <span class="fw-bold text-dark"><i class="far fa-clock me-1"></i> <?= $res->waktu ?></span>
                                                </td>
                                                <td><?= htmlspecialchars($res->nama_pelanggan) ?></td>
                                                <td><?= htmlspecialchars($res->plat_kendaraan) ?></td>
                                                <td>
                                                    <span class="fw-bold"><?= htmlspecialchars($res->nama_layanan) ?></span> <br>
                                                    <small class="text-secondary">(Mekanik: <?= htmlspecialchars($res->nama_mekanik) ?>)</small>
                                                </td>
                                                <td class="text-end fw-bold">Rp<?= number_format($res->total_harga, 0, ',', '.') ?></td>
                                                <td class="text-center">
                                                    <span class="status-badge bg-<?= strtolower(str_replace(' ', '-', $res->status)) ?>">
                                                        <?= ucwords(str_replace('-', ' ', $res->status)) ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center py-5 text-muted">
                                                <i class="fas fa-database fa-2x d-block mb-2"></i>
                                                <p class="mb-0">Belum ada data reservasi yang tersimpan.</p>
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