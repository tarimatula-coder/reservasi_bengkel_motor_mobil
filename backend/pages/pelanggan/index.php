<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../../config/connection.php';

// QUERY
$queryPelanggan = "SELECT 
        pelanggan.id AS id_pelanggan,
        pelanggan.nama AS nama_pelanggan,
        pelanggan.alamat AS alamat_pelanggan,
        pelanggan.no_hp AS no_hp_pelanggan,
        pelanggan.email AS email_pelanggan
    FROM pelanggan
    ORDER BY pelanggan.id DESC";

$resultPelanggan = mysqli_query($connect, $queryPelanggan) or die(mysqli_error($connect));
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
                    <h4 class="mt-3">Data Pelanggan</h4>
                    <a href="create.php" class="btn btn-danger btn-sm d-flex align-items-center">
                        <i class="fa fa-plus mr-2"></i> Tambah Pelanggan
                    </a>
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
                                            <th>Nama Pelanggan</th>
                                            <th>Alamat</th>
                                            <th>No HP</th>
                                            <th width="140">Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php if (mysqli_num_rows($resultPelanggan) > 0) {
                                            $no = 1;
                                            while ($data = mysqli_fetch_object($resultPelanggan)) { ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($data->nama_pelanggan ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($data->alamat_pelanggan ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($data->no_hp_pelanggan ?? '-') ?></td>
                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?= $data->id_pelanggan ?>" class="btn btn-warning btn-sm mb-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="../../actions/pelanggan/destroy.php?id=<?= $data->id_pelanggan ?>"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } else {
                                            echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data pelanggan</td></tr>";
                                        } ?>
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