<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Tambah Data Layanan</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 mx-auto"> <!-- center card -->
                    <div class="card m-4 p-3">
                        <div class="card-header d-flex justify-content-between align-items-center py-3">
                            <h4>Form Tambah Layanan</h4>
                        </div>

                        <div class="card-body">
                            <form action="../../actions/layanan_bengkel/store.php" method="post" enctype="multipart/form-data">

                                <!-- Nama Layanan -->
                                <div class="mb-4">
                                    <label for="nama_layanan" class="form-label">Nama Layanan</label>
                                    <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" placeholder="Masukkan nama layanan..." required>
                                </div>

                                <!-- Kategori -->
                                <div class="mb-4">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan kategori..." required>
                                </div>

                                <!-- Durasi -->
                                <div class="mb-4">
                                    <label for="durasi_minutes" class="form-label">Durasi (menit)</label>
                                    <input type="number" class="form-control" id="durasi_minutes" name="durasi_minutes" placeholder="Masukkan durasi dalam menit..." required>
                                </div>

                                <!-- Harga -->
                                <div class="mb-4">
                                    <label for="harga" class="form-label">Harga (Rp)</label>
                                    <input type="text" class="form-control" id="harga" name="harga" placeholder="Masukkan harga layanan..." required>
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Masukkan deskripsi layanan..." rows="4" required></textarea>
                                </div>

                                <!-- Upload Gambar -->
                                <div class="mb-3">
                                    <label for="image" class="form-label">Gambar Kendaraan</label>
                                    <input type="file" name="image" class="form-control" id="image" required>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-success" name="tombol">Tambah</button>
                                    <a href="./index.php" class="btn btn-secondary">Kembali</a>
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
        const hargaInput = document.getElementById("harga");

        // Format angka jadi format ribuan (titik)
        hargaInput.addEventListener("input", function(e) {
            let value = this.value.replace(/\D/g, ""); // hanya angka
            if (!value) {
                this.value = "";
                return;
            }
            this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });

        // Saat submit form, hilangkan titik agar tersimpan sebagai angka murni
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