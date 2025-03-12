<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bettafish";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dari POST
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password']; // Password yang dimasukkan oleh pengguna


// Query untuk menyimpan data pendaftaran
$sql = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

// Cek apakah query berhasil
if ($conn->query($sql) === TRUE) {
    echo "Registration Successful!";
} else {
    echo "Registration Failed: " . $conn->error;  // Tampilkan error jika query gagal
}

$conn->close();
?>
