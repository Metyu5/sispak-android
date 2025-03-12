<?php
include('../koneksi.php');  

// Memeriksa apakah parameter 'id_penyakit' ada
if (isset($_GET['id_penyakit'])) {
    $id_penyakit = $_GET['id_penyakit'];

    // Validasi id_penyakit apakah merupakan angka
    if (is_numeric($id_penyakit)) {
        // Query untuk mengambil gejala berdasarkan id_penyakit
        $query = "SELECT gejala.id_gejala, gejala.nama_gejala, gejala.nilai_cf
                  FROM gejala
                  JOIN rule ON gejala.id_gejala = rule.id_gejala
                  WHERE rule.id_penyakit = ?";

        // Menyiapkan query
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id_penyakit);  // Binding parameter
        $stmt->execute();

        $result = $stmt->get_result();
        $gejalaList = array();

        // Ambil data hasil query
        while ($row = $result->fetch_assoc()) {
            $gejalaList[] = $row;
        }

        // Mengembalikan data dalam format JSON
        echo json_encode($gejalaList);
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
