<?php
$qKendaraan = "
    SELECT 
        kendaraan.*, 
        pelanggan.nama AS nama_pemilik
    FROM kendaraan
    LEFT JOIN pelanggan ON kendaraan.pelanggan_id = pelanggan.id
";
$resultkendaraan = mysqli_query($connect, $qKendaraan) or die(mysqli_error($connect));

// default image jika kendaraan tidak punya foto
$default_image = "asset/img/default_kendaraan.png"; // path URL default
?>

<section id="kendaraan" class="kendaraan section">
    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2 class="text">Kendaraan</h2>
        </div>

        <div class="row g-4">
            <?php while ($item = $resultkendaraan->fetch_object()): ?>
                <?php
                // Gunakan field image dari database
                $fotoFile = $item->image ?? '';

                // Path server untuk cek file
                $fileServerPath = __DIR__ . "/../../storages/kendaraan/" . $fotoFile;

                // Tentukan URL gambar untuk browser
                if (!empty($fotoFile) && is_file($fileServerPath)) {
                    $img = "../../storages/kendaraan/" . $fotoFile;
                } else {
                    $img = $default_image;
                }
                ?>

                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="kendaraan-card d-flex flex-column">
                        <div class="kendaraan-img">
                            <img src="../storages/kendaraan/<?= $item->image ?>" alt="">
                        </div>
                        <div class="kendaraan-info mt-2">
                            <h5><?= htmlspecialchars($item->jenis) ?> (<?= htmlspecialchars($item->merk . ' ' . $item->model) ?>)</h5>

                            <p><strong>Plat Nomor:</strong> <?= htmlspecialchars($item->plat_nomor) ?></p>
                            <p><strong>Tahun:</strong> <?= htmlspecialchars($item->tahun) ?></p>

                            <?php if (!empty($item->nama_pemilik)): ?>
                                <p><strong>Pemilik:</strong> <?= htmlspecialchars($item->nama_pemilik) ?></p>
                            <?php endif; ?>

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