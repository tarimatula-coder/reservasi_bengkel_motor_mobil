<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ada ID di URL
if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('ID kendaraan tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data kendaraan berdasarkan ID
$qKendaraan = $connect->query("SELECT 
        k.id,
        k.pelanggan_id,
        k.jenis,
        k.merk,
        k.model,
        k.plat_nomor,
        k.tahun,
        k.catatan,
        p.nama AS nama_pelanggan
    FROM kendaraan k
    LEFT JOIN pelanggan p ON p.id = k.pelanggan_id
    WHERE k.id = $id
");

$kendaraan = $qKendaraan->fetch_object();
if (!$kendaraan) {
    echo "
    <script>
        alert('Data kendaraan tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

// Ambil data pelanggan untuk dropdown
$qPelanggan = $connect->query("SELECT id, nama FROM pelanggan ORDER BY nama ASC");
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Kendaraan</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-4 p-3">
                        <div class="card-header">
                            <h4>Form Edit Kendaraan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/kendaraan/update.php" method="POST">

                                <!-- ID kendaraan (hidden input) -->
                                <input type="hidden" name="id_kendaraan" value="<?= htmlspecialchars($kendaraan->id) ?>">

                                <!-- Pilih Pelanggan -->
                                <div class="mb-4">
                                    <label for="pelanggan_id" class="form-label">Nama Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        <?php while ($p = $qPelanggan->fetch_object()): ?>
                                            <option value="<?= $p->id ?>" <?= $p->id == $kendaraan->pelanggan_id ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($p->nama) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Jenis Kendaraan -->
                                <div class="mb-4">
                                    <label for="jenis" class="form-label">Jenis Kendaraan</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis"
                                        value="<?= htmlspecialchars($kendaraan->jenis) ?>" required>
                                </div>

                                <!-- Merk -->
                                <div class="mb-4">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" class="form-control" id="merk" name="merk"
                                        value="<?= htmlspecialchars($kendaraan->merk) ?>" required>
                                </div>

                                <!-- Model -->
                                <div class="mb-4">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control" id="model" name="model"
                                        value="<?= htmlspecialchars($kendaraan->model) ?>" required>
                                </div>

                                <!-- Plat Nomor -->
                                <div class="mb-4">
                                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                                    <input type="text" class="form-control" id="plat_nomor" name="plat_nomor"
                                        value="<?= htmlspecialchars($kendaraan->plat_nomor) ?>" required>
                                </div>

                                <!-- Tahun -->
                                <div class="mb-4">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun"
                                        value="<?= htmlspecialchars($kendaraan->tahun) ?>" required>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-4">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="4"
                                        placeholder="Masukkan catatan tambahan..."><?= htmlspecialchars($kendaraan->catatan) ?></textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="tombol" class="btn btn-success">Simpan Perubahan</button>
                                    <a href="./index.php" class="btn btn-secondary">Kembali</a>
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