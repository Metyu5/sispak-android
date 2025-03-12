<?php
// Koneksi ke database
include 'koneksi.php';

// Periksa apakah parameter 'id' ada di URL
if (isset($_GET['id'])) {
    $id_gejala = $_GET['id'];

    // Query untuk mengambil data gejala berdasarkan id_gejala
    $sql = "SELECT * FROM gejala WHERE id_gejala = '$id_gejala'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Gejala tidak ditemukan.";
        exit;
    }
} else {
    echo "ID gejala tidak ditemukan.";
    exit;
}

// Proses update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];
    $nilai_cf = $_POST['nilai_cf'];

    // Query untuk mengupdate data gejala
    $sql_update = "UPDATE gejala SET kode_gejala='$kode_gejala', nama_gejala='$nama_gejala', nilai_cf='$nilai_cf' WHERE id_gejala='$id_gejala'";

    if ($conn->query($sql_update) === TRUE) {
        // Redirect ke halaman daftar gejala setelah berhasil update dengan parameter success=2
        header("Location: edit_gejala.php?id=$id_gejala&success=2");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Tutup koneksi
$conn->close();
?>

<!-- Menyertakan header.php -->
<?php include 'header.php'; ?>

<!-- Menyertakan sidebar.php -->
<?php include 'sidebar.php'; ?>

<div class="gejala-main-container">
    <div class="gejala-content-container">
         <!-- Tombol Kembali ke Daftar Gejala -->
        <a href="gejala.php" class="btn-back-gejala">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Gejala
        </a>
        <h2 class="gejala-title">Edit Gejala</h2>
        <form action="edit_gejala.php?id=<?php echo $row['id_gejala']; ?>" method="POST" class="gejala-form">
            <div class="form-group">
                <label for="kode_gejala">Kode Gejala</label>
                <input type="text" id="kode_gejala" name="kode_gejala" class="form-control" value="<?php echo $row['kode_gejala']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nama_gejala">Nama Gejala</label>
                <input type="text" id="nama_gejala" name="nama_gejala" class="form-control" value="<?php echo $row['nama_gejala']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nilai_cf">Nilai CF</label>
                <input type="number" id="nilai_cf" name="nilai_cf" class="form-control" value="<?php echo $row['nilai_cf']; ?>" required step="0.01" min="0" max="1">
            </div>

            <div class="form-group">
                <button type="submit" class="btn-update-gejala">Update Gejala</button>
            </div>
        </form>
    </div>
</div>

<!-- Menyertakan footer.php -->
<?php include 'footer.php'; ?>

<!-- Menyertakan SweetAlert JS dan CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Menampilkan SweetAlert jika update berhasil -->
<script>
    // Menampilkan SweetAlert jika success=2 ada di URL
    <?php 
    if (isset($_GET['success']) && $_GET['success'] == 2) { ?>
        Swal.fire({
            title: 'Sukses!',
            text: 'Gejala berhasil diperbarui.',
            icon: 'success',
            confirmButtonText: 'OK',
            background: '#f2f2f2', // Background color
            color: '#333', // Text color
            confirmButtonColor: '#007bff', // Button color
        }).then(function() {
            window.location = 'gejala.php'; // Redirect ke halaman gejala.php setelah klik OK
        });
    <?php } ?>
</script>

<style>
    /* Styling form */
    /* Styling untuk kontainer utama */
    /* Styling untuk tombol kembali */
.btn-back-gejala {
    display: inline-block;
  padding: 10px 20px;
  margin-bottom: 20px; /* Memberikan jarak dari elemen bawah */
  background-color: #4caf50;
  color: white;
  font-size: 16px;
  font-weight: bold;
  text-decoration: none;
  border-radius: 8px;
  text-align: center;
  transition: background-color 0.3s ease, transform 0.3s ease;
}

/* Styling untuk ikon di tombol */
.btn-back-gejala i {
    margin-right: 8px;  /* Memberikan jarak antara ikon dan teks */
}

/* Hover effect untuk tombol kembali */
.btn-back-gejala:hover {
   background-color: #45a049; /* Ganti warna ketika hover */
    transform: translateY(-3px); /* Efek tombol terangkat saat hover */
}

/* Tombol kembali saat di-klik */
.btn-back-gejala:active {
    background-color: #003366; /* Warna biru yang lebih gelap saat klik */
    transform: translateY(0); /* Mengembalikan tombol ke posisi semula */
}

/* Efek Focus */
.btn-back-gejala:focus {
  outline: none;
  box-shadow: 0 0 10px rgba(0, 255, 0, 0.4); /* Menambah efek focus */
}


.gejala-main-container {
    width: 100%;
    padding: 40px;
    display: flex;
    justify-content: center;
    background-color: #f7f7f7;
}

/* Styling untuk kontainer konten gejala */
/* Styling untuk kontainer utama */
.gejala-main-container {
    width: 100%;
    padding: 20px;  /* Mengurangi padding */
    display: flex;
    justify-content: center;
    background-color: #f7f7f7;
}

/* Styling untuk kontainer konten gejala */
.gejala-content-container {
    background-color: #fff;
    padding: 25px;  /* Mengurangi padding */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 800px; /* Lebar kontainer lebih kecil */
}

/* Styling judul */
.gejala-title {
    text-align: center;
    font-size: 24px;  /* Ukuran font sedikit lebih kecil */
    color: #333;
    margin-bottom: 20px;
}

/* Styling form */
.gejala-form {
    display: flex;
    flex-direction: column;
}

/* Styling untuk setiap grup input */
.form-group {
    margin-bottom: 20px;
}

/* Styling label input */
.form-group label {
    font-size: 14px;  /* Ukuran font label lebih kecil */
    color: #555;
    margin-bottom: 5px;
}

/* Styling input teks */
.form-group input {
    padding: 10px;
    font-size: 16px;  /* Ukuran font input lebih kecil */
    border: 1px solid #ddd;
    border-radius: 8px;
    width: 100%;
}

/* Styling untuk tombol update */
.btn-update-gejala {
    padding: 12px;  /* Mengurangi padding tombol */
    background-color: #007bff;
    color: white;
    font-size: 18px;  /* Ukuran font tombol lebih kecil */
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    width: 100%; /* Tombol tetap melebar */
    font-family: 'Poppins', sans-serif;
}

.btn-update-gejala:hover {
    background-color:rgb(19, 52, 150);
}


</style>
