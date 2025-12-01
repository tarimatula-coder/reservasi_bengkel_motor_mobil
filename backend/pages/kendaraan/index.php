<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Query kendaraan + pelanggan
$sql = "SELECT 
            k.id,
            k.jenis,
            k.merk,
            k.model,
            k.plat_nomor,
            k.tahun,
            k.image,
            k.catatan,
            p.nama AS nama_pelanggan
        FROM kendaraan k
        LEFT JOIN pelanggan p ON k.pelanggan_id = p.id
        ORDER BY k.id DESC";

$result = mysqli_query($connect, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($connect));
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="card" style="min-height:600px;">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <h5 class="card-title mb-0">Data Kendaraan</h5>
                                <a href="create.php" class="btn btn-danger btn-sm">
                                    <i class="fa fa-plus mr-2"></i> Tambah Kendaraan
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Jenis</th>
                                            <th>Merk</th>
                                            <th>Model</th>
                                            <th>Gambar</th>
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
                                                    <td class="text-center"><?= $no++ ?></td>
                                                    <td><?= htmlspecialchars($row->nama_pelanggan ?? '-') ?></td>
                                                    <td><?= htmlspecialchars($row->jenis) ?></td>
                                                    <td><?= htmlspecialchars($row->merk) ?></td>
                                                    <td><?= htmlspecialchars($row->model) ?></td>
                                                    <td class="text-center">
                                                        <img src="../../../storages/kendaraan/<?= $row->image ?>" alt="Gambar" width="100" height="100">
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?= $row->id ?>" class="btn btn-warning btn-sm">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="../../actions/kendaraan/destroy.php?id=<?= $row->id ?>"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='9' class='text-center'>Tidak ada data kendaraan</td></tr>";
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