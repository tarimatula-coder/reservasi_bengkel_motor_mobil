<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ada ID
if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID jadwal servis tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data reservasi berdasarkan ID
$query = $connect->query("
    SELECT * FROM reservasi WHERE id = $id
");
$reservasi = $query->fetch_object();

if (!$reservasi) {
    echo "<script>
        alert('Data jadwal servis tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}

// Ambil data dropdown dari tabel lain
$pelanggan = $connect->query("SELECT id, nama FROM pelanggan ORDER BY nama ASC");
$mekanik = $connect->query("SELECT id, nama FROM mekanik ORDER BY nama ASC");
$layanan = $connect->query("SELECT id, nama_layanan FROM layanan ORDER BY nama_layanan ASC");
$kendaraan = $connect->query("SELECT id, plat_nomor FROM kendaraan ORDER BY plat_nomor ASC");
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Judul Halaman -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <h2 class="pageheader-title">Edit Data Jadwal servis</h2>
                    <p class="pageheader-text">Perbarui informasi jadwal servis sesuai kebutuhan.</p>
                </div>
            </div>

            <!-- Form Edit -->
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Jadwal servis</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/jadwal_servis/update.php" method="POST">

                                <input type="hidden" name="id" value="<?= $reservasi->id ?>">

                                <!-- Pelanggan -->
                                <div class="mb-3">
                                    <label for="pelanggan_id" class="form-label">Pelanggan</label>
                                    <select class="form-control" id="pelanggan_id" name="pelanggan_id" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        <?php while ($p = $pelanggan->fetch_object()) : ?>
                                            <option value="<?= $p->id ?>" <?= ($p->id == $reservasi->pelanggan_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($p->nama) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Mekanik -->
                                <div class="mb-3">
                                    <label for="mekanik_id" class="form-label">Mekanik</label>
                                    <select class="form-control" id="mekanik_id" name="mekanik_id" required>
                                        <option value="">-- Pilih Mekanik --</option>
                                        <?php while ($m = $mekanik->fetch_object()) : ?>
                                            <option value="<?= $m->id ?>" <?= ($m->id == $reservasi->mekanik_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($m->nama) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Kendaraan -->
                                <div class="mb-3">
                                    <label for="kendaraan_id" class="form-label">Kendaraan</label>
                                    <select class="form-control" id="kendaraan_id" name="kendaraan_id" required>
                                        <option value="">-- Pilih Kendaraan --</option>
                                        <?php while ($k = $kendaraan->fetch_object()) : ?>
                                            <option value="<?= $k->id ?>" <?= ($k->id == $reservasi->kendaraan_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($k->plat_nomor) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Layanan -->
                                <div class="mb-3">
                                    <label for="layanan_id" class="form-label">Layanan</label>
                                    <select class="form-control" id="layanan_id" name="layanan_id" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        <?php while ($l = $layanan->fetch_object()) : ?>
                                            <option value="<?= $l->id ?>" <?= ($l->id == $reservasi->layanan_id) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($l->nama_layanan) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Tanggal Reservasi -->
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Reservasi</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="<?= htmlspecialchars($reservasi->tanggal) ?>" required>
                                </div>

                                <!-- Waktu Reservasi -->
                                <div class="mb-3">
                                    <label for="waktu" class="form-label">Waktu Reservasi</label>
                                    <input type="time" class="form-control" id="waktu" name="waktu"
                                        value="<?= htmlspecialchars($reservasi->waktu) ?>" required>
                                </div>

                                <!-- Durasi -->
                                <div class="mb-3">
                                    <label for="durasi_minutes" class="form-label">Durasi (menit)</label>
                                    <input type="number" class="form-control" id="durasi_minutes" name="durasi_minutes"
                                        value="<?= htmlspecialchars($reservasi->durasi_minutes) ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Harga (Rp)</label>
                                    <input type="text" class="form-control" id="total_harga" name="total_harga"
                                        value="<?= number_format($reservasi->total_harga, 0, ',', '.') ?>" required>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="booked" <?= $reservasi->status == 'booked' ? 'selected' : '' ?>>Menunggu</option>
                                        <option value="confirmed" <?= $reservasi->status == 'confirmed' ? 'selected' : '' ?>>Dikonfirmasi</option>
                                        <option value="in-progress" <?= $reservasi->status == 'in-progress' ? 'selected' : '' ?>>Sedang Dikerjakan</option>
                                        <option value="completed" <?= $reservasi->status == 'completed' ? 'selected' : '' ?>>Selesai</option>
                                        <option value="cancelled" <?= $reservasi->status == 'cancelled' ? 'selected' : '' ?>>Dibatalkan</option>
                                    </select>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"><?= htmlspecialchars($reservasi->catatan) ?></textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="tombol" class="btn btn-success">
                                        <i class="fa fa-save me-2"></i> Simpan Perubahan
                                    </button>
                                    <a href="./index.php" class="btn btn-secondary">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hargaInput = document.getElementById("total_harga");

        hargaInput.addEventListener("input", function(e) {
            // Hapus semua karakter non-angka
            let value = this.value.replace(/\D/g, "");

            // Format angka dengan titik setiap ribuan
            this.value = new Intl.NumberFormat('id-ID').format(value);
        });

        // Saat form disubmit, ubah nilai jadi angka murni (tanpa titik)
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