<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID kendaraan tidak ditemukan'); window.location.href='index.php';</script>";
    exit;
}
$id = intval($_GET['id']);
$qKendaraan = $connect->query("SELECT * FROM kendaraan WHERE id=$id");
$kendaraan = $qKendaraan->fetch_object();
if (!$kendaraan) {
    echo "<script>alert('Data kendaraan tidak ditemukan'); window.location.href='index.php';</script>";
    exit;
}

$qPelanggan = $connect->query("SELECT id, nama FROM pelanggan ORDER BY nama ASC");
?>
<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Kendaraan</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form edit Kendaraan</h4>
                        </div>
                        <div class="card-body">
                            <form action="../../actions/kendaraan/update.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_kendaraan" value="<?= $kendaraan->id ?>">
                                <div class="mb-3">
                                    <label>Nama Pelanggan</label>
                                    <select name="pelanggan_id" class="form-control" required>
                                        <?php while ($p = $qPelanggan->fetch_object()): ?>
                                            <option value="<?= $p->id ?>" <?= $p->id == $kendaraan->pelanggan_id ? 'selected' : '' ?>><?= htmlspecialchars($p->nama) ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="mb-3"><label>Jenis</label><input type="text" name="jenis" class="form-control" value="<?= htmlspecialchars($kendaraan->jenis) ?>" required></div>
                                <div class="mb-3"><label>Merk</label><input type="text" name="merk" class="form-control" value="<?= htmlspecialchars($kendaraan->merk) ?>" required></div>
                                <div class="mb-3"><label>Model</label><input type="text" name="model" class="form-control" value="<?= htmlspecialchars($kendaraan->model) ?>" required></div>
                                <div class="mb-3"><label>Plat Nomor</label><input type="text" name="plat_nomor" class="form-control" value="<?= htmlspecialchars($kendaraan->plat_nomor) ?>" required></div>
                                <div class="mb-3"><label>Tahun</label><input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($kendaraan->tahun) ?>" required></div>
                                <div class="mb-3"><label>Catatan</label><textarea name="catatan" class="form-control"><?= htmlspecialchars($kendaraan->catatan) ?></textarea></div>
                                <div class="mb-3">
                                    <label>Gambar Kendaraan</label>
                                    <?php if (!empty($kendaraan->image) && file_exists("../../../storages/kendaraan/" . $kendaraan->image)): ?>
                                        <div class="mb-2"><img src="../../../storages/kendaraan/<?= $kendaraan->image ?>" class="w-25"></div>
                                    <?php endif; ?>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <button type="submit" name="tombol" class="btn btn-success">Simpan Perubahan</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
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