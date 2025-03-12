<?php
// Koneksi ke database
include 'koneksi.php';

// Jika tombol submit ditekan
if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query untuk memasukkan data pengguna baru
    $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";

    if (mysqli_query($conn, $query)) {
        // Jika berhasil, arahkan ke halaman tambah_pengguna.php dengan pesan sukses
        header("Location: pengguna.php?status=add_success");
        exit();
    } else {
        // Jika ada kesalahan, tampilkan pesan error
        $error_message = mysqli_error($conn);
    }
}

?>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<style>
/* Styling form akan sama dengan sebelumnya */
.tambah-pengguna-container {
  position: absolute;
  top: 50%;
  left: 60%;
  transform: translate(-50%, -50%);
  width: 70%;
  padding: 30px;
  background-color: white;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  z-index: 1;
}

.tambah-pengguna-title {
  text-align: center;
  font-size: 24px;
  margin-bottom: 5px;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-group label {
  font-size: 16px;
  color: #555;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 5px;
  font-size: 16px;
}

.form-group input:focus {
  border-color: #4caf50;
  outline: none;
}

.btn-submit {
  display: block;
  width: 100%;
  padding: 10px 20px;
  background-color: #4caf50;
  color: white;
  font-size: 16px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  margin-top: 20px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-submit:hover {
  background-color: #45a049;
}

/* Style untuk pesan error */
.error-message {
  color: red;
  font-size: 14px;
  margin-top: 10px;
}

.thick{
    height: 1px;
    background-color:rgb(0, 0, 0);
    border: none;
}
</style>

<div class="tambah-pengguna-container">
  <!-- Tombol Kembali ke Daftar Aturan -->
        <a href="pengguna.php" class="moms-btn-aturan-back"> <i class="fas fa-arrow-left"></i>Kembali ke Data Pengguna</a>
  <h2 class="tambah-pengguna-title">Tambah Pengguna Baru</h2>
  <hr class="thick">

  <!-- Formulir tambah pengguna -->
  <form action="tambah_pengguna.php" method="post">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required placeholder="Masukkan Username">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" required placeholder="Masukkan Email">
    </div>

    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required placeholder="Masukkan Password">
    </div>

    <!-- Jika ada error, tampilkan pesan error -->
    <?php if (isset($error_message)): ?>
      <div class="error-message">
        Error: <?= $error_message ?>
      </div>
    <?php endif; ?>

    <button type="submit" name="submit" class="btn-submit">Tambah Pengguna</button>
  </form>
</div>

<?php include 'footer.php'; ?>
