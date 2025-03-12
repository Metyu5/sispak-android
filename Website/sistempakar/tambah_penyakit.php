<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}
?>

<!-- Menyertakan header.php -->
<?php include 'header.php'; ?>

<!-- Menyertakan sidebar.php -->
<?php include 'sidebar.php'; ?>

<!-- Konten utama -->
<div class="main-content">
    <div class="container">
        <!-- Tombol Kembali ke Data Penyakit -->
        <a href="penyakit.php" class="btn-back-data">Kembali ke Data Penyakit</a>

        <h2>Tambah Data Penyakit Ikan Betta</h2>

        <div class="card animate__animated animate__fadeIn">
            <form action="update_penyakit.php" method="POST" class="form-tambahpenyakit">

                <div class="form-group">
                <label for="kode_penyakit">Kode Penyakit</label>
                <select id="kode_penyakit" name="kode_penyakit" class="form-control" required>
                    <option value="">Pilih Kode Penyakit</option> <!-- Opsi default -->
                    <option value="P001">P001</option>
                    <option value="P002">P002</option>
                    <option value="P003">P003</option>
                    <option value="P004">P004</option>
                    <option value="P005">P005</option>
                    <option value="P006">P006</option>
                    <option value="P007">P007</option>
        
                </select>
            </div>


                <div class="form-group">
                    <label for="nama_penyakit">Nama Penyakit</label>
                    <input type="text" id="nama_penyakit" name="nama_penyakit" class="form-control" required placeholder="Masukkan Nama Penyakit">
                </div>

                <div class="form-group">
                    <label for="gejala_penyakit">Gejala Penyakit</label>
                    <textarea id="gejala_penyakit" name="gejala_penyakit" class="form-control" required placeholder="Masukkan Gejala Penyakit"></textarea>
                </div>

                <div class="form-group">
                    <label for="cara_penanganan">Cara Penanganan</label>
                    <textarea id="cara_penanganan" name="cara_penanganan" class="form-control" required placeholder="Masukkan Cara Penanganan"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-tambah-penyakit">Tambah Penyakit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Menyertakan footer.php -->
<?php include 'footer.php'; ?>