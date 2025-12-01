<?php
$qLayanan = "SELECT * FROM layanan LIMIT 7";
$resultLayanan = mysqli_query($connect, $qLayanan) or die(mysqli_error($connect));

// 4 gambar default
$default_images = [
    "asset/img/bengkel_motor.jpg",
    "asset/img/images (1).jpg",
    "asset/img/images.jpg",
    "asset/img/mekanik.jpg"
];

$index = 0;
?>

<section id="layanan" class="layanan section">
    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2 class="text">Layanan</h2>
        </div>

        <div class="row gy-4">
            <?php while ($item = $resultLayanan->fetch_object()): ?>
                <?php
                // Tentukan gambar: dari database atau default
                $foto = (!empty($item->image) && file_exists(__DIR__ . "/../../storages/layanan/" . $item->image))
                    ? "../../storages/layanan/" . $item->image
                    : $default_images[$index % 4];
                $index++;
                ?>

                <div class="col-lg-3 col-md-6" data-aos="fade-up">
                    <div class="layanan-card d-flex flex-column">
                        <div class="layanan-img">
                            <img src="../storages/layanan/<?= $item->image ?>" alt="">
                        </div>
                        <div class="layanan-info mt-2">
                            <h5><?= htmlspecialchars($item->nama_layanan ?? '-') ?></h5>
                            <ul class="list-unstyled mb-2">
                                <li><strong>Kategori:</strong> <?= htmlspecialchars($item->kategori ?? '-') ?></li>
                                <li><strong>Durasi:</strong> <?= htmlspecialchars($item->durasi_minutes ?? '-') ?> Menit</li>
                            </ul>
                            <p class="text-truncate-2"><?= htmlspecialchars($item->deskripsi ?? '-') ?></p>
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
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #e6e6e6;
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    .layanan-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .layanan-img {
        width: 100%;
        height: 180px;
        overflow: hidden;
    }

    .layanan-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .layanan-info {
        padding: 15px;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }

    .layanan-info h5 {
        font-weight: 600;
        margin-bottom: 8px;
    }

    .layanan-info ul {
        padding-left: 0;
        margin-bottom: 5px;
    }

    .layanan-info ul li {
        list-style: none;
        font-size: 0.9rem;
        margin-bottom: 2px;
    }

    .layanan-info p {
        font-size: 0.85rem;
        color: #555;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>