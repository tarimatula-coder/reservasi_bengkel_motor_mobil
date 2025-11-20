<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Pastikan ID tersedia
if (!isset($_GET['id'])) {
    echo "<script>
        alert('ID transaksi tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}

$id = intval($_GET['id']);

// Ambil data transaksi berdasarkan ID
$query = $connect->query("SELECT * FROM transaksi WHERE id = $id");
$transaksi = $query->fetch_object();

if (!$transaksi) {
    echo "<script>
        alert('Data transaksi tidak ditemukan!');
        window.location.href='index.php';
    </script>";
    exit;
}

// Ambil data reservasi untuk dropdown
$reservasi = $connect->query("SELECT r.id, p.nama AS nama_pelanggan, l.nama_layanan
    FROM reservasi r
    LEFT JOIN pelanggan p ON r.pelanggan_id = p.id
    LEFT JOIN layanan l ON r.layanan_id = l.id
    ORDER BY r.id DESC
");
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Header halaman -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Edit Data Transaksi</h2>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Edit Transaksi</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/transaksi/update.php?id=<?= $transaksi->id ?>" method="POST" enctype="multipart/form-data">

                                <!-- Reservasi -->
                                <div class="mb-3">
                                    <label for="reservasi_id" class="form-label">Reservasi</label>
                                    <select class="form-control" id="reservasi_id" name="reservasi_id" required>
                                        <option value="">-- Pilih Reservasi --</option>
                                        <?php while ($r = $reservasi->fetch_object()) : ?>
                                            <option value="<?= $r->id ?>" <?= ($r->id == $transaksi->reservasi_id) ? 'selected' : '' ?>>
                                                <?= "{$r->nama_pelanggan} ({$r->nama_layanan})" ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <!-- Tanggal Transaksi -->
                                <div class="mb-3">
                                    <label for="tanggal" class="form-label">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal"
                                        value="<?= htmlspecialchars($transaksi->tanggal) ?>" required>
                                </div>

                                <!-- Tipe Pembayaran -->
                                <div class="mb-3">
                                    <label for="tipe_pembayaran" class="form-label">Tipe Pembayaran</label>
                                    <select class="form-control" id="tipe_pembayaran" name="tipe_pembayaran" required>
                                        <option value="cash" <?= ($transaksi->tipe_pembayaran == 'cash') ? 'selected' : '' ?>>Cash</option>
                                        <option value="transfer" <?= ($transaksi->tipe_pembayaran == 'transfer') ? 'selected' : '' ?>>Transfer</option>
                                    </select>
                                </div>

                                <!-- Nominal -->
                                <div class="mb-3">
                                    <label for="nominal" class="form-label">Nominal (Rp)</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal"
                                        value="<?= number_format($transaksi->nominal, 0, ',', '.') ?>" required>
                                </div>

                                <!-- Tanggal Pembayaran -->
                                <div class="mb-3">
                                    <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran</label>
                                    <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran"
                                        value="<?= htmlspecialchars($transaksi->tanggal_pembayaran) ?>">
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status Pembayaran</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending" <?= ($transaksi->status == 'pending') ? 'selected' : '' ?>>Pending</option>
                                        <option value="confirmed" <?= ($transaksi->status == 'confirmed') ? 'selected' : '' ?>>Berhasil</option>
                                        <option value="rejected" <?= ($transaksi->status == 'rejected') ? 'selected' : '' ?>>Gagal</option>
                                    </select>
                                </div>

                                <!-- Bukti Transfer -->
                                <div class="mb-3">
                                    <label for="bukti_transfer" class="form-label">Bukti Transfer</label><br>
                                    <?php if (!empty($transaksi->bukti_transfer)) : ?>
                                        <img src="../../../storages/bukti_transfer/<?= htmlspecialchars($transaksi->bukti_transfer) ?>"
                                            alt="Bukti Transfer" class="img-thumbnail mb-2" style="width: 180px; height: auto;"><br>
                                    <?php else : ?>
                                        <p class="text-muted fst-italic">Belum ada bukti transfer</p>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
                                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar.</small>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success">
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

<!-- Script formatting angka -->
<script>
    // Format angka nominal dengan titik ribuan
    const nominalInput = document.getElementById('nominal');
    nominalInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = new Intl.NumberFormat('id-ID').format(value);
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>