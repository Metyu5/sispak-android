<?php
// Koneksi ke database
include 'koneksi.php';

// Mulai session untuk menyimpan notifikasi
session_start();

// Cek apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_gejala = $_GET['id'];

    // Query untuk menghapus gejala berdasarkan id_gejala
    $sql_delete = "DELETE FROM gejala WHERE id_gejala = '$id_gejala'";

    if ($conn->query($sql_delete) === TRUE) {
        // Set notifikasi berhasil
        $_SESSION['notifikasi'] = [
            'type' => 'success',
            'title' => 'Berhasil',
            'message' => 'Gejala berhasil dihapus!'
        ];
        // Redirect ke halaman daftar gejala dengan parameter success
        header("Location: gejala.php?success=3");
        exit;
    } else {
        // Set notifikasi gagal
        $_SESSION['notifikasi'] = [
            'type' => 'error',
            'title' => 'Gagal',
            'message' => 'Gagal menghapus gejala!'
        ];
        // Redirect ke halaman daftar gejala dengan parameter error
        header("Location: gejala.php?error=1");
        exit;
    }
} else {
    echo "ID gejala tidak ditemukan.";
}

// Tutup koneksi
$conn->close();
?>
