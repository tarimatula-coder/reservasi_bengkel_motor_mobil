<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../../config/connection.php';

// Query view pendapatan bulanan
$sql = "SELECT 
            periode,
            jumlah_reservasi,
            total_pendapatan
        FROM view_pendapatan_bulanan
        ORDER BY periode DESC";

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
                                <h5 class="card-title mb-0">Data View Pendapatan Bulanan</h5>
                            </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Periode</th>
                                            <th>Jumlah Reservasi</th>
                                            <th>Total Pendapatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (mysqli_num_rows($result) > 0) {
                                            $no = 1;
                                            while ($row = mysqli_fetch_object($result)) { ?>

                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($row->periode) ?></td>
                                                    <td><?= htmlspecialchars($row->jumlah_reservasi) ?></td>
                                                    <td>
                                                        Rp <?= number_format($row->total_pendapatan, 0, ',', '.') ?>
                                                    </td>
                                                </tr>

                                            <?php }
                                        } else { ?>
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data</td>
                                            </tr>
                                        <?php } ?>
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
include '../../partials/script.php';
include '../../partials/footer.php';
?>