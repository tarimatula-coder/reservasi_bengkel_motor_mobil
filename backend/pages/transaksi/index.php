<?php
session_start();
include '../../../config/connection.php'; // Pastikan file koneksi dan sesi disertakan

// CEK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: ../../pages/auth/login.php");
    exit;
}

$role = $_SESSION['role']; // Ambil peran user yang sedang login
// Pastikan mengambil user_id dari sesi, ini penting untuk memfilter data Pelanggan
$user_id = $_SESSION['id_user'] ?? null;

include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// 🔹 Query ambil semua data transaksi dengan relasi lengkap
$queryTransaksi = "SELECT 
        transaksi.id AS id_transaksi,
        transaksi.reservasi_id,
        transaksi.tipe_pembayaran,
        transaksi.nominal,
        transaksi.tanggal_pembayaran,
        transaksi.status AS status_transaksi,
        transaksi.bukti_transfer,
        reservasi.tanggal AS tanggal_reservasi,
        reservasi.waktu AS waktu_reservasi,
        reservasi.total_harga,
        pelanggan.nama AS nama_pelanggan,
        layanan.nama_layanan AS nama_layanan,
        mekanik.nama AS nama_mekanik
    FROM transaksi
    LEFT JOIN reservasi ON transaksi.reservasi_id = reservasi.id
    LEFT JOIN pelanggan ON reservasi.pelanggan_id = pelanggan.id
    LEFT JOIN layanan ON reservasi.layanan_id = layanan.id
    LEFT JOIN mekanik ON reservasi.mekanik_id = mekanik.id
    WHERE 1=1"; // Kondisi awal untuk memudahkan penambahan filter

// ➡️ FILTER KHUSUS UNTUK PERAN PELANGGAN
if ($role === 'pelanggan' && $user_id) {
    // Diasumsikan tabel 'pelanggan' memiliki kolom 'user_id' yang terhubung ke $_SESSION['id_user']
    // Jika struktur database Anda berbeda, Anda perlu menyesuaikan bagian WHERE ini.
    $queryTransaksi .= " AND pelanggan.user_id = '$user_id'";
}

$queryTransaksi .= " ORDER BY transaksi.id DESC";

$resultTransaksi = mysqli_query($connect, $queryTransaksi) or die(mysqli_error($connect));
?>

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

            <div class="row mb-3">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h4 class="mt-3">Data Transaksi</h4>

                    <?php if ($role !== 'pelanggan') : ?>
                        <a href="create.php" class="btn btn-danger btn-sm d-flex align-items-center">
                            <span class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mr-2"
                                style="width:22px; height:22px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Transaksi
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Pembayaran</th>
                                            <th>Tipe Pembayaran</th>
                                            <th>Nominal</th>
                                            <th>Status</th>
                                            <th>Bukti Transfer</th>
                                            <?php if ($role !== 'pelanggan') : ?>
                                                <th>Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($resultTransaksi) > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_object($resultTransaksi)) {
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($data->tanggal_pembayaran ?? '-') ?></td>
                                                    <td class="text-center"><?= htmlspecialchars(ucfirst($data->tipe_pembayaran ?? '-')) ?></td>

                                                    <td class="text-end">
                                                        <?= $data->nominal
                                                            ? 'Rp ' . number_format($data->nominal, 0, ',', '.')
                                                            : '-' ?>
                                                    </td>

                                                    <td class="text-center">
                                                        <?php
                                                        $status = $data->status_transaksi ?? '';
                                                        $badgeClass = match ($status) {
                                                            'confirmed' => 'bg-success',
                                                            'pending' => 'bg-warning',
                                                            'rejected' => 'bg-danger',
                                                            default => 'bg-light text-dark'
                                                        };
                                                        $statusText = match ($status) {
                                                            'confirmed' => 'Berhasil',
                                                            'pending' => 'Pending',
                                                            'rejected' => 'Ditolak',
                                                            default => '-'
                                                        };
                                                        ?>
                                                        <span class="badge <?= $badgeClass ?>"><?= $statusText ?></span>
                                                    </td>

                                                    <td class="text-center">
                                                        <?php if (!empty($data->bukti_transfer)) : ?>
                                                            <img src="../../../storages/bukti_transfer/<?= htmlspecialchars($data->bukti_transfer) ?>"
                                                                alt="Bukti Transfer"
                                                                style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                                                        <?php else : ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <?php if ($role !== 'pelanggan') : ?>
                                                        <td class="text-center">
                                                            <a href="edit.php?id=<?= $data->id_transaksi ?>" class="btn btn-warning btn-sm mb-1">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <a href="../../actions/transaksi/destroy.php?id=<?= $data->id_transaksi ?>"
                                                                class="btn btn-danger btn-sm mb-1"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </a>
                                                        </td>
                                                    <?php endif; ?>

                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            // Menghitung colspan yang benar: 6 kolom data + 1 kolom aksi (jika ada)
                                            $colspan = ($role !== 'pelanggan') ? 7 : 6;
                                            echo "<tr><td colspan='$colspan' class='text-center text-muted'>Tidak ada riwayat transaksi</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="overlay toggle-menu"></div>
        </div>
    </div>
</div>
<style>
    html,
    body {
        height: 100%;
    }

    #wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content-wrapper {
        flex: 1;
    }
</style>


<?php
include '../../partials/script.php';
include '../../partials/footer.php';
?>