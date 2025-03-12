<?php
// Koneksi ke database
include 'koneksi.php';

// Mengambil data penyakit
$sqlPenyakit = "SELECT id_penyakit, kode_penyakit FROM penyakit";
$resultPenyakit = $conn->query($sqlPenyakit);

// Mengambil data gejala
$sqlGejala = "SELECT id_gejala, kode_gejala FROM gejala";
$resultGejala = $conn->query($sqlGejala);

// Proses ketika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idPenyakit = $_POST['id_penyakit'];
    $idGejala = $_POST['id_gejala'];

    // Gunakan prepared statement untuk memasukkan data
    $stmt = $conn->prepare("INSERT INTO rule (id_penyakit, id_gejala) VALUES (?, ?)");
    $stmt->bind_param("ii", $idPenyakit, $idGejala);

    if ($stmt->execute()) {
        // Redirect dengan parameter success setelah data berhasil ditambahkan
        header("Location: aturan.php?success=1");
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
        <h2 class="moms-aturan-title">Tambah Aturan</h2>

        <form method="POST" action="tambah_aturan.php" class="moms-form-tambah-aturan">
            <div class="moms-form-group">
                <label for="id_penyakit" class="moms-form-label">Pilih Penyakit</label>
                <select name="id_penyakit" id="id_penyakit" class="moms-form-control" required>
                    <option value="">Pilih Penyakit</option>
                    <?php while ($rowPenyakit = $resultPenyakit->fetch_assoc()) : ?>
                        <option value="<?php echo $rowPenyakit['id_penyakit']; ?>"><?php echo $rowPenyakit['kode_penyakit']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="moms-form-group">
                <label for="id_gejala" class="moms-form-label">Pilih Gejala</label>
                <select name="id_gejala" id="id_gejala" class="moms-form-control" required>
                    <option value="">Pilih Gejala</option>
                    <?php while ($rowGejala = $resultGejala->fetch_assoc()) : ?>
                        <option value="<?php echo $rowGejala['id_gejala']; ?>"><?php echo $rowGejala['kode_gejala']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="moms-btn-tambah-aturan">Tambah Aturan</button>
        </form>
    </div>
</div>

<!-- Script SweetAlert2 untuk notifikasi -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php
// Cek apakah ada parameter success di URL
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Aturan berhasil ditambahkan!',
        timer: 3000
    });
    ";
}
?>
</script>
