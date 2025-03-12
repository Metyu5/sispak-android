<?php
// Koneksi ke database
include 'koneksi.php';

// Jika tombol submit ditekan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];
    $nilai_cf = $_POST['nilai_cf'];

    // Query untuk menyimpan data gejala baru ke database
    $sql = "INSERT INTO gejala (kode_gejala, nama_gejala, nilai_cf) 
            VALUES ('$kode_gejala', '$nama_gejala', '$nilai_cf')";

    if ($conn->query($sql) === TRUE) {
        // Redirect dengan query string success=1 setelah berhasil
        header("Location: tambah_gejala.php?success=1");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Menyertakan header.php -->
<?php include 'header.php'; ?>

<!-- Menyertakan sidebar.php -->
<?php include 'sidebar.php'; ?>

<!-- Konten utama -->
<div class="tia-gejala-main-container">
    <div class="tia-container">
        <!-- Tombol Kembali ke Daftar Gejala -->
        <a href="gejala.php" class="tia-btn-back-data">Kembali ke Daftar Gejala</a>

        <h2 class="tia-gejala-title">Tambah Gejala Baru</h2>

        <div class="tia-card animate__animated animate__fadeIn">
            <form action="tambah_gejala.php" method="POST" class="tia-form-tambahgejala">

                <div class="tia-form-group">
                    <label for="kode_gejala">Kode Gejala</label>
                    <input type="text" id="kode_gejala" name="kode_gejala" class="tia-form-control" required placeholder="Masukkan Kode Gejala">
                </div>

                <div class="tia-form-group">
                    <label for="nama_gejala">Nama Gejala</label>
                    <input type="text" id="nama_gejala" name="nama_gejala" class="tia-form-control" required placeholder="Masukkan Nama Gejala">
                </div>

                <div class="tia-form-group">
                    <label for="nilai_cf">Nilai CF</label>
                    <input type="number" id="nilai_cf" name="nilai_cf" class="tia-form-control" required step="0.01" min="0" max="1" placeholder="Masukkan Nilai CF">
                </div>

                <div class="tia-form-group">
                    <button type="submit" class="tia-btn-tambah-gejala">Tambah Gejala</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Menyertakan footer.php -->
<?php include 'footer.php'; ?>

<!-- Menyertakan SweetAlert JS dan CSS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- CSS untuk SweetAlert bisa diimport di <head> atau secara langsung dalam <script> -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Menampilkan SweetAlert ketika berhasil menambahkan data -->
<script>
    <?php 
    
    if (isset($_GET['success']) && $_GET['success'] == 1) { ?>
        Swal.fire({
            title: 'Sukses!',
            text: 'Gejala berhasil ditambahkan.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'gejala.php'; // Redirect ke halaman gejala.php setelah klik OK
        });
        
    <?php } ?>
</script>

<!-- CSS langsung di dalam file -->
<style>
/* Container untuk konten utama */
.tia-gejala-main-container {
    margin-left: 250px; /* Menghindari sidebar, pastikan lebar sidebar konsisten */
    width: calc(100% - 250px); /* Menghitung lebar konten dengan mengurangi lebar sidebar */
    padding: 20px;
    box-sizing: border-box;
}

/* Judul halaman */
.tia-gejala-title {
   margin-top:-20px;
    text-align: center;
    font-size: 24px;
    margin-bottom: 10px;
    color: #333;
}

/* Card untuk form */
.tia-card {
    background-color: white;
    padding: 40px 30px;
    border-radius: 10px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 900px; /* Membatasi lebar maksimal form */
    margin: 0 auto; /* Mengatur agar form berada di tengah */
}

/* Form Group */
.tia-form-group {
    margin-bottom: 20px;
}

/* Label untuk input */
.tia-form-group label {
    font-size: 16px;
    font-weight: bold;
    color: #333;
}

/* Input form */
.tia-form-control {
    width: 100%;
    padding: 12px;
    font-size: 16px;
    border-radius: 6px;
    border: 1px solid #ddd;
    box-sizing: border-box;
    margin-top: 8px;
}

.tia-form-control:focus {
    border-color: #4caf50;
    box-shadow: 0 0 6px rgba(76, 175, 80, 0.3);
    outline: none;
}

/* Tombol submit */
.tia-btn-tambah-gejala {
    border:none;
    display: inline-block;
    padding: 12px 20px;
    background-color: #4caf50; /* Warna hijau yang sama dengan gejala.php */
    color: white;
    font-size: 16px;
    font-weight: bold;
    border-radius: 5px;
     text-decoration: none;
    width: 100%;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
}
.tia-btn-tambah-gejala:hover {
    background-color:rgb(138, 206, 140);

}

/* Tombol Kembali */
.tia-btn-back-data {
    display: inline-block;
    margin-bottom: 20px;
    padding: 10px 10px;
    background-color: #4caf50;
    color: white;
    border-radius: 10px;
    font-size: 16px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    margin-left: 20px; /* Menambahkan jarak ke kiri untuk menghindari terlalu dekat dengan sidebar */
}

.tia-btn-back-data:hover {
    background-color:rgb(138, 206, 140); /* Warna abu-abu terang pada hover */
}

/* Posisi tombol kembali di atas form dan sedikit geser ke kanan */
.tia-btn-back-data {
    margin-bottom: 30px;
    margin-left: 30px;
    display: inline-block;
}

/* Animasi fadeIn */
@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}
</style>
