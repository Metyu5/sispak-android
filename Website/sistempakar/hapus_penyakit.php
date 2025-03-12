<?php
session_start();
// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
$servername = 'localhost';
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda
$dbname = 'db_bettafish'; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari URL
if (isset($_GET['id'])) {
    $kode_penyakit = $_GET['id'];

    // Query untuk menghapus data penyakit
    $sql = "DELETE FROM penyakit WHERE kode_penyakit = '$kode_penyakit'";

    if ($conn->query($sql) === TRUE) {
        // Jika berhasil, alihkan ke halaman penyakit.php dengan parameter success
        header("Location: penyakit.php?success=3");
        exit;
    } else {
        // Jika gagal, tampilkan error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // Jika ID tidak ada, alihkan ke halaman penyakit.php
    header("Location: penyakit.php");
    exit;
}

// Tutup koneksi
$conn->close();
?>
