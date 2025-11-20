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
                        <h2 class="pageheader-title">Tambah Data Users</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form Tambah Users</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/user/store.php" method="post">

                                <div class="mb-4">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Role</label>
                                    <select class="form-control" name="role" required>
                                        <option value="">-- Pilih Role --</option>
                                        <option value="admin">Admin</option>
                                        <option value="pelanggan">Pelanggan</option>
                                        <option value="mekanik">Mekanik</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Status Aktif</label>
                                    <select class="form-control" name="is_active" required>
                                        <option value="1">Aktif</option>
                                        <option value="0">Non Aktif</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-success">Tambah</button>
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