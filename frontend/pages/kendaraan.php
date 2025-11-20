<?php
$qKendaraan = "
    SELECT 
        kendaraan.*, 
        pelanggan.nama AS nama_pemilik
    FROM kendaraan
    LEFT JOIN pelanggan ON kendaraan.pelanggan_id = pelanggan.id
";
$resultkendaraan = mysqli_query($connect, $qKendaraan) or die(mysqli_error($connect));

// default images
$default_images = [
    "asset/img/mobil.jpg",
    "asset/img/download (2).jpg",
    "asset/img/download (3).jpg",
    "asset/img/download (4).jpg"
];

$index = 0;
?>

<section id="kendaraan" class="kendaraan section">
    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2 class="text">Kendaraan</h2>
        </div>

        <div class="row g-4">
            <?php while ($item = $resultkendaraan->fetch_object()): ?>
                <?php
                $img = !empty($item->foto_kendaraan) ? "asset/img/" . $item->foto_kendaraan : $default_images[$index % 4];
                $index++;
                ?>

                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="kendaraan-card d-flex flex-column">
                        <div class="kendaraan-img">
                            <img src="<?= $img ?>" alt="Foto Kendaraan">
                        </div>
                        <div class="kendaraan-info mt-2">
                            <h5><?= htmlspecialchars($item->jenis) ?> (<?= htmlspecialchars($item->merk . ' ' . $item->model) ?>)</h5>
                            <p><strong>Plat Nomor:</strong> <?= htmlspecialchars($item->plat_nomor) ?></p>
                            <p><strong>Tahun:</strong> <?= htmlspecialchars($item->tahun) ?></p>
                            <?php if (!empty($item->catatan)): ?>
                                <p><strong>Catatan:</strong> <?= htmlspecialchars($item->catatan) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</section>

<style>
    .kendaraan-card {
        background: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        border: 1px solid #e6e6e6;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .kendaraan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .kendaraan-img img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    .kendaraan-info h5 {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .kendaraan-info p {
        margin: 2px 0;
        font-size: 0.9rem;
    }
</style>