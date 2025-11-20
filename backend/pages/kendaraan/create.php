<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data pelanggan untuk dropdown
$qPelanggan = $connect->query("SELECT id, nama FROM pelanggan ORDER BY nama ASC");

// Jika form disubmit
if (isset($_POST['tombol'])) {
    $pelanggan_id = trim($_POST['pelanggan_id']);
    $jenis        = trim($_POST['jenis']);
    $merk         = trim($_POST['merk']);
    $model        = trim($_POST['model']);
    $plat_nomor   = trim($_POST['plat_nomor']);
    $tahun        = trim($_POST['tahun']);
    $catatan      = trim($_POST['catatan']);

    // Validasi
    if (
        empty($pelanggan_id) || empty($jenis) || empty($merk) ||
        empty($model) || empty($plat_nomor) || empty($tahun)
    ) {
        echo "<script>alert('Semua field wajib diisi!');</script>";
    } else {
        // Simpan ke database
        $stmt = $connect->prepare("
            INSERT INTO kendaraan (pelanggan_id, jenis, merk, model, plat_nomor, tahun, catatan)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("issssis", $pelanggan_id, $jenis, $merk, $model, $plat_nomor, $tahun, $catatan);

        if ($stmt->execute()) {
            echo "
            <script>
                alert('Data kendaraan berhasil ditambahkan!');
                window.location.href='index.php';
            </script>";
        } else {
            echo "<script>alert('Gagal menambahkan data kendaraan!');</script>";
        }
        $stmt->close();
    }
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Kendaraan</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form Tambah Kendaraan</h4>
                        </div>

                        <div class="card-body">
                            <form method="post">

                                <!-- Nama Pelanggan -->
                                <div class="mb-4">
                                    <label for="pelanggan_id" class="form-label">Nama Pelanggan</label>
                                    <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        <?php
                                        if ($qPelanggan && $qPelanggan->num_rows > 0) {
                                            while ($row = $qPelanggan->fetch_object()) {
                                                echo "<option value='{$row->id}'>" . htmlspecialchars($row->nama) . "</option>";
                                            }
                                        } else {
                                            echo "<option disabled>Tidak ada pelanggan</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Jenis -->
                                <div class="mb-4">
                                    <label for="jenis" class="form-label">Jenis</label>
                                    <input type="text" class="form-control" id="jenis" name="jenis" placeholder="Contoh: Mobil / Motor" required>
                                </div>

                                <!-- Merk -->
                                <div class="mb-4">
                                    <label for="merk" class="form-label">Merk</label>
                                    <input type="text" class="form-control" id="merk" name="merk" placeholder="Contoh: Toyota / Honda" required>
                                </div>

                                <!-- Model -->
                                <div class="mb-4">
                                    <label for="model" class="form-label">Model</label>
                                    <input type="text" class="form-control" id="model" name="model" placeholder="Contoh: Avanza / Beat" required>
                                </div>

                                <!-- Plat Nomor -->
                                <div class="mb-4">
                                    <label for="plat_nomor" class="form-label">Plat Nomor</label>
                                    <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" placeholder="Contoh: B 1234 XYZ" required>
                                </div>

                                <!-- Tahun -->
                                <div class="mb-4">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Contoh: 2020" required>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-4">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" placeholder="Masukkan catatan tambahan..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                                <a href="index.php" class="btn btn-secondary">Kembali</a>

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