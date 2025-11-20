<?php
session_start();
include '../../../config/connection.php';

// CEK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: ../../pages/auth/login.php");
    exit;
}

$role = $_SESSION['role'];

include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';


$queryReservasi = " SELECT 
    reservasi.id AS id,
    reservasi.tanggal AS tanggal_reservasi,
    reservasi.waktu AS waktu_reservasi,
    reservasi.durasi_minutes AS durasi_reservasi,
    reservasi.status AS status_reservasi,
    reservasi.total_harga AS total_harga_reservasi,
    reservasi.catatan AS catatan_reservasi,
    
    pelanggan.nama AS nama_pelanggan,
    mekanik.nama AS nama_mekanik,
    layanan.nama_layanan
    
    FROM reservasi
    LEFT JOIN pelanggan ON reservasi.pelanggan_id = pelanggan.id
    LEFT JOIN mekanik ON reservasi.mekanik_id = mekanik.id
    LEFT JOIN layanan ON reservasi.layanan_id = layanan.id
    ORDER BY reservasi.id DESC
";

// Jalankan query
$resultReservasi = mysqli_query($connect, $queryReservasi) or die(mysqli_error($connect));
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
                    <h4 class="mt-3">Data Reservasi</h4>

                    <?php if ($role === 'admin') : ?>
                        <a href="create.php" class="btn btn-danger btn-sm d-flex align-items-center">
                            <span class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mr-2"
                                style="width:22px; height:22px;">
                                <i class="fa fa-plus"></i>
                            </span>
                            Tambah Reservasi
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
                                            <th>Waktu</th>
                                            <th>Durasi (menit)</th>
                                            <th>Status</th>
                                            <th>Total Harga</th>
                                            <th>Catatan</th>

                                            <?php if ($role === 'admin') : ?>
                                                <th>Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($resultReservasi) > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_object($resultReservasi)) {
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td class="text-center"><?= htmlspecialchars(substr($data->waktu_reservasi, 0, 5) ?? '-') ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($data->durasi_reservasi ?? '-') ?></td>

                                                    <td class="text-center">
                                                        <?php
                                                        $status = strtolower($data->status_reservasi);

                                                        if ($status == 'completed') {
                                                            echo "<span class='badge bg-success'>Selesai</span>";
                                                        } elseif ($status == 'in-progress') {
                                                            echo "<span class='badge bg-warning text-dark'>Sedang Dikerjakan</span>";
                                                        } elseif ($status == 'cancelled') {
                                                            echo "<span class='badge bg-danger'>Dibatalkan</span>";
                                                        } elseif ($status == 'confirmed' || $status == 'booked') {
                                                            echo "<span class='badge bg-primary'>Dikonfirmasi</span>";
                                                        } else {
                                                            echo "<span class='badge bg-secondary'>Menunggu</span>";
                                                        }
                                                        ?>
                                                    </td>

                                                    <td class="text-end">
                                                        <?= $data->total_harga_reservasi
                                                            ? 'Rp ' . number_format($data->total_harga_reservasi, 0, ',', '.')
                                                            : '-' ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($data->catatan_reservasi ?? '-') ?></td>

                                                    <?php if ($role === 'admin') : ?>
                                                        <td class="text-center">
                                                            <a href="edit.php?id=<?= $data->id ?>" class="btn btn-warning btn-sm">Edit</a>
                                                            <a href="../../actions/reservasi/destroy.php?id=<?= $data->id ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Yakin ingin menghapus reservasi ini?')">Hapus</a>
                                                        </td>
                                                    <?php endif; ?>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            $colspan = ($role === 'admin') ? 11 : 10;
                                            echo "<tr><td colspan='{$colspan}' class='text-center text-muted'>Tidak ada data reservasi</td></tr>";
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