<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID audit logs tidak ditemukan');window.location.href='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

$q = mysqli_query($connect, "SELECT * FROM audit_logs WHERE id = $id");
$audit_logs = mysqli_fetch_object($q);

if (!$audit_logs) {
    echo "<script>alert('Data audit logs tidak ditemukan');window.location.href='index.php';</script>";
    exit;
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="page-header mb-3">
                <h2 class="pageheader-title">Edit Data Audit logs</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-4 p-3">
                        <div class="card-header">
                            <h4>Form Edit Audit logs</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/audit_logs/update.php?id=<?= $audit_logs->id ?>" method="post">

                                <!-- user -->
                                <div class="mb-4">
                                    <label class="form-label">User ID</label>
                                    <input type="number" class="form-control" name="user_id" placeholder="Masukan user id..." value="<?= htmlspecialchars($audit_logs->user_id) ?>" required>
                                </div>

                                <!-- action -->
                                <div class="mb-4">
                                    <label class="form-label">Action</label>
                                    <input type="text" class="form-control" name="action" placeholder="create / update / delete" value="<?= htmlspecialchars($audit_logs->action) ?>" required>
                                </div>

                                <!-- object type -->
                                <div class="mb-4">
                                    <label class="form-label">Object Type</label>
                                    <input type="text" class="form-control" name="object_type" placeholder="users / pemesanan / pembayaran..." value="<?= htmlspecialchars($audit_logs->object_type) ?>" required>
                                </div>

                                <!-- object id -->
                                <div class="mb-4">
                                    <label class="form-label">Object ID</label>
                                    <input type="number" class="form-control" name="object_id" placeholder="Masukan object id..." value="<?= htmlspecialchars($audit_logs->object_id) ?>" required>
                                </div>

                                <!-- message -->
                                <div class="mb-4">
                                    <label class="form-label">Message</label>
                                    <input type="text" class="form-control" name="message" placeholder="Masukan message..." value="<?= htmlspecialchars($audit_logs->message) ?>" required>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="index.php" class="btn btn-secondary">Kembali</a>
                                </div>
                            </form>
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