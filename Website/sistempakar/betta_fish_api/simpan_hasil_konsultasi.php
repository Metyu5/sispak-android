<?php
// Koneksi ke database
include('../koneksi.php'); // Pastikan path benar dan file koneksi ada

// Membaca data JSON yang dikirimkan oleh Retrofit
$input = json_decode(file_get_contents('php://input'), true);

// Validasi data yang diterima
if (!isset($input['nama_pengguna'], $input['nama_penyakit'], $input['gejala_kategori'], $input['hasil_diagnosa'], $input['tanggal_diagnosa'])) {
    // Jika data tidak lengkap, kirimkan pesan error
    echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak lengkap. Semua parameter harus dikirim.'
    ]);
    exit();
}

// Ambil data dari input JSON
$nama_pengguna = $conn->real_escape_string($input['nama_pengguna']);
$nama_penyakit = $conn->real_escape_string($input['nama_penyakit']);
$gejala_kategori = json_encode($input['gejala_kategori']);  // Encode array ke JSON string
$hasil_diagnosa = $conn->real_escape_string($input['hasil_diagnosa']);
$tanggal_diagnosa = $conn->real_escape_string($input['tanggal_diagnosa']); // Format: yyyy-MM-dd HH:mm:ss

// Query untuk menyimpan data ke database menggunakan prepared statement
$query = "INSERT INTO hasil_konsultasi (nama_pengguna, nama_penyakit, gejala_kategori, hasil_diagnosa, tanggal_diagnosa) 
          VALUES (?, ?, ?, ?, ?)";

// Menyiapkan prepared statement
$stmt = $conn->prepare($query);

// Menambahkan parameter ke prepared statement dan mengeksekusi
$stmt->bind_param("sssss", $nama_pengguna, $nama_penyakit, $gejala_kategori, $hasil_diagnosa, $tanggal_diagnosa);

if ($stmt->execute()) {
    // Jika berhasil
    $response = array('status' => 'success', 'message' => 'Data berhasil disimpan');
} else {
    // Jika gagal
    $response = array('status' => 'error', 'message' => 'Gagal menyimpan data: ' . $stmt->error);
}

// Mengirimkan response dalam format JSON
echo json_encode($response);

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
