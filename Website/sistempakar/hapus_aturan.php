<?php
// Koneksi ke database
include 'koneksi.php';

// Cek apakah ada ID yang diterima
if (isset($_GET['id'])) {
    $idRule = $_GET['id'];

    // Query untuk menghapus data berdasarkan ID
    $sqlDelete = "DELETE FROM rule WHERE id_rule = ?";
    
    // Gunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare($sqlDelete);
    $stmt->bind_param("i", $idRule);

    if ($stmt->execute()) {
        // Redirect ke halaman aturan.php dengan parameter success=3 (berhasil hapus)
        header("Location: aturan.php?success=3");
        exit();
    } else {
        // Jika gagal menghapus data
        echo "Error: " . $stmt->error;
    }

    // Menutup statement setelah selesai
    $stmt->close();
} else {
    // Jika tidak ada ID yang diterima
    echo "ID tidak ditemukan.";
}
?>
