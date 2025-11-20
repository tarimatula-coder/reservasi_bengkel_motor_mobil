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
                        <h2 class="pageheader-title">Tambah Data Status perbaikan</h2>
                        <p class="pageheader-text">Isi formulir di bawah ini untuk menambahkan data reservasi baru.</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Tambah status perbaikan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/status_perbaikan/store.php" method="POST">

                                <!-- Pelanggan -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Pelanggan</label>
                                    <select class="form-control" name="pelanggan_id" required>
                                        <option value="">-- Pilih Pelanggan --</option>
                                        <?php
                                        $qPelanggan = mysqli_query($connect, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");
                                        while ($pel = mysqli_fetch_object($qPelanggan)) {
                                            echo "<option value='{$pel->id}'>{$pel->nama}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Kendaraan -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Kendaraan</label>
                                    <select class="form-control" name="kendaraan_id" required>
                                        <option value="">-- Pilih Kendaraan --</option>
                                        <?php
                                        $qKendaraan = mysqli_query($connect, "
                                            SELECT k.id, k.merk, k.model, k.plat_nomor, p.nama AS pemilik
                                            FROM kendaraan k
                                            LEFT JOIN pelanggan p ON k.pelanggan_id = p.id
                                            ORDER BY k.id DESC
                                        ");
                                        while ($ken = mysqli_fetch_object($qKendaraan)) {
                                            echo "<option value='{$ken->id}'>{$ken->merk} {$ken->model} - {$ken->plat_nomor} (Pemilik: {$ken->pemilik})</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Mekanik -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Mekanik</label>
                                    <select class="form-control" name="mekanik_id" required>
                                        <option value="">-- Pilih Mekanik --</option>
                                        <?php
                                        $qMekanik = mysqli_query($connect, "SELECT id, nama FROM mekanik ORDER BY nama ASC");
                                        while ($mek = mysqli_fetch_object($qMekanik)) {
                                            echo "<option value='{$mek->id}'>{$mek->nama}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Layanan -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Layanan</label>
                                    <select class="form-control" name="layanan_id" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        <?php
                                        $qLayanan = mysqli_query($connect, "SELECT id, nama_layanan FROM layanan ORDER BY nama_layanan ASC");
                                        while ($lay = mysqli_fetch_object($qLayanan)) {
                                            echo "<option value='{$lay->id}'>{$lay->nama_layanan}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Tanggal -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Tanggal Reservasi</label>
                                    <input type="date" class="form-control" name="tanggal" required>
                                </div>

                                <!-- Waktu -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Waktu Reservasi</label>
                                    <input type="time" class="form-control" name="waktu" required>
                                </div>

                                <!-- Durasi -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Durasi (Menit)</label>
                                    <input type="number" class="form-control" name="durasi_minutes" placeholder="Masukkan durasi..." required>
                                </div>

                                <div class="mb-3">
                                    <label for="total_harga" class="form-label fw-semibold">Total Harga (Rp)</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="total_harga"
                                        name="total_harga"
                                        placeholder="Masukkan nominal..."
                                        required>
                                </div>

                                <!-- Status Reservasi -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Status Reservasi</label>
                                    <select class="form-control" name="status_reservasi" required>
                                        <option value="booked">Menunggu</option>
                                        <option value="confirmed">Dikonfirmasi</option>
                                        <option value="in-progress">Sedang Dikerjakan</option>
                                        <option value="completed">Selesai</option>
                                        <option value="cancelled">Dibatalkan</option>
                                    </select>
                                </div>

                                <!-- Catatan -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Catatan</label>
                                    <textarea class="form-control" name="catatan" rows="4" placeholder="Masukkan catatan..."></textarea>
                                </div>

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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const hargaInput = document.getElementById("total_harga");

        // Format angka ke format rupiah dengan titik ribuan
        hargaInput.addEventListener("input", function(e) {
            let value = this.value.replace(/\D/g, ""); // hanya angka
            if (!value) {
                this.value = "";
                return;
            }

            // Tambahkan titik setiap ribuan
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
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