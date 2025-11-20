<?php
include '../../app.php'; // koneksi ke database

// Pastikan ID ada di URL
if (!isset($_GET['id'])) {
    echo "
    <script>
        alert('ID transaksi tidak ditemukan!');
        window.location.href='../../pages/transaksi/index.php';
    </script>
    ";
    exit;
}

$id = intval($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $reservasi_id = trim($_POST['reservasi_id'] ?? '');
    $tipe_pembayaran = trim($_POST['tipe_pembayaran'] ?? '');
    $nominal = trim($_POST['nominal'] ?? '');
    $tanggal_pembayaran = trim($_POST['tanggal_pembayaran'] ?? '');
    $status = trim($_POST['status'] ?? '');

    // Hilangkan titik ribuan dari nominal (misal: 1.000.000 → 1000000)
    $nominal = str_replace('.', '', $nominal);

    // Validasi wajib diisi
    if (empty($reservasi_id) || empty($tipe_pembayaran) || empty($nominal) || empty($tanggal_pembayaran) || empty($status)) {
        echo "
        <script>
            alert('Pastikan semua data wajib diisi!');
            window.history.back();
        </script>
        ";
        exit;
    }

    // 🔹 Validasi agar status sesuai dengan enum di database
    $statusValid = ['pending', 'confirmed', 'rejected'];
    if (!in_array($status, $statusValid)) {
        echo "
        <script>
            alert('Status tidak valid!');
            window.history.back();
        </script>
        ";
        exit;
    }

    // Ambil data lama (untuk hapus gambar lama jika diganti)
    $qLama = mysqli_query($connect, "SELECT bukti_transfer FROM transaksi WHERE id = $id");
    $dataLama = mysqli_fetch_assoc($qLama);
    $namaFileLama = $dataLama['bukti_transfer'] ?? '';

    // Proses upload bukti transfer (jika ada file baru)
    $namaFileBaru = $namaFileLama; // default: pakai yang lama
    if (!empty($_FILES['bukti_transfer']['name'])) {
        $targetDir = '../../../storages/bukti_transfer/';
        $namaFileUpload = time() . '_' . basename($_FILES['bukti_transfer']['name']);
        $targetFile = $targetDir . $namaFileUpload;

        // Pindahkan file ke folder
        if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $targetFile)) {
            // Hapus file lama jika ada
            if (!empty($namaFileLama) && file_exists($targetDir . $namaFileLama)) {
                unlink($targetDir . $namaFileLama);
            }
            $namaFileBaru = $namaFileUpload;
        }
    }

    // Update data transaksi
    $qUpdate = "
        UPDATE transaksi SET
            reservasi_id = '$reservasi_id',
            tipe_pembayaran = '$tipe_pembayaran',
            nominal = '$nominal',
            tanggal_pembayaran = '$tanggal_pembayaran',
            status = '$status',
            bukti_transfer = '$namaFileBaru'
        WHERE id = '$id'
    ";

    $update = mysqli_query($connect, $qUpdate);

    if ($update) {
        echo "
        <script>
            alert('Data transaksi berhasil diperbarui!');
            window.location.href='../../pages/transaksi/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Terjadi kesalahan saat memperbarui data: " . mysqli_error($connect) . "');
            window.history.back();
        </script>
        ";
    }
} else {
    echo "
    <script>
        alert('Akses tidak valid!');
        window.location.href='../../pages/transaksi/index.php';
    </script>
    ";
}
