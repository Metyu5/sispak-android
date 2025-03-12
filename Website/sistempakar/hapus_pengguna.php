<?php
// Koneksi ke database
include 'koneksi.php';

// Memeriksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    // Mengambil id_user dari URL
    $id_user = $_GET['id'];

    // Menyiapkan query untuk menghapus pengguna berdasarkan id_user
    $query = "DELETE FROM users WHERE id_user = $id_user";

    // Mengeksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika penghapusan berhasil, set variabel status dan alihkan
        $status = 'success';
    } else {
        // Jika ada kesalahan dalam penghapusan, set variabel status
        $status = 'error';
        $error_message = mysqli_error($conn);
    }

    // Redirect ke halaman pengguna.php dengan status penghapusan
    header('Location: pengguna.php?status=' . $status . '&error_message=' . $error_message);
    exit();
} else {
    // Jika parameter id tidak ada, alihkan ke halaman pengguna.php
    header('Location: pengguna.php');
    exit();
}
?>
