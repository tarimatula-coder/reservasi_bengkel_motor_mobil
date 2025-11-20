<?php
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// cek id
if (!isset($_GET['id'])) {
    echo "<script>alert('ID user tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// ambil data berdasarkan id
$queryUser = mysqli_query($connect, "
    SELECT 
        id,
        username,
        password,
        role,
        full_name,
        phone,
        email,
        is_active
    FROM users
    WHERE id = $id
") or die(mysqli_error($connect));

$user = mysqli_fetch_object($queryUser);

// jika tdk ada data
if (!$user) {
    echo "<script>alert('Data user tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}
?>

<div id="wrapper">
    <div class="content-wrapper">
        <div class="container-fluid">

            <div class="row mb-4">
                <div class="col-lg-12">
                    <h2>Edit Data User</h2>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-3">
                        <form action="../../actions/user/update.php" method="POST">

                            <input type="hidden" name="id" value="<?= $user->id ?>">

                            <div class="mb-3">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user->username) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Password</label>
                                <input type="text" name="password" class="form-control" value="<?= htmlspecialchars($user->password) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Role</label>
                                <select name="role" class="form-control" required>
                                    <option value="" disabled>Pilih role</option>
                                    <option value="admin" <?= $user->role == 'admin' ? 'selected' : '' ?>>Admin</option>
                                    <option value="pelanggan" <?= $user->role == 'pelanggan' ? 'selected' : '' ?>>Pelanggan</option>
                                    <option value="mekanik" <?= $user->role == 'mekanik' ? 'selected' : '' ?>>Mekanik</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user->full_name) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Phone</label>
                                <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($user->phone) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user->email) ?>" required>
                            </div>

                            <div class="mb-3">
                                <label>Status Aktif</label>
                                <select name="is_active" class="form-control" required>
                                    <option value="1" <?= $user->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                                    <option value="0" <?= $user->is_active == 0 ? 'selected' : '' ?>>Non Aktif</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="index.php" class="btn btn-secondary">Kembali</a>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    html,
    body {
        height: 100%;
    }

    #wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .content-wrapper {
        flex: 1;
    }
</style>

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>