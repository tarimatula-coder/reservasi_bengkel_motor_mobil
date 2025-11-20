<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('ID laporan tidak ditemukan');window.location.href='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

$q = mysqli_query($connect, "SELECT * FROM laporan WHERE id = $id");
$laporan = mysqli_fetch_object($q);

if (!$laporan) {
    echo "<script>alert('Data laporan tidak ditemukan');window.location.href='index.php';</script>";
    exit;
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="page-header mb-3">
                <h2 class="pageheader-title">Edit Data Laporan</h2>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-4 p-3">
                        <div class="card-header">
                            <h4>Form Edit Laporan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/laporan/update.php" method="post">

                                <!-- kirim id -->
                                <input type="hidden" name="id" value="<?= $laporan->id ?>">

                                <div class="mb-4">
                                    <label class="form-label">Periode</label>
                                    <input type="text" name="periode" class="form-control"
                                        value="<?= htmlspecialchars($laporan->periode) ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Jumlah Reservasi</label>
                                    <input type="number" name="jumlah_reservasi" class="form-control"
                                        value="<?= htmlspecialchars($laporan->jumlah_reservasi) ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Total Pendapatan</label>
                                    <input type="text" id="total_pendapatan" name="total_pendapatan" class="form-control"
                                        value="<?= number_format($laporan->total_pendapatan, 0, ',', '.') ?>" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Dibuat Oleh</label>
                                    <input type="text" name="dibuat_oleh" class="form-control"
                                        value="<?= htmlspecialchars($laporan->dibuat_oleh) ?>" required>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" name="tombol" class="btn btn-success">Update</button>
                                    <a href="index.php" class="btn btn-secondary">Kembali</a>
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

    <script>
        function formatRupiah(angka) {
            let number_string = angka.replace(/[^,\d]/g, "").toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            return "Rp " + rupiah;
        }

        const input = document.getElementById("total_pendapatan");

        input.addEventListener("input", function() {
            this.value = formatRupiah(this.value);
        });

        // hapus "Rp." sebelum submit
        document.querySelector("form").addEventListener("submit", function() {
            let angka = input.value.replace(/[^0-9]/g, "");
            input.value = angka;
        });
    </script>


    <?php
    include '../../partials/footer.php';
    include '../../partials/script.php';
    ?>