<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// query laporan
$sql = "SELECT 
            laporan.id,
            laporan.periode,
            laporan.jumlah_reservasi,
            laporan.total_pendapatan,
            laporan.dibuat_oleh
        FROM laporan
        ORDER BY laporan.id DESC";

$result = mysqli_query($connect, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($connect));
}
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="min-height:600px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title mb-0">Data Laporan</h5>
                                <a href="create.php" class="btn btn-danger btn-sm">
                                    <i class="fa fa-plus mr-2"></i> Tambah Laporan
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Periode</th>
                                            <th>Jumlah Reservasi</th>
                                            <th>Total Pendapatan</th>
                                            <th>Dibuat Oleh</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            $no = 1;
                                            while ($row = mysqli_fetch_object($result)) {
                                        ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($row->periode ?? '') ?></td>
                                                    <td><?= htmlspecialchars($row->jumlah_reservasi ?? '') ?></td>

                                                    <!-- FORMAT NOMINAL SEPERTI LAYANAN -->
                                                    <td class="text-end">
                                                        Rp <?= number_format($row->total_pendapatan, 0, ',', '.') ?>
                                                    </td>

                                                    <td><?= htmlspecialchars($row->dibuat_oleh ?? '') ?></td>

                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?= $row->id ?>" class="btn btn-warning btn-sm mb-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>

                                                        <a href="../../actions/laporan/destroy.php?id=<?= $row->id ?>"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center'>Tidak ada data laporan</td></tr>";
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