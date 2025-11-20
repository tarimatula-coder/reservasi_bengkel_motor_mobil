<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data users untuk dropdown
$qUsers = mysqli_query($connect, "SELECT id, username FROM users ORDER BY username ASC");
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Judul Halaman -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Mekanik</h2>
                        <p class="pageheader-text">Isi formulir di bawah ini untuk menambahkan data mekanik baru.</p>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Mekanik -->
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Tambah Mekanik</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/mekanik/store.php" method="POST">

                                <!-- assign ke user -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">User ID (Akun Login)</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">-- pilih user --</option>
                                        <?php while ($u = mysqli_fetch_assoc($qUsers)) { ?>
                                            <option value="<?= $u['id'] ?>">
                                                <?= htmlspecialchars($u['username']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Nama Mekanik -->
                                <div class="mb-4">
                                    <label for="nama" class="form-label fw-semibold">Nama Mekanik</label>
                                    <input type="text" class="form-control" id="nama" name="nama"
                                        placeholder="Masukkan nama mekanik" required>
                                </div>

                                <!-- Skill Mekanik -->
                                <div class="mb-4">
                                    <label for="skill" class="form-label fw-semibold">Skill / Keahlian</label>
                                    <input type="text" class="form-control" id="skill" name="skill"
                                        placeholder="Masukkan keahlian mekanik" required>
                                </div>

                                <!-- Nomor Telepon -->
                                <div class="mb-4">
                                    <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Masukkan nomor telepon mekanik" required>
                                </div>

                                <!-- is available -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Ketersediaan</label>
                                    <select name="is_available" class="form-control" required>
                                        <option value="1">Available</option>
                                        <option value="0">Not Available</option>
                                    </select>
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