<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// query kendaraan saja
$sql = "SELECT 
            audit_logs.id,
            audit_logs.user_id,
            audit_logs.action,
            audit_logs.object_type,
            audit_logs.object_id,
            audit_logs.message
        FROM audit_logs
        ORDER BY audit_logs.id DESC";

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
                                <h5 class="card-title mb-0">Data Audit logs</h5>
                                <a href="create.php" class="btn btn-success btn-sm">
                                    <i class="fa fa-plus mr-2"></i> Tambah Audit logs
                                </a>
                            </div>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Action</th>
                                            <th>Object type</th>
                                            <th>Object id</th>
                                            <th>Message</th>
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
                                                    <td><?= htmlspecialchars($row->action) ?></td>
                                                    <td><?= htmlspecialchars($row->object_type) ?></td>
                                                    <td><?= htmlspecialchars($row->object_id) ?></td>
                                                    <td><?= htmlspecialchars($row->message) ?></td>
                                                    <td>
                                                        <a href="edit.php?id=<?= $row->id ?>" class="btn btn-warning btn-sm">Edit</a>
                                                        <a href="delete.php?id=<?= $row->id ?>" onclick="return confirm('Hapus data ini?')" class="btn btn-danger btn-sm">Hapus</a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            echo "<tr><td colspan='8' class='text-center'>Tidak ada data kendaraan</td></tr>";
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
include '../../partials/script.php';
include '../../partials/footer.php';
?>