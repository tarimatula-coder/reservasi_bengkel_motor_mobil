<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ada parameter ID di URL
if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('ID pelanggan tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data pelanggan berdasarkan ID
$query = $connect->query("
    SELECT 
        id,
        nama,
        no_hp,
        email,
        alamat
    FROM pelanggan
    WHERE id = $id
");

$pelanggan = $query->fetch_object();

// Jika tidak ditemukan
if (!$pelanggan) {
    echo "
    <script>
        alert('Data pelanggan tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Pelanggan</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Pelanggan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/pelanggan/update.php?id=<?= $pelanggan->id ?>" method="POST">

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama"
                                        value="<?= htmlspecialchars($pelanggan->nama ?? '') ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">No HP</label>
                                    <input type="text" class="form-control" name="no_hp"
                                        value="<?= htmlspecialchars($pelanggan->no_hp ?? '') ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Email</label>
                                    <input type="email" class="form-control" name="email"
                                        value="<?= htmlspecialchars($pelanggan->email ?? '') ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Alamat</label>
                                    <textarea class="form-control" rows="4"
                                        name="alamat" required><?= htmlspecialchars($pelanggan->alamat ?? '') ?></textarea>
                                </div>


                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-success px-4">
                                        <i class="fa fa-save me-2"></i> Simpan
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