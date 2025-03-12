<?php
include('koneksi.php'); // Koneksi ke database

// Cek apakah ID rule ada
if (isset($_GET['id'])) {
    $id_rule = $_GET['id'];
    
    // Query untuk mengambil data rule yang akan diedit
    $sql = "
        SELECT p.kode_penyakit, p.nama_penyakit, g.nama_gejala, r.id_rule, r.id_penyakit, r.id_gejala
        FROM rule r
        JOIN penyakit p ON r.id_penyakit = p.id_penyakit
        JOIN gejala g ON r.id_gejala = g.id_gejala
        WHERE r.id_rule = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_rule);
    $stmt->execute();
    $result = $stmt->get_result();

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $rule_data = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak ditemukan!";
    exit();
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id_penyakit = $_POST['id_penyakit'];
    $id_gejala = $_POST['id_gejala'];
    
    // Query untuk memperbarui data rule
    $update_sql = "UPDATE rule SET id_penyakit = ?, id_gejala = ? WHERE id_rule = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("iii", $id_penyakit, $id_gejala, $id_rule);
    
    if ($update_stmt->execute()) {
        // Jika berhasil, tampilkan notifikasi SweetAlert
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data rule berhasil diperbarui!',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'data_rule.php'; // Redirect ke halaman daftar rule
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Terjadi kesalahan saat memperbarui data!',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Rule</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Mengatur body dan layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h1 {
            text-align: center;
            color: #4A90E2;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 14px;
            color: #555;
        }

        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            background-color: #f9f9f9;
        }

        .form-group select:focus {
            border-color: #4A90E2;
        }

        .form-group button {
            width: 100%;
            padding: 10px;
            background-color: #4A90E2;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .form-group button:hover {
            background-color: #357ABD;
        }

        .form-footer {
            text-align: center;
            margin-top: 15px;
        }

        .form-footer a {
            text-decoration: none;
            color: #4A90E2;
            font-size: 14px;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

    </style>
</head>
<body>

    <div class="container">
        <h1>Edit Rule</h1>
        <form method="POST">
            <div class="form-group">
                <label for="penyakit">Pilih Penyakit</label>
                <select name="id_penyakit" id="penyakit" required>
                    <option value="">Pilih Penyakit</option>
                    <?php
                    // Menampilkan semua penyakit
                    $penyakit_sql = "SELECT * FROM penyakit";
                    $penyakit_result = $conn->query($penyakit_sql);
                    while ($penyakit = $penyakit_result->fetch_assoc()) {
                        echo "<option value='{$penyakit['id_penyakit']}'" . ($penyakit['id_penyakit'] == $rule_data['id_penyakit'] ? ' selected' : '') . ">{$penyakit['nama_penyakit']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="gejala">Pilih Gejala</label>
                <select name="id_gejala" id="gejala" required>
                    <option value="">Pilih Gejala</option>
                    <?php
                    // Menampilkan semua gejala
                    $gejala_sql = "SELECT * FROM gejala";
                    $gejala_result = $conn->query($gejala_sql);
                    while ($gejala = $gejala_result->fetch_assoc()) {
                        echo "<option value='{$gejala['id_gejala']}'" . ($gejala['id_gejala'] == $rule_data['id_gejala'] ? ' selected' : '') . ">{$gejala['nama_gejala']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Update Rule</button>
            </div>
        </form>

        <div class="form-footer">
            <a href="data_rule.php">Kembali ke Daftar Rule</a>
        </div>
    </div>

</body>
</html>
