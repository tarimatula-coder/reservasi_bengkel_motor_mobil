<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Pelanggan</h2>
                        <p class="pageheader-text">Isi formulir di bawah ini untuk menambahkan data pelanggan baru.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Tambah Pelanggan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/pelanggan/store.php" method="POST">

                                <!-- Nama Pelanggan -->
                                <div class="mb-4">
                                    <label for="nama" class="form-label fw-semibold">Nama Pelanggan</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama pelanggan..." required>
                                </div>

                                <!-- No HP -->
                                <div class="mb-4">
                                    <label for="no_hp" class="form-label fw-semibold">No HP</label>
                                    <input type="number" class="form-control" id="no_hp" name="no_hp" placeholder="Masukkan no hp..." required>
                                </div>

                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email pelanggan..." required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-4">
                                    <label for="alamat" class="form-label fw-semibold">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat pelanggan..." rows="4" required></textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-success px-4" name="tombol">
                                        <i class="fa fa-save me-2"></i> Tambah
                                    </button>
                                    <a href="./index.php" class="btn btn-secondary px-4">
                                        <i class="fa fa-arrow-left me-2"></i> Kembali
                                    </a>
                                </div>

                            </form>
                        </div>
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