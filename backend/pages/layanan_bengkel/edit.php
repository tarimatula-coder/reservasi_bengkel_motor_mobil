<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Cek apakah ada ID layanan di URL
if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('ID layanan tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Query ambil data layanan
$queryLayanan = "
    SELECT 
        id,
        nama_layanan,
        kategori,
        durasi_minutes,
        harga,
        deskripsi
    FROM layanan
    WHERE id = $id
";
$result = mysqli_query($connect, $queryLayanan);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "
    <script>
        alert('Data layanan tidak ditemukan');
        window.location.href='index.php';
    </script>";
    exit;
}

$layanan = mysqli_fetch_object($result);
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Header halaman -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Layanan</h2>
                    </div>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-4 p-3 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Layanan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/layanan_bengkel/update.php" method="POST">

                                <input type="hidden" name="layanan_id" value="<?= $layanan->id ?>">

                                <!-- Nama Layanan -->
                                <div class="mb-4">
                                    <label for="nama_layanan" class="form-label fw-semibold">Nama Layanan</label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan"
                                        value="<?= htmlspecialchars($layanan->nama_layanan) ?>" required>
                                </div>

                                <!-- Kategori -->
                                <div class="mb-4">
                                    <label for="kategori" class="form-label fw-semibold">Kategori</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori"
                                        value="<?= htmlspecialchars($layanan->kategori) ?>" required>
                                </div>

                                <!-- Durasi -->
                                <div class="mb-4">
                                    <label for="durasi_minutes" class="form-label fw-semibold">Durasi (menit)</label>
                                    <input type="number" class="form-control" id="durasi_minutes" name="durasi_minutes"
                                        value="<?= htmlspecialchars($layanan->durasi_minutes) ?>" required>
                                </div>

                                <!-- Harga -->
                                <div class="mb-4">
                                    <label for="harga" class="form-label fw-semibold">Harga (Rp)</label>
                                    <input type="text" class="form-control" id="harga" name="harga"
                                        value="<?= number_format($layanan->harga, 0, ',', '.') ?>" required>
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"
                                        placeholder="Masukkan deskripsi..."><?= htmlspecialchars($layanan->deskripsi) ?></textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" name="tombol" class="btn btn-success px-4">Simpan Perubahan</button>
                                    <a href="./index.php" class="btn btn-secondary px-4">Kembali</a>
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
<!-- Script format angka -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hargaInput = document.getElementById("harga");

        // Format angka jadi format ribuan (titik)
        hargaInput.addEventListener("input", function() {
            let value = this.value.replace(/\D/g, ""); // hapus semua selain angka
            if (!value) {
                this.value = "";
                return;
            }
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        // Saat submit form, ubah nilai agar titik dihapus sebelum dikirim
        const form = hargaInput.closest("form");
        form.addEventListener("submit", function() {
            hargaInput.value = hargaInput.value.replace(/\./g, "");
        });
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>