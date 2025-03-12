<?php
session_start();
// Pastikan user sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php'; // Koneksi ke database

// Ambil username dari session
$username = $_SESSION['username'];

// Query untuk mengambil nama berdasarkan username
$sql = "SELECT nama FROM admin WHERE username = '$username'"; // Sesuaikan dengan tabel dan kolom yang ada
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nama = $row['nama']; // Kolom 'nama' dari hasil query
} else {
    $nama = 'Pengguna Tidak Ditemukan';
}

$conn->close(); // Tutup koneksi
?>

<?php include 'header.php'; ?>

<!-- Sidebar -->
<?php include 'sidebar.php'; ?>

<!-- Konten Utama -->
<?php include 'konten.php'; ?>

<!-- Footer -->
<?php include 'footer.php'; ?>
