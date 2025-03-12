<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_bettafish"; // Ganti dengan nama database yang sesuai

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM hasil_konsultasi"; // Query untuk mengambil data hasil konsultasi
$result = $conn->query($sql);

$history = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    echo json_encode($history); // Mengirimkan data dalam format JSON
} else {
    echo json_encode(array()); // Jika tidak ada data
}

$conn->close();
?>
