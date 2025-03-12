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

$conn = new mysqli($servername, $username, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah ada parameter id di URL
if (isset($_GET['id'])) {
    $kode_penyakit = $_GET['id'];
    
    // Query untuk mengambil data penyakit
    $sql = "SELECT * FROM penyakit WHERE kode_penyakit = '$kode_penyakit'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Penyakit tidak ditemukan.";
        exit;
    }
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $gejala = $_POST['gejala_penyakit'];
    $penanganan = $_POST['cara_penanganan'];

    if (!empty($kode_penyakit) && !empty($nama_penyakit) && !empty($gejala) && !empty($penanganan)) {
        // Query untuk mengupdate data
        $sql_update = "UPDATE penyakit SET nama_penyakit='$nama_penyakit', gejala='$gejala', penanganan='$penanganan' WHERE kode_penyakit='$kode_penyakit'";
        
        if ($conn->query($sql_update) === TRUE) {
            header("Location: penyakit.php?success=2");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Semua field harus diisi.";
    }
}

// Tutup koneksi
$conn->close();
?>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<!-- Konten utama -->
<div class="main-content">
    <div class="container">
        <a href="penyakit.php" class="btn-back-data">Kembali ke Data Penyakit</a>
        <h2>Edit Data Penyakit</h2>
        <div class="card animate__animated animate__fadeIn">
            <form action="edit_penyakit.php?id=<?php echo $row['kode_penyakit']; ?>" method="POST" class="form-tambahpenyakit">

                <div class="form-group">
                    <label for="kode_penyakit">Kode Penyakit</label>
                    <input type="text" id="kode_penyakit" name="kode_penyakit" class="form-control" value="<?php echo $row['kode_penyakit']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="nama_penyakit">Nama Penyakit</label>
                    <input type="text" id="nama_penyakit" name="nama_penyakit" class="form-control" value="<?php echo $row['nama_penyakit']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="gejala_penyakit">Gejala Penyakit</label>
                    <textarea id="gejala_penyakit" name="gejala_penyakit" class="form-control" required><?php echo $row['gejala']; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="cara_penanganan">Cara Penanganan</label>
                    <textarea id="cara_penanganan" name="cara_penanganan" class="form-control" required><?php echo $row['penanganan']; ?></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-tambah-penyakit">Update Penyakit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
