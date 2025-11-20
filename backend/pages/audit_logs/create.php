<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Audit Logs</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form Tambah Audit Logs</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/audit_logs/store.php" method="POST">

                                <div class="mb-4">
                                    <label class="form-label">Action</label>
                                    <input type="text" class="form-control" name="action" required placeholder="Misal: create / update / delete">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Object Type</label>
                                    <input type="text" class="form-control" name="object_type" required placeholder="Misal: users / reservasi / mekanik">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Object ID</label>
                                    <input type="number" class="form-control" name="object_id" required placeholder="Masukan object id...">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Message</label>
                                    <input type="text" class="form-control" name="message" required placeholder="Masukan message...">
                                </div>

                                <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                                <a href="./index.php" class="btn btn-secondary">Kembali</a>

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