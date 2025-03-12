<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Koneksi ke database
$servername = 'localhost';
$username = 'root'; // Ganti dengan username database Anda
$password = ''; // Ganti dengan password database Anda
$dbname = 'db_bettafish'; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Pastikan form disubmit dengan method POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $gejala = $_POST['gejala_penyakit']; // Menggunakan nama form yang benar
    $penanganan = $_POST['cara_penanganan']; // Menggunakan nama form yang benar

    // Pastikan data tidak kosong
    if (!empty($kode_penyakit) && !empty($nama_penyakit) && !empty($gejala) && !empty($penanganan)) {
        // Query untuk menyimpan data ke database dengan prepared statement
        $stmt = $conn->prepare("INSERT INTO penyakit (kode_penyakit, nama_penyakit, gejala, penanganan) 
                VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $kode_penyakit, $nama_penyakit, $gejala, $penanganan);

        // Eksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, alihkan ke halaman penyakit.php dengan parameter success
            header("Location: penyakit.php?success=1");
            exit;
        } else {
            // Jika gagal, tampilkan error
            echo "Error: " . $stmt->error;
        }

        // Tutup statement
        $stmt->close();
    } else {
        // Jika ada data kosong, alihkan ke halaman tambah_penyakit.php dengan error
        header("Location: tambah_penyakit.php?error=1");
        exit;
    }
}

// Tutup koneksi
$conn->close();
?>
