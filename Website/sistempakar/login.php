<?php
session_start(); // Mulai session

// Include file koneksi.php untuk koneksi ke database
include 'koneksi.php';

// Cek apakah form login sudah disubmit
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mencocokkan username dan password
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    // Cek apakah ada data yang cocok
    if ($result->num_rows > 0) {
        // Login berhasil
        $_SESSION['username'] = $username; // Simpan username di session
        $_SESSION['loggedin'] = true; // Tandai sebagai sudah login
        
        // Redirect ke index.php dengan parameter success
        header("Location: index.php?success=login");
        exit;
    } else {
        // Login gagal, redirect ke index.php dengan parameter error
        header("Location: index.php?error=invalid");
        exit;
    }
}

$conn->close(); // Tutup koneksi
?>
