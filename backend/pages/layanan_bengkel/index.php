<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Query relasi antara tabel layanan dan reservasi
$queryLayanan = "
    SELECT 
        layanan.id AS id_layanan,
        layanan.nama_layanan,
        layanan.kategori,
        layanan.durasi_minutes AS durasi_layanan,
        layanan.harga AS harga_layanan,
        layanan.deskripsi,
        reservasi.id AS id_reservasi,
        reservasi.tanggal,
        reservasi.waktu,
        reservasi.durasi_minutes AS durasi_reservasi,
        reservasi.status,
        reservasi.total_harga,
        reservasi.catatan AS catatan_reservasi
    FROM layanan
    LEFT JOIN reservasi 
        ON reservasi.layanan_id = layanan.id
    ORDER BY layanan.id DESC
";

$resultLayanan = mysqli_query($connect, $queryLayanan) or die(mysqli_error($connect));
?>

<!-- start loader -->
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

            <!-- Judul dan tombol tambah -->
            <div class="row mb-3">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h4 class="mt-3">Data Layanan Bengkel</h4>
                    <a href="create.php" class="btn btn-danger btn-sm d-flex align-items-center">
                        <span class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center me-2"
                            style="width:22px; height:22px;">
                            <i class="fa fa-plus"></i>
                        </span>
                        Tambah Layanan
                    </a>
                </div>
            </div>

            <!-- Tabel data layanan -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-striped align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Layanan</th>
                                            <th>Kategori</th>
                                            <th>Durasi Layanan (Menit)</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($resultLayanan) > 0) {
                                            $no = 1;
                                            while ($layanan = mysqli_fetch_object($resultLayanan)) {
                                        ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($layanan->nama_layanan) ?></td>
                                                    <td><?= htmlspecialchars($layanan->kategori) ?></td>
                                                    <td class="text-center"><?= htmlspecialchars($layanan->durasi_layanan) ?></td>
                                                    <td class="text-end">Rp <?= number_format($layanan->harga_layanan, 0, ',', '.') ?></td>

                                                    <!-- Tombol Aksi -->
                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?= $layanan->id_layanan ?>" class="btn btn-warning btn-sm mb-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="../../actions/layanan_bengkel/destroy.php?id=<?= $layanan->id_layanan ?>"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='13' class='text-center text-muted'>Belum ada data layanan</td></tr>";
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

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>