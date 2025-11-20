<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Laporan</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form Tambah Laporan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/laporan/store.php" method="post">

                                <!-- Priode -->
                                <div class="mb-4">
                                    <label class="form-label">Periode</label>
                                    <input type="text" class="form-control" name="periode" placeholder="Contoh: Januari 2025" required>
                                </div>

                                <!-- Jumlah Reservasi -->
                                <div class="mb-4">
                                    <label class="form-label">Jumlah Reservasi</label>
                                    <input type="number" class="form-control" name="jumlah_reservasi" placeholder="Contoh: 25" required>
                                </div>

                                <!-- Total Pendapatan -->
                                <div class="mb-4">
                                    <label class="form-label">Total Pendapatan</label>
                                    <input type="text" class="form-control" id="total_pendapatan" name="total_pendapatan" placeholder="Contoh: 15.000.000" required>
                                </div>

                                <!-- Dibuat Oleh -->
                                <div class="mb-4">
                                    <label class="form-label">Dibuat Oleh</label>
                                    <input type="text" class="form-control" name="dibuat_oleh" placeholder="Nama pembuat laporan" required>
                                </div>

                                <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                                <a href="./index.php" class="btn btn-secondary">Kembali</a>

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

            return rupiah;
        }

        const input = document.getElementById("total_pendapatan");

        input.addEventListener("input", function() {
            this.value = formatRupiah(this.value);
        });

        // Hapus titik sebelum submit (supaya tersimpan angka murni)
        document.querySelector("form").addEventListener("submit", function() {
            let angka = input.value.replace(/[^0-9]/g, "");
            input.value = angka;
        });
    </script>

    <?php
    include '../../partials/footer.php';
    include '../../partials/script.php';
    ?>