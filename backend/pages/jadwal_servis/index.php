<?php
session_start();
include '../../../config/connection.php';

// CEK LOGIN
if (!isset($_SESSION['role'])) {
    header("Location: ../../pages/auth/login.php");
    exit;
}

$role = $_SESSION['role'];
$user_id = $_SESSION['id_user'] ?? null;
$pelanggan_sessi_id = $_SESSION['id_pelanggan'] ?? null;

$mekanik_id = null;
$pelanggan_id = null;

// Ambil ID mekanik/pelanggan untuk filter data
if ($role === 'mekanik') {
    // Mencari ID mekanik berdasarkan user_id dari tabel users
    $q = mysqli_query($connect, "SELECT id FROM mekanik WHERE user_id='$user_id' LIMIT 1");
    $r = mysqli_fetch_assoc($q);
    $mekanik_id = $r['id'] ?? null;
} elseif ($role === 'pelanggan') {
    // Pelanggan menggunakan id_pelanggan yang disimpan di session
    $pelanggan_id = $pelanggan_sessi_id;
}

// QUERY UTAMA
$query = "SELECT 
    r.id,
    p.nama AS nama_pelanggan,
    k.jenis AS jenis_kendaraan,
    k.merk, k.model, k.plat_nomor,
    m.nama AS nama_mekanik,
    l.nama_layanan,
    r.tanggal, r.waktu, r.durasi_minutes,
    r.status, r.total_harga, r.catatan
    FROM reservasi r
    LEFT JOIN pelanggan p ON r.pelanggan_id=p.id
    LEFT JOIN kendaraan k ON r.kendaraan_id=k.id
    LEFT JOIN mekanik m ON r.mekanik_id=m.id
    LEFT JOIN layanan l ON r.layanan_id=l.id
    WHERE 1=1";

// FILTER SESUAI ROLE (Filter Mekanik tetap aktif)
if ($role === 'mekanik' && $mekanik_id) {
    // Mekanik hanya melihat reservasi mereka
    $query .= " AND r.mekanik_id='$mekanik_id'";
} elseif ($role === 'pelanggan' && $pelanggan_id) {
    // Pelanggan hanya melihat reservasi mereka
    $query .= " AND r.pelanggan_id='$pelanggan_id'";
}
// Admin melihat semua data karena tidak ada filter yang ditambahkan

$query .= " ORDER BY r.tanggal DESC, r.waktu DESC";
$result = mysqli_query($connect, $query);

// TEMPLATE
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Jadwal Servis & Status Perbaikan</h5>

                        <?php if ($role === 'admin'): ?>
                            <a href="../reservasi/create.php" class="btn btn-danger btn-sm"><i class="fa fa-plus mr-2"></i>
                                Tambah Reservasi Baru
                            </a>
                        <?php endif; ?>
                    </div>


                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>Plat</th>
                                    <th>Mekanik</th>
                                    <th>Layanan</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Durasi</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Catatan</th>
                                    <?php if ($role === 'admin' || $role === 'mekanik'): ?>
                                        <th>Aksi</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>

                                <?php if (mysqli_num_rows($result) > 0) {
                                    $no = 1;
                                    // Colspan 13 jika ada kolom Aksi, 12 jika tidak ada
                                    $colSpan = ($role === 'admin' || $role === 'mekanik') ? 13 : 12;

                                    while ($row = mysqli_fetch_assoc($result)) {

                                        // Penentuan kelas badge untuk status
                                        $statusClass = match ($row['status']) {
                                            'booked' => 'bg-primary',
                                            'in-progress' => 'bg-warning',
                                            'completed' => 'bg-success',
                                            'cancelled' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                ?>

                                        <tr>
                                            <td class="text-center"><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_pelanggan'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['jenis_kendaraan'] . " - " . $row['merk'] . " - " . $row['model']) ?></td>
                                            <td class="text-center"><?= htmlspecialchars($row['plat_nomor']) ?></td>
                                            <td><?= htmlspecialchars($row['nama_mekanik'] ?? '-') ?></td>
                                            <td><?= htmlspecialchars($row['nama_layanan'] ?? '-') ?></td>

                                            <td class="text-center"><?= date('d M Y', strtotime($row['tanggal'])) ?></td>
                                            <td class="text-center"><?= substr($row['waktu'], 0, 5) ?></td>
                                            <td class="text-center"><?= $row['durasi_minutes'] ?> menit</td>

                                            <td class="text-center">
                                                <span class="badge <?= $statusClass ?>">
                                                    <?= htmlspecialchars($row['status']) ?>
                                                </span>
                                            </td>

                                            <td class="text-end">Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                            <td><?= htmlspecialchars($row['catatan'] ?? '-') ?></td>

                                            <?php if ($role === 'admin' || $role === 'mekanik'): ?>
                                                <td class="text-center" style="min-width: 150px;">
                                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm m-1">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>

                                                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm m-1"
                                                        onclick="return confirm('PERINGATAN! Yakin ingin menghapus data reservasi ini? Aksi ini tidak dapat dibatalkan.');">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </a>
                                                </td>
                                            <?php endif; ?>

                                        </tr>

                                    <?php }
                                } else {
                                    $colSpan = ($role === 'admin' || $role === 'mekanik') ? 13 : 12;
                                    ?>

                                    <tr>
                                        <td colspan="<?= $colSpan ?>" class="text-center">Belum ada data reservasi</td>
                                    </tr>

                                <?php } ?>

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>