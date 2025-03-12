<?php
// Pastikan koneksi.php di-include dengan path yang benar
include('../koneksi.php');  // Perbaiki path jika perlu

// Memeriksa apakah parameter 'id_penyakit' ada
if (isset($_GET['id_penyakit'])) {
    $id_penyakit = $_GET['id_penyakit'];

    // Validasi id_penyakit apakah merupakan angka
    if (is_numeric($id_penyakit)) {
        // Query untuk mengambil penanganan penyakit berdasarkan id_penyakit
        $query = "SELECT penanganan FROM penyakit WHERE id_penyakit = ?";

        // Menyiapkan query
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_penyakit);  // Binding parameter
        $stmt->execute();

        $result = $stmt->get_result();
        
        // Cek jika hasil ditemukan
        if ($result->num_rows > 0) {
            // Mengambil data penanganan
            $penanganan = $result->fetch_assoc();
            
            // Mengembalikan data dalam format JSON
            echo json_encode($penanganan);
        } else {
            // Jika tidak ada data penanganan untuk id_penyakit tersebut
            echo json_encode(array("message" => "Penanganan tidak ditemukan untuk id_penyakit: $id_penyakit"));
        }

        $stmt->close();
    } else {
        // Jika id_penyakit tidak valid
        echo json_encode(array("message" => "id_penyakit must be a valid number"));
        exit();
    }
} else {
    // Jika parameter id_penyakit tidak ada
    echo json_encode(array("message" => "id_penyakit is required"));
    exit();
}

$conn->close();
?>
