<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Judul Halaman -->
            <div class="row mb-4">
                <div class="col-xl-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Transaksi</h2>
                        <p class="pageheader-text">Isi formulir berikut untuk menambahkan data transaksi baru.</p>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Transaksi -->
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Form Tambah Transaksi</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/transaksi/store.php" method="POST" enctype="multipart/form-data">

                                <!-- Pilih Reservasi -->
                                <!-- Pilih Reservasi -->
                                <div class="mb-4">
                                    <label for="reservasi_id" class="form-label fw-semibold">Reservasi</label>
                                    <select class="form-control" id="reservasi_id" name="reservasi_id" required>
                                        <option value="">-- Pilih Reservasi --</option>
                                        <?php
                                        $qReservasi = mysqli_query($connect, " 
                                            SELECT r.id, p.nama AS nama_pelanggan, l.nama_layanan
                                            FROM reservasi r
                                            LEFT JOIN pelanggan p ON r.pelanggan_id = p.id
                                            LEFT JOIN layanan l ON r.layanan_id = l.id
                                            ORDER BY r.id DESC
                                        ");
                                        while ($res = mysqli_fetch_object($qReservasi)) {
                                            echo "<option value='{$res->id}'>{$res->nama_pelanggan} - {$res->nama_layanan}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <!-- Tanggal Transaksi -->
                                <div class="mb-4">
                                    <label for="tanggal" class="form-label fw-semibold">Tanggal Transaksi</label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                </div>

                                <!-- Tipe Pembayaran -->
                                <div class="mb-4">
                                    <label for="tipe_pembayaran" class="form-label fw-semibold">Tipe Pembayaran</label>
                                    <select class="form-control" id="tipe_pembayaran" name="tipe_pembayaran" required>
                                        <option value="">-- Pilih Tipe Pembayaran --</option>
                                        <option value="tunai">Tunai</option>
                                        <option value="transfer">Transfer</option>
                                        <option value="e-wallet">E-wallet</option>
                                    </select>
                                </div>

                                <!-- Nominal -->
                                <div class="mb-4">
                                    <label for="nominal" class="form-label fw-semibold">Nominal (Rp)</label>
                                    <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Masukkan jumlah nominal..." required>
                                </div>

                                <!-- Tanggal Pembayaran -->
                                <div class="mb-4">
                                    <label for="tanggal_pembayaran" class="form-label fw-semibold">Tanggal Pembayaran</label>
                                    <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran">
                                </div>

                                <!-- Status Pembayaran -->
                                <div class="mb-4">
                                    <label for="status" class="form-label fw-semibold">Status Pembayaran</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="pending">Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="rejected">Rejected</option>
                                    </select>
                                </div>

                                <!-- Bukti Transfer -->
                                <div class="mb-4">
                                    <label for="bukti_transfer" class="form-label fw-semibold">Bukti Transfer</label>
                                    <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
                                    <small class="text-muted">Opsional, upload jika pembayaran melalui transfer.</small>
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

<script>
    function formatRupiah(angka) {
        let number_string = angka.replace(/[^,\d]/g, "").toString(),
            split = number_string.split(","),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? "." : "";
            rupiah += separator + ribuan.join(".");
        }

        return rupiah;
    }

    const inputNominal = document.getElementById("nominal");

    inputNominal.addEventListener("input", function() {
        this.value = formatRupiah(this.value);
    });

    // Hapus titik & koma saat submit sebelum dikirim ke server
    document.querySelector("form").addEventListener("submit", function() {
        const angkaBersih = inputNominal.value.replace(/[^\d]/g, "");
        inputNominal.value = angkaBersih;
    });
</script>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>