<?php
$qMekanik  = "SELECT * FROM mekanik LIMIT 7";
$resultmekanik = mysqli_query($connect, $qMekanik) or die(mysqli_error($connect));

// 4 gambar default
$default_images = [
    "asset/img/bengkel_motor.jpg",
    "asset/img/images (1).jpg",
    "asset/img/images.jpg",
    "asset/img/mekanik.jpg"
];

$index = 0;
?>

<section id="mekanik" class="mekanik section">

    <div class="container">
        <div class="container section-title" data-aos="fade-up">
            <h2 class="text">Mekanik</h2>
        </div>

        <div class="row gy-4">

            <?php while ($item = $resultmekanik->fetch_object()): ?>

                <?php
                // Jika punya foto di database gunakan itu, jika tidak pakai default
                $foto = (!empty($item->foto))
                    ? "asset/img/" . $item->foto
                    : $default_images[$index % 4];

                $index++;
                ?>

                <div class="col-lg-3 col-md-6" data-aos="fade-up">

                    <div class="mekanik-card">

                        <div class="mekanik-img-wrapper">
                            <img src="../storages/mekanik/<?= $item->image ?>" alt="">
                        </div>

                        <div class="card-body text-center">
                            <h5 class="card-title"><?= $item->nama ?></h5>

                            <p class="mb-1"><strong>Skill:</strong> <?= $item->skill ?></p>

                            <p class="mb-1"><strong>Phone:</strong> <?= $item->phone ?></p>

                            <span class="badge 
                                <?= ($item->is_available == 1) ? 'bg-success' : 'bg-danger' ?>">
                                <?= ($item->is_available == 1) ? "Tersedia" : "Tidak Tersedia"; ?>
                            </span>
                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        </div>
    </div>

</section>

<style>
    .mekanik-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        border: 1px solid #e6e6e6;
    }

    .mekanik-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.15);
    }

    .mekanik-img-wrapper {
        width: 100%;
        height: 220px;
        overflow: hidden;
    }

    .mekanik-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .card-body {
        padding: 18px;
    }

    .card-title {
        font-weight: 600;
        margin-bottom: 10px;
    }
</style>