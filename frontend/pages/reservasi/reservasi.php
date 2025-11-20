<?php
// Pastikan path ini benar (tergantung di mana file koneksi Anda berada relatif terhadap file ini)
include '../../app.php';


// Cek koneksi
if (!$connect) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
    die("Koneksi gagal: " . mysqli_connect_error());
}

// --- 1. Query Data Pilihan untuk Dropdown (Menggunakan nama tabel pendek) ---

// Query Pelanggan
$qPelanggan = mysqli_query($connect, "SELECT id, nama FROM pelanggan ORDER BY nama ASC");

// Query Kendaraan (JOIN dengan pelanggan untuk tampilan pemilik)
$qKendaraan = mysqli_query($connect, "
    SELECT k.id, k.merk, k.model, k.plat_nomor, p.nama AS pemilik
    FROM kendaraan k
    LEFT JOIN pelanggan p ON k.pelanggan_id = p.id
    ORDER BY k.plat_nomor DESC
");

// Query Mekanik
$qMekanik = mysqli_query($connect, "SELECT id, nama FROM mekanik ORDER BY nama ASC");

// Query Layanan
$qLayanan = mysqli_query($connect, "SELECT id, nama_layanan, harga, durasi_minutes FROM layanan ORDER BY nama_layanan ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Reservasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <div id="wrapper">
        <div class="content-wrapper">
            <div class="container-fluid pt-4 pb-5">
                <div class="row mb-4">
                    <div class="col-xl-12">
                        <div class="page-header">
                            <!-- Judul Utama dengan warna biru tua kustom -->
                            <h2 class="pageheader-title deep-blue-accent">Tambah Data Reservasi</h2>
                            <p class="pageheader-text text-secondary">Isi formulir di bawah ini untuk menambahkan data reservasi baru.</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-lg border-0 rounded-4">
                            <!-- Card Header dengan warna biru tua kustom -->
                            <div class="card-header bg-deep-blue text-white rounded-top-4">
                                <h4 class="mb-0"><i class="fas fa-calendar-plus me-2"></i> Form Tambah Reservasi</h4>
                            </div>

                            <div class="card-body p-4">
                                <form action="../../actions/reservasi/reservasi_proses.php" method="POST">

                                    <div class="mb-4">
                                        <label for="pelanggan_id" class="form-label fw-semibold">Pelanggan</label>
                                        <select class="form-select" name="pelanggan_id" id="pelanggan_id" required>
                                            <option value="">-- Pilih Pelanggan --</option>
                                            <?php
                                            // Mengisi dropdown Pelanggan
                                            while ($pel = mysqli_fetch_object($qPelanggan)) {
                                                echo "<option value='{$pel->id}'>{$pel->nama}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="kendaraan_id" class="form-label fw-semibold">Kendaraan</label>
                                        <select class="form-select" name="kendaraan_id" id="kendaraan_id" required>
                                            <option value="">-- Pilih Kendaraan --</option>
                                            <?php
                                            // Mengisi dropdown Kendaraan
                                            while ($ken = mysqli_fetch_object($qKendaraan)) {
                                                echo "<option value='{$ken->id}'>{$ken->plat_nomor} - {$ken->merk} {$ken->model} (Pemilik: {$ken->pemilik})</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="mekanik_id" class="form-label fw-semibold">Mekanik</label>
                                        <select class="form-select" name="mekanik_id" id="mekanik_id" required>
                                            <option value="">-- Pilih Mekanik --</option>
                                            <?php
                                            // Mengisi dropdown Mekanik
                                            while ($mek = mysqli_fetch_object($qMekanik)) {
                                                echo "<option value='{$mek->id}'>{$mek->nama}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="layanan_id" class="form-label fw-semibold">Layanan</label>
                                        <select class="form-select" name="layanan_id" id="layanan_id" required>
                                            <option value="">-- Pilih Layanan --</option>
                                            <?php
                                            // Mengisi dropdown Layanan
                                            // Menyimpan harga dan durasi sebagai data attribute
                                            while ($lay = mysqli_fetch_object($qLayanan)) {
                                                echo "<option value='{$lay->id}' data-harga='{$lay->harga}' data-durasi='{$lay->durasi_minutes}'>{$lay->nama_layanan} (Rp" . number_format($lay->harga, 0, ',', '.') . ")</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="tanggal" class="form-label fw-semibold">Tanggal Reservasi</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required min="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="waktu" class="form-label fw-semibold">Waktu Reservasi</label>
                                                <input type="time" class="form-control" id="waktu" name="waktu" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="durasi_minutes" class="form-label fw-semibold">Durasi (Menit)</label>
                                                <input type="number" class="form-control" id="durasi_minutes" name="durasi_minutes" placeholder="Diisi otomatis..." required readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-4">
                                                <label for="total_harga" class="form-label fw-semibold">Total Harga (Rp)</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">Rp</span>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        id="total_harga"
                                                        name="total_harga"
                                                        placeholder="Diisi otomatis..."
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="status_reservasi" class="form-label fw-semibold">Status Reservasi</label>
                                        <select class="form-select" name="status_reservasi" id="status_reservasi" required>
                                            <option value="booked" selected>Menunggu (Booked)</option>
                                            <option value="confirmed">Dikonfirmasi (Confirmed)</option>
                                            <option value="in-progress">Sedang Dikerjakan (In-Progress)</option>
                                            <option value="completed">Selesai (Completed)</option>
                                            <option value="cancelled">Dibatalkan (Cancelled)</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="catatan" class="form-label fw-semibold">Catatan</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan catatan..."></textarea>
                                    </div>

                                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                        <!-- Tombol Simpan dengan warna sukses (Hijau) -->
                                        <button type="submit" class="btn btn-success px-4 rounded-3 shadow-sm" name="tombol">
                                            <i class="fa fa-save me-2"></i> Tambah Reservasi
                                        </button>
                                        <!-- Tombol Kembali diarahkan ke Halaman Utama/Home -->
                                        <a href="../../index.php" class="btn btn-secondary px-4 rounded-3 shadow-sm">
                                            <i class="fa fa-arrow-left me-2"></i> Kembali ke Home
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        /* Definisi Warna Biru Tua Kustom */
        :root {
            --deep-blue: #1a4d94;
        }

        html,
        body {
            height: 100%;
            background-color: #f7f9fc;
            /* Latar belakang abu-abu ringan */
        }

        #wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .content-wrapper {
            flex: 1;
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .deep-blue-accent {
            color: var(--deep-blue);
        }

        .bg-deep-blue {
            background-color: var(--deep-blue) !important;
        }

        /* Styling Form */
        .card {
            border-radius: 0.75rem !important;
        }

        .form-control,
        .form-select {
            border-radius: 0.5rem;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hargaInput = document.getElementById("total_harga");
            const durasiInput = document.getElementById("durasi_minutes");
            const layananSelect = document.getElementById("layanan_id");

            // --- Fungsi Format Rupiah ---
            function formatRupiah(angka) {
                // Konversi ke string, hapus semua non-digit
                let number_string = angka.toString().replace(/\D/g, '');

                if (!number_string) return '';

                // Hitung posisi titik
                let split = number_string.length > 3 ? number_string.length % 3 : 0;
                let rupiah = (split ? number_string.substr(0, split) + '.' : '');

                // Tambahkan titik setiap 3 digit
                rupiah += number_string.substr(split).replace(/(\d{3})(?=\d)/g, '$1' + '.');

                return rupiah;
            }

            // --- Event Listener untuk Pemilihan Layanan (Mengisi Harga & Durasi Otomatis) ---
            layananSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];

                // Ambil data attribute
                const harga = selectedOption.getAttribute('data-harga');
                const durasi = selectedOption.getAttribute('data-durasi');

                if (harga && durasi) {
                    // Isi field Durasi
                    durasiInput.value = durasi;
                    // Isi field Harga dengan format Rupiah
                    hargaInput.value = formatRupiah(harga);
                } else {
                    // Reset jika 'Pilih Layanan' dipilih
                    durasiInput.value = '';
                    hargaInput.value = '';
                }
            });


            // --- Event Listener untuk Input Harga (Formatting) ---
            hargaInput.addEventListener("input", function(e) {
                // Hapus semua karakter non-angka
                let value = this.value.replace(/\D/g, "");

                if (!value) {
                    this.value = "";
                    return;
                }

                // Terapkan format Rupiah
                this.value = formatRupiah(value);
            });

            // --- Event Listener Saat Form Disubmit ---
            const form = hargaInput.closest("form");
            form.addEventListener("submit", function() {
                // Hapus titik ribuan pada input harga sebelum dikirim
                // Mengubah nilai input yang diformat (Rp. 1.000.000) menjadi nilai murni (1000000)
                hargaInput.value = hargaInput.value.replace(/\./g, "");

                // Pastikan durasi terisi jika diisi otomatis tapi pengguna tidak mengubahnya
                if (!durasiInput.value) {
                    const selectedOption = layananSelect.options[layananSelect.selectedIndex];
                    const durasi = selectedOption.getAttribute('data-durasi');
                    if (durasi) {
                        durasiInput.value = durasi;
                    }
                }
            });

            // Panggil change event saat DOM load jika ada nilai default
            if (layananSelect.value) {
                layananSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

</body>

</html>