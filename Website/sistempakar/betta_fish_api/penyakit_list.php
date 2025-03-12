<?php
header("Content-Type: application/json");

// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";  // Ganti dengan username database Anda
$password = "";      // Ganti dengan password database Anda
$dbname = "db_bettafish";  // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil data penyakit
$sql = "SELECT id_penyakit, nama_penyakit FROM penyakit";
$result = $conn->query($sql);

// Array untuk menyimpan data penyakit
$penyakitList = array();

if ($result->num_rows > 0) {
    // Mengambil data penyakit
    while ($row = $result->fetch_assoc()) {
        $penyakit = array(
            'id' => $row['id_penyakit'],
            'nama' => $row['nama_penyakit']
        );
        array_push($penyakitList, $penyakit);
    }
} else {
    echo json_encode(array("message" => "Tidak ada data penyakit"));
}

echo json_encode($penyakitList);  // Mengirim data dalam format JSON

$conn->close();
?>
