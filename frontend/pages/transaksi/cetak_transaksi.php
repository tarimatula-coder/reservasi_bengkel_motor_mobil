<?php
$reservasiId = isset($_GET['id']) ? htmlspecialchars($_GET['id']) : 'R-987654';

// Mock Data untuk satu reservasi (sesuai field dari query Anda sebelumnya)
$dataReservasi = "
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

// Fungsi bantuan untuk mendapatkan kelas CSS status (sesuai file Riwayat sebelumnya)
function getStatusClass($status)
{
    $normalizedStatus = strtolower(str_replace(' ', '-', $status));
    $classes = [
        'booked' => 'bg-warning text-dark',
        'confirmed' => 'bg-info text-white',
        'in-progress' => 'bg-primary text-white',
        'completed' => 'bg-success text-white',
        'cancelled' => 'bg-danger text-white',
    ];
    return $classes[$normalizedStatus] ?? 'bg-secondary text-white';
}

// Fungsi format rupiah
function formatRupiah($angka)
{
    return 'Rp' . number_format($angka, 0, ',', '.');
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Reservasi - <?= $dataReservasi['id'] ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f7f9fc;
            font-family: 'Inter', sans-serif;
        }

        .receipt-card {
            max-width: 700px;
            margin: 40px auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .receipt-header h1 {
            color: #8B0000;
            /* Warna merah marun dari contoh gambar */
            font-weight: 700;
            margin-bottom: 5px;
        }

        .receipt-date {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 20px;
        }

        .divider {
            border: 0;
            height: 2px;
            background-color: #8B0000;
            margin: 20px 0;
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-top: 20px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        .detail-label {
            font-weight: 600;
            color: #1a4d94;
            min-width: 150px;
            /* Lebar minimum untuk label */
        }

        .detail-value {
            flex-grow: 1;
            text-align: right;
        }

        .total-section {
            padding-top: 20px;
            border-top: 2px solid #ddd;
            margin-top: 20px;
        }

        .total-row {
            font-size: 1.25rem;
            font-weight: bold;
            color: #000;
        }

        /* Tambahan untuk status badge */
        .status-badge {
            padding: 0.35em 0.65em;
            border-radius: 0.375rem;
            font-size: 0.8em;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="receipt-card">
        <div class="receipt-header text-center">
            <h1 class="mb-0">BUKTI RESERVASI BENGKEL</h1>
            <div class="receipt-date">Nomor: **<?= htmlspecialchars($dataReservasi['id']) ?>**</div>
        </div>

        <hr class="divider">

        <!-- Data Pelanggan -->
        <div class="section-title">Data Pelanggan</div>
        <div class="detail-row">
            <span class="detail-label">Nama</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['nama_pelanggan']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">No. Telepon</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['no_telp_pelanggan']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Kendaraan</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['merk_kendaraan']) ?> (<?= htmlspecialchars($dataReservasi['jenis_kendaraan']) ?>)</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Plat Nomor</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['plat_kendaraan']) ?></span>
        </div>

        <hr class="divider">

        <!-- Detail Pemesanan -->
        <div class="section-title">Detail Reservasi & Layanan</div>
        <div class="detail-row">
            <span class="detail-label">Tanggal Janji Temu</span>
            <span class="detail-value text-dark fw-normal">: <?= date('d/m/Y', strtotime($dataReservasi['tanggal_reservasi'])) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Jam Janji Temu</span>
            <span class="detail-value text-dark fw-normal">: <?= date('H:i', strtotime($dataReservasi['waktu_reservasi'])) ?> WIB</span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Layanan</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['nama_layanan']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Mekanik Ditugaskan</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['nama_mekanik']) ?></span>
        </div>
        <div class="detail-row">
            <span class="detail-label">Status Reservasi</span>
            <span class="detail-value text-dark fw-normal">:
                <span class="status-badge <?= getStatusClass($dataReservasi['status']) ?>">
                    <?= ucwords(str_replace('-', ' ', htmlspecialchars($dataReservasi['status']))) ?>
                </span>
            </span>
        </div>

        <hr class="divider">

        <!-- Informasi Pembayaran -->
        <div class="section-title">Informasi Pembayaran</div>
        <div class="detail-row">
            <span class="detail-label">Metode Pembayaran</span>
            <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['metode_pembayaran']) ?></span>
        </div>
        <?php if (!empty($dataReservasi['detail_bank'])): ?>
            <div class="detail-row">
                <span class="detail-label">Bank</span>
                <span class="detail-value text-dark fw-normal">: <?= htmlspecialchars($dataReservasi['detail_bank']) ?></span>
            </div>
        <?php endif; ?>

        <div class="total-section">
            <div class="detail-row total-row">
                <span class="detail-label">TOTAL HARGA LAYANAN</span>
                <span class="detail-value">: <?= formatRupiah($dataReservasi['total_harga']) ?></span>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted small">Terima kasih telah melakukan reservasi di bengkel kami.</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>