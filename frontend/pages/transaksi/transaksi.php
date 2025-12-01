<?php
// Pastikan path ini benar (tergantung di mana file koneksi Anda berada relatif terhadap file ini)
include '../../app.php';

// Cek koneksi
if (!$connect) {
    // Jika koneksi gagal, hentikan eksekusi dan tampilkan pesan error
    die("Koneksi gagal: " . mysqli_connect_error());
}

// --- Query Data Pilihan untuk Dropdown Reservasi ---
// Memuat data reservasi yang relevan (misalnya yang sudah Dikonfirmasi atau Selesai, dan siap ditransaksikan)
// Saya menyertakan r.total_harga dan r.tanggal/waktu sebagai data-attribute untuk referensi di JS/tampilan.
$qReservasi = mysqli_query($connect, " 
    SELECT 
        r.id, 
        p.nama AS nama_pelanggan, 
        l.nama_layanan,
        r.total_harga,
        r.tanggal,
        r.waktu
    FROM reservasi r
    LEFT JOIN pelanggan p ON r.pelanggan_id = p.id
    LEFT JOIN layanan l ON r.layanan_id = l.id
    -- Filter opsional: Tampilkan hanya reservasi yang sudah diselesaikan atau dikonfirmasi
    -- WHERE r.status_reservasi IN ('confirmed', 'completed', 'in-progress') 
    ORDER BY r.id DESC
");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="icon" href="../../templates_user/assets/img/logo_bengkel.jpg" type="image/logo_bengkel.jpg">

    <style>
        /* Definisi Warna Biru Tua Kustom (Deep Blue) */
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

        /* Custom style untuk field nominal yang terisi otomatis */
        .nominal-info {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
    </style>
</head>

<body>

    <div id="wrapper">
        <div class="content-wrapper">
            <div class="container-fluid pt-4 pb-5">

                <!-- Header Halaman -->
                <div class="row mb-4">
                    <div class="col-xl-12">
                        <div class="page-header">
                            <!-- Judul Utama dengan warna biru tua kustom -->
                            <h2 class="pageheader-title deep-blue-accent">Tambah Data Transaksi</h2>
                            <p class="pageheader-text text-secondary">Isi formulir di bawah ini untuk mencatat transaksi pembayaran dari reservasi yang sudah ada.</p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="card shadow-lg border-0 rounded-4">
                            <!-- Card Header dengan warna biru tua kustom -->
                            <div class="card-header bg-deep-blue text-white rounded-top-4">
                                <h4 class="mb-0"><i class="fas fa-receipt me-2"></i> Form Transaksi Baru</h4>
                            </div>

                            <div class="card-body p-4">
                                <form action="../../actions/transaksi/transaksi_proses.php" method="POST" enctype="multipart/form-data">

                                    <!-- Pilihan Reservasi -->
                                    <div class="mb-4">
                                        <label for="reservasi_id" class="form-label fw-semibold">Pilih Reservasi</label>
                                        <select class="form-select" name="reservasi_id" id="reservasi_id" required>
                                            <option value="" data-harga="0">-- Pilih Reservasi --</option>
                                            <?php
                                            // Mengisi dropdown Reservasi
                                            while ($res = mysqli_fetch_object($qReservasi)) {
                                                // Simpan total_harga, tanggal, dan waktu sebagai data attribute
                                                $formatted_harga = number_format($res->total_harga, 0, ',', '.');
                                                $display_text = "ID {$res->id} - {$res->nama_pelanggan} ({$res->nama_layanan} - Rp{$formatted_harga})";

                                                echo "<option value='{$res->id}' 
                                                    data-harga='{$res->total_harga}' 
                                                    data-tanggal='{$res->tanggal}'
                                                    data-waktu='{$res->waktu}'>{$display_text}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Detail Reservasi (Tampilan Info) -->
                                    <div class="mb-4 bg-light p-3 rounded-3 border">
                                        <p class="mb-1 fw-bold text-deep-blue">Detail Reservasi:</p>
                                        <div id="reservasi_info" class="nominal-info">Pilih reservasi untuk melihat detail harga dan waktu.</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Tanggal Transaksi (Tanggal Pencatatan) -->
                                            <div class="mb-4">
                                                <label for="tanggal" class="form-label fw-semibold">Tanggal Transaksi (Pencatatan)</label>
                                                <input type="date" class="form-control" id="tanggal" name="tanggal" required value="<?= date('Y-m-d') ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Tipe Pembayaran -->
                                            <div class="mb-4">
                                                <label for="tipe_pembayaran" class="form-label fw-semibold">Tipe Pembayaran</label>
                                                <select class="form-select" id="tipe_pembayaran" name="tipe_pembayaran" required>
                                                    <option value="">-- Pilih Tipe Pembayaran --</option>
                                                    <option value="tunai">Tunai</option>
                                                    <option value="transfer">Transfer Bank</option>
                                                    <option value="e-wallet">E-wallet/QRIS</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Nominal -->
                                    <div class="mb-4">
                                        <label for="nominal" class="form-label fw-semibold">Nominal Pembayaran (Rp)</label>
                                        <div class="input-group">
                                            <span class="input-group-text">Rp</span>
                                            <input type="text" class="form-control" id="nominal" name="nominal" placeholder="Diisi otomatis berdasarkan reservasi atau masukkan manual..." required>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Tanggal Pembayaran (Opsional/Jika terjadi di waktu berbeda) -->
                                            <div class="mb-4">
                                                <label for="tanggal_pembayaran" class="form-label fw-semibold">Tanggal Pembayaran</label>
                                                <input type="date" class="form-control" id="tanggal_pembayaran" name="tanggal_pembayaran" value="<?= date('Y-m-d') ?>">
                                                <small class="text-muted">Kosongkan jika sama dengan Tanggal Transaksi.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Status Pembayaran -->
                                            <div class="mb-4">
                                                <label for="status" class="form-label fw-semibold">Status Pembayaran</label>
                                                <select class="form-select" id="status" name="status" required>
                                                    <option value="pending" selected>Pending</option>
                                                    <option value="confirmed">Confirmed (Lunas)</option>
                                                    <option value="rejected">Rejected (Gagal)</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Bukti Transfer -->
                                    <div class="mb-4">
                                        <label for="bukti_transfer" class="form-label fw-semibold">Bukti Pembayaran / Transfer</label>
                                        <input type="file" class="form-control" id="bukti_transfer" name="bukti_transfer">
                                        <small class="text-muted">Opsional, diperlukan jika tipe pembayaran adalah Transfer atau E-wallet.</small>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="d-flex justify-content-between mt-5 pt-3 border-top">
                                        <!-- Tombol Simpan dengan warna sukses (Hijau) -->
                                        <button type="submit" class="btn btn-success px-4 rounded-3 shadow-sm" name="tombol">
                                            <i class="fa fa-money-bill-wave me-2"></i> Catat Transaksi
                                        </button>
                                        <!-- Tombol Kembali diarahkan ke Halaman Utama/Home (Diasumsikan index.php adalah home) -->
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const reservasiSelect = document.getElementById("reservasi_id");
            const nominalInput = document.getElementById("nominal");
            const reservasiInfoDiv = document.getElementById("reservasi_info");
            const form = nominalInput.closest("form");

            // --- Fungsi Format Rupiah (diambil dari snippet transaksi Anda) ---
            function formatRupiah(angka) {
                // Pastikan input adalah string dan hapus karakter non-digit kecuali koma
                let number_string = angka.toString().replace(/[^,\d]/g, "").toString();
                let split = number_string.split(",");
                let sisa = split[0].length % 3;
                let rupiah = split[0].substr(0, sisa);
                let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    let separator = sisa ? "." : "";
                    rupiah += separator + ribuan.join(".");
                }

                // Tambahkan koma dan angka di belakang koma (jika ada)
                rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
                return rupiah;
            }

            // --- Event Listener untuk Pemilihan Reservasi (Mengisi Nominal Otomatis) ---
            reservasiSelect.addEventListener("change", function() {
                const selectedOption = this.options[this.selectedIndex];
                const harga = selectedOption.getAttribute('data-harga');
                const tanggal = selectedOption.getAttribute('data-tanggal');
                const waktu = selectedOption.getAttribute('data-waktu');

                if (harga && harga > 0) {
                    // Isi field Nominal dengan total_harga dari reservasi (otomatis terformat)
                    nominalInput.value = formatRupiah(harga);

                    // Update info detail
                    reservasiInfoDiv.innerHTML = `
                        Total Harga Reservasi: <strong>Rp${formatRupiah(harga)}</strong><br>
                        Tanggal/Waktu: <strong>${tanggal}</strong>, pukul <strong>${waktu.substring(0, 5)}</strong>
                    `;
                } else {
                    // Reset jika 'Pilih Reservasi' dipilih
                    nominalInput.value = '';
                    reservasiInfoDiv.innerHTML = 'Pilih reservasi untuk melihat detail harga dan waktu.';
                }
            });


            // --- Event Listener untuk Input Nominal (Formatting Real-time) ---
            nominalInput.addEventListener("input", function(e) {
                // Terapkan format Rupiah saat mengetik
                this.value = formatRupiah(this.value);
            });

            // --- Event Listener Saat Form Disubmit ---
            form.addEventListener("submit", function() {
                // Hapus titik & koma dari input nominal sebelum dikirim ke server (agar menjadi angka murni)
                // Mengubah nilai input yang diformat (1.000.000,00 atau 1.000.000) menjadi nilai murni (1000000)
                const angkaBersih = nominalInput.value.replace(/[^\d]/g, "");
                nominalInput.value = angkaBersih;
            });

            // Panggil change event saat DOM load jika ada nilai default
            if (reservasiSelect.value) {
                reservasiSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>

</body>

</html>