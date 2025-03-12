<?php
// Koneksi ke database
include 'koneksi.php';

// Cek apakah ada ID yang diterima dari URL
if (isset($_GET['id'])) {
    $idRule = $_GET['id'];

    // Query untuk mengambil data aturan berdasarkan ID
    $sql = "
        SELECT r.id_rule, r.id_penyakit, r.id_gejala, p.kode_penyakit, g.kode_gejala
        FROM rule r
        JOIN penyakit p ON r.id_penyakit = p.id_penyakit
        JOIN gejala g ON r.id_gejala = g.id_gejala
        WHERE r.id_rule = ?
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idRule);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
} else {
    echo "ID tidak ditemukan!";
    exit();
}

// Mengambil data penyakit dan gejala untuk dropdown
$sqlPenyakit = "SELECT id_penyakit, kode_penyakit FROM penyakit";
$resultPenyakit = $conn->query($sqlPenyakit);

$sqlGejala = "SELECT id_gejala, kode_gejala FROM gejala";
$resultGejala = $conn->query($sqlGejala);

// Proses ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPenyakit = $_POST['id_penyakit'];
    $idGejala = $_POST['id_gejala'];

    // Query untuk mengupdate data aturan
    $sqlUpdate = "UPDATE rule SET id_penyakit = ?, id_gejala = ? WHERE id_rule = ?";
    
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("iii", $idPenyakit, $idGejala, $idRule);

    if ($stmt->execute()) {
        // Redirect setelah update sukses
        header("Location: aturan.php?success=5");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement setelah selesai
    $stmt->close();
}
?>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>

<div class="moms-aturan-main-container">
    <div class="moms-aturan-content-container">
        <!-- Tombol Kembali ke Daftar Aturan -->
        <a href="aturan.php" class="moms-btn-aturan-back"> <i class="fas fa-arrow-left"></i>Kembali ke Daftar Aturan</a>
        <h2 class="moms-aturan-title">Edit Aturan</h2>

        <form method="POST" action="edit_aturan.php?id=<?php echo $row['id_rule']; ?>" class="moms-form-tambah-aturan">
            <div class="moms-form-group">
                <label for="id_penyakit" class="moms-form-label">Pilih Penyakit</label>
                <select name="id_penyakit" id="id_penyakit" class="moms-form-control" required>
                    <option value="">Pilih Penyakit</option>
                    <?php while ($rowPenyakit = $resultPenyakit->fetch_assoc()) : ?>
                        <option value="<?php echo $rowPenyakit['id_penyakit']; ?>" 
                            <?php echo ($row['id_penyakit'] == $rowPenyakit['id_penyakit']) ? 'selected' : ''; ?>>
                            <?php echo $rowPenyakit['kode_penyakit']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="moms-form-group">
                <label for="id_gejala" class="moms-form-label">Pilih Gejala</label>
                <select name="id_gejala" id="id_gejala" class="moms-form-control" required>
                    <option value="">Pilih Gejala</option>
                    <?php while ($rowGejala = $resultGejala->fetch_assoc()) : ?>
                        <option value="<?php echo $rowGejala['id_gejala']; ?>"
                            <?php echo ($row['id_gejala'] == $rowGejala['id_gejala']) ? 'selected' : ''; ?>>
                            <?php echo $rowGejala['kode_gejala']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <button type="submit" class="moms-btn-tambah-aturan">Update Aturan</button>
        </form>
    </div>
</div>

<!-- Script SweetAlert2 untuk notifikasi -->
<script>
<?php
// Cek apakah ada parameter success di URL
if (isset($_GET['success']) && $_GET['success'] == 5) {
    echo "
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Aturan berhasil diperbarui!',
        timer: 3000
    });
    ";
}
?>
</script>
