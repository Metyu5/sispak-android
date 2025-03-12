<?php
include 'koneksi.php'; // Koneksi database

$id_user = isset($_GET['id']) ? $_GET['id'] : null;

// Validasi apakah ID ada dan merupakan angka
if (!$id_user || !is_numeric($id_user)) {
    header('Location: pengguna.php?action=edit&status=error&error_message=ID pengguna tidak valid');
    exit;
}

// Query untuk mengambil data pengguna berdasarkan ID
$query = "SELECT * FROM users WHERE id_user = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id_user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

// Jika pengguna tidak ditemukan
if (!$user) {
    header('Location: pengguna.php?action=edit&status=error&error_message=Pengguna tidak ditemukan');
    exit;
}

// Update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']); // Anda bisa hash password di sini jika perlu

    // Query untuk update data pengguna
    $updateQuery = "UPDATE users SET username = ?, email = ?, password = ? WHERE id_user = ?";
    $updateStmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($updateStmt, "sssi", $username, $email, $password, $id_user);

    if (mysqli_stmt_execute($updateStmt)) {
        header('Location: pengguna.php?action=edit&status=edit_success');
        exit;
    } else {
        header('Location: pengguna.php?action=edit&status=error&error_message=Gagal memperbarui pengguna');
        exit;
    }
}
?>



<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>


<div class="edit-pengguna-container">
    <a href="pengguna.php" class="btn-pengguna-add" style="background-color: #6c757d;">Kembali</a>
    <h2 class="pengguna-title">Edit Pengguna</h2>
    <hr class="thick">
    <form method="POST" action="">
        <div>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" required>
        </div>
        <div>
            <label for="password">Password</label>
            <input type="text" id="password" name="password" value="<?= htmlspecialchars($user['password']); ?>" required>
        </div>
        <button type="submit" class="btn-pengguna-add">Simpan Perubahan</button>
    </form>
</div>


<?php include 'footer.php'; ?>
<!-- SweetAlert Notifications -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    <?php if (isset($_GET['action']) && $_GET['action'] === 'edit'): ?>
            Swal.fire({
                title: 'Sukses!',
                text: 'Data pengguna berhasil diperbarui.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pengguna.php';
                }
            });
        <?php elseif (isset($_GET['action']) && $_GET['action'] === 'error'): ?>
            Swal.fire({
                title: 'Error!',
                text: 'Terjadi kesalahan saat memperbarui data pengguna: <?= htmlspecialchars($_GET["error_message"]); ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        <?php endif; ?>
</script>
