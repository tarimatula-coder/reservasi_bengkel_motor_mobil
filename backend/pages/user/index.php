<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Query tabel users
$sql = "SELECT 
            id,
            username,
            role,
            full_name,
            phone,
            email,
            is_active
        FROM users
        ORDER BY id DESC";

$result = mysqli_query($connect, $sql);
if (!$result) {
    die("Query error: " . mysqli_error($connect));
}
?>
<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="d-flex justify-content-between mb-3 mt-3">
                <h5 class="mb-0">Data Users</h5>
                <a href="create.php" class="btn btn-danger btn-sm">
                    <i class="fa fa-plus mr-1"></i> Tambah User
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th>No</th>
                                    <th>Username</th>
                                    <th>Nama Lengkap</th>
                                    <th>Role</th>
                                    <th>No HP</th>
                                    <th>Email</th>
                                    <th>Status</th>
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
                                            <td><?= htmlspecialchars($row->username) ?></td>
                                            <td><?= htmlspecialchars($row->full_name) ?></td>
                                            <td><?= htmlspecialchars(ucfirst($row->role)) ?></td>
                                            <td><?= htmlspecialchars($row->phone) ?></td>
                                            <td><?= htmlspecialchars($row->email) ?></td>
                                            <td>
                                                <?= $row->is_active == 1
                                                    ? '<span class="badge badge-success">Aktif</span>'
                                                    : '<span class="badge badge-danger">Non Aktif</span>' ?>
                                            </td>
                                            <!-- Tombol Aksi -->
                                            <td class="text-center">
                                                <a href="edit.php?id=<?= $row->id ?>" class="btn btn-warning btn-sm mb-1">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>

                                                <a href="../../actions/user/destroy.php?id=<?= $row->id ?>"
                                                    class="btn btn-danger btn-sm mb-1"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center'>Tidak ada data user</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

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
include '../../partials/footer.php';
include '../../partials/script.php';
?>