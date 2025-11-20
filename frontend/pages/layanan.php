<?php
// Ambil data layanan
$qLayanan = "SELECT * FROM layanan ORDER BY id DESC";
$resultlayanan = mysqli_query($connect, $qLayanan) or die(mysqli_error($connect));

// 4 gambar default layanan (Dibuat seperti Kendaraan untuk rotasi)
$default_service_images = [
    "asset/img/images (2).jpg",
    "asset/img/cuci-62.jpg",
    "asset/img/images (1).jpg",
    "asset/img/bengkel.jpg"
];

$index = 0; // untuk rotasi gambar
?>

<section id="layanan" class="layanan section">

    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2 class="text">Layanan Kami</h2>
        </div>

        <div class="row gy-4">

            <?php while ($l = $resultlayanan->fetch_object()): ?>

                <?php
                // --- LOGIC ROTASI GAMBAR SEPERTI KENDARAAN ---
                // Asumsi nama kolom foto layanan adalah 'foto_layanan'.
                // Jika database memiliki kolom foto layanan
                if (isset($l->foto_layanan) && !empty($l->foto_layanan)) {
                    $img = "asset/img/" . $l->foto_layanan;
                } else {
                    // Jika tidak ada foto, gunakan rotasi gambar default
                    $img = $default_service_images[$index % 4];
                }

                $index++; // pindah ke gambar berikutnya
                ?>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">

                    <div class="layanan-card shadow-sm">

                        <div class="layanan-img">
                            <img src="<?= $img ?>" alt="Foto Layanan">
                        </div>

                        <div class="layanan-info p-3">
                            <h4 class="mb-2"><?= $l->nama_layanan ?></h4>

                            <ul class="list-unstyled mb-3 info-list">
                                <li><strong>Kategori:</strong> <?= ucwords($l->kategori) ?></li>
                                <li><strong>Estimasi Durasi:</strong> <?= $l->durasi_minutes ?> Menit</li>
                            </ul>

                            <p class="text-truncate-2" style="max-height: 50px; overflow: hidden;"><?= $l->deskripsi ?></p>

                            <h5 class="text-success mt-3 mb-3">
                                Rp <?= number_format($l->harga, 0, ',', '.') ?>
                            </h5>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>

        </div>
    </div>

</section>

<style>
    .layanan-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        transition: 0.3s;
        height: 100%;
        display: flex;
        /* Tambahan untuk memastikan footer di bawah */
        flex-direction: column;
    }

    .layanan-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
    }

    .layanan-img img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .layanan-info {
        flex-grow: 1;
        /* Konten info mengambil sisa ruang */
        display: flex;
        flex-direction: column;
    }

    .layanan-info h4 {
        font-size: 18px;
        font-weight: 600;
    }

    .layanan-info .info-list {
        padding-left: 0;
        margin-bottom: 5px;
    }

    .layanan-info .info-list li {
        font-size: 14px;
        list-style: none;
        margin-bottom: 2px;
    }

    .layanan-info p {
        font-size: 14px;
        color: #555;
        min-height: 35px;
        /* Mengurangi min-height untuk tampilan 2 baris */
        line-height: 1.3;
        margin-bottom: 8px;
        /* Jarak antara deskripsi dan harga */
    }

    /* Utility class untuk memotong teks setelah 2 baris (jika menggunakan Bootstrap) */
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>