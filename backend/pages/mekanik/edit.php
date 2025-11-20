<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['id'])) {
    echo "<script>
            alert('ID mekanik tidak ditemukan!');
            window.location.href='index.php';
          </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data mekanik
$queryMekanik = $connect->query("
    SELECT id, user_id, nama, skill, phone, is_available 
    FROM mekanik 
    WHERE id = $id
");

$mekanik = $queryMekanik->fetch_object();

if (!$mekanik) {
    echo "<script>
            alert('Data mekanik tidak ditemukan!');
            window.location.href='index.php';
          </script>";
    exit;
}

// Ambil list user untuk dropdown
$qUsers = mysqli_query($connect, "SELECT id, username FROM users ORDER BY username ASC");
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Mekanik</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">

                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Mekanik</h4>
                        </div>

                        <div class="card-body">

                            <form action="../../actions/mekanik/update.php" method="POST">

                                <input type="hidden" name="id" value="<?= $mekanik->id ?>">

                                <!-- User Akun Login -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">User (Akun Login)</label>
                                    <select name="user_id" class="form-control" required>
                                        <option value="">-- pilih user --</option>
                                        <?php while ($u = mysqli_fetch_assoc($qUsers)) { ?>
                                            <option value="<?= $u['id'] ?>"
                                                <?= ($mekanik->user_id == $u['id']) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($u['username']) ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <!-- Nama -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nama Mekanik</label>
                                    <input type="text" class="form-control" name="nama"
                                        value="<?= htmlspecialchars($mekanik->nama) ?>" required>
                                </div>

                                <!-- Skill -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Skill / Keahlian</label>
                                    <input type="text" class="form-control" name="skill"
                                        value="<?= htmlspecialchars($mekanik->skill) ?>" required>
                                </div>

                                <!-- Telepon -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="<?= htmlspecialchars($mekanik->phone) ?>" required>
                                </div>

                                <!-- Ketersediaan -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Status Ketersediaan</label>
                                    <select name="is_available" class="form-control" required>
                                        <option value="1" <?= $mekanik->is_available == 1 ? 'selected' : '' ?>>Available</option>
                                        <option value="0" <?= $mekanik->is_available == 0 ? 'selected' : '' ?>>Not Available</option>
                                    </select>
                                </div>

                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fa fa-save me-2"></i> Simpan Perubahan
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