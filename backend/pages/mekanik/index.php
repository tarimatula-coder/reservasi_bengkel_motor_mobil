<?php
// Memanggil file header, sidebar, dan navbar agar tampilan halaman tetap konsisten
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Membuat query untuk mengambil data dari tabel mekanik yang berelasi dengan tabel reservasi
$queryMekanik = "SELECT 
        mekanik.id AS id_mekanik,
        mekanik.nama AS nama_mekanik,
        mekanik.skill AS skill_mekanik,
        mekanik.phone AS phone_mekanik,
        mekanik.is_available AS is_available,
        reservasi.id AS id_reservasi,
        reservasi.tanggal AS tanggal_reservasi,
        reservasi.waktu AS waktu_reservasi,
        reservasi.durasi_minutes AS durasi_reservasi,
        reservasi.status AS status_reservasi,
        reservasi.total_harga AS total_harga_reservasi,
        reservasi.catatan AS catatan_reservasi
    FROM mekanik
    LEFT JOIN reservasi 
        ON reservasi.mekanik_id = mekanik.id
    ORDER BY mekanik.id DESC
";

// Menjalankan query dan menyimpan hasilnya ke dalam variabel $resultMekanik
$resultMekanik = mysqli_query($connect, $queryMekanik) or die(mysqli_error($connect));
?>

<!-- Loader untuk efek saat halaman sedang dimuat -->
<div id="pageloader-overlay" class="visible incoming">
    <div class="loader-wrapper-outer">
        <div class="loader-wrapper-inner">
            <div class="loader"></div>
        </div>
    </div>
</div>

<!-- Awal konten halaman -->
<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <!-- Bagian judul halaman dan tombol tambah data mekanik -->
            <div class="row mb-3">
                <div class="col-lg-12 d-flex justify-content-between align-items-center">
                    <h4 class="mt-3">Data Mekanik</h4>
                    <a href="create.php" class="btn btn-danger btn-sm d-flex align-items-center">
                        <span class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mr-2"
                            style="width:22px; height:22px;">
                            <i class="fa fa-plus"></i>
                        </span>
                        Tambah Mekanik
                    </a>
                </div>
            </div>

            <!-- Bagian tabel untuk menampilkan data mekanik -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <div class="table-responsive">

                                <table id="datatable" class="table table-striped table-bordered align-middle">
                                    <thead class="table-dark text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Mekanik</th>
                                            <th>Keahlian (Skill)</th>
                                            <th>Nomor Telepon</th>
                                            <th>is_available</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        // Mengecek apakah ada data hasil query
                                        if (mysqli_num_rows($resultMekanik) > 0) {
                                            // Inisialisasi nomor urut tabel
                                            $nomorUrut = 1;

                                            // Melakukan perulangan untuk menampilkan setiap data mekanik
                                            while ($dataMekanik = mysqli_fetch_object($resultMekanik)) {
                                        ?>
                                                <tr>
                                                    <!-- Menampilkan nomor urut -->
                                                    <td class="text-center"><?= $nomorUrut++ ?></td>

                                                    <!-- Menampilkan nama mekanik -->
                                                    <td><?= htmlspecialchars($dataMekanik->nama_mekanik) ?></td>

                                                    <!-- Menampilkan skill mekanik -->
                                                    <td><?= htmlspecialchars($dataMekanik->skill_mekanik ?? '-') ?></td>

                                                    <!-- Menampilkan nomor telepon mekanik -->
                                                    <td><?= htmlspecialchars($dataMekanik->phone_mekanik ?? '-') ?></td>

                                                    <td class="text-center">
                                                        <?php if ($dataMekanik->is_available == 1): ?>
                                                            <span class="badge bg-success">Available</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Not Available</span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <!-- Tombol Aksi -->
                                                    <td class="text-center">
                                                        <a href="edit.php?id=<?= $dataMekanik->id_mekanik ?>" class="btn btn-warning btn-sm mb-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a href="../../actions/mekanik/destroy.php?id=<?= $dataMekanik->id_mekanik ?>"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            <i class="fa fa-trash"></i> Hapus
                                                        </a>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } else {
                                            // Jika tidak ada data mekanik sama sekali
                                            echo "<tr><td colspan='11' class='text-center text-muted'>Tidak ada data mekanik yang tersedia</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div> <!-- Akhir table-responsive -->
                        </div> <!-- Akhir card-body -->
                    </div> <!-- Akhir card -->
                </div> <!-- Akhir col -->
            </div> <!-- Akhir row -->

            <div class="overlay toggle-menu"></div>
        </div> <!-- Akhir container-fluid -->
    </div> <!-- Akhir content-wrapper -->
</div> <!-- Akhir wrapper -->

<!-- Memanggil script dan footer -->
<?php
include '../../partials/script.php';
include '../../partials/footer.php';
?>