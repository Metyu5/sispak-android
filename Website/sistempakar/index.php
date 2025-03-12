<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi ke database dilakukan
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SPBettaFish</title>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Animate Style -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body class="animate__animated animate__fadeIn">
    <?php
    // Periksa apakah login berhasil
    if (isset($_GET['success']) && $_GET['success'] == 'login') {
        // Ambil nama pengguna dari database berdasarkan username
        $username = $_SESSION['username'];
        $sql = "SELECT nama FROM admin WHERE  username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Ambil nama pengguna dari hasil query
            $row = $result->fetch_assoc();
            $nama = $row['nama'];
        } else {
            $nama = "Pengguna Tidak Ditemukan"; // Jika nama tidak ditemukan
        }

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Login Berhasil',
                    text: 'Selamat datang, $nama!',
                    showConfirmButton: true,
                    confirmButtonText: 'Lanjutkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'dashboard.php'; // Redirect ke halaman dashboard
                    }
                });
            });
        </script>";
    }

    // Periksa apakah login gagal
    if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Gagal',
                    text: 'Username atau password anda tidak sesuai ups.',
                    showConfirmButton: true,
                    confirmButtonText: 'Coba Lagi'
                });
            });
        </script>";
    }
    ?>
    <div class="container">
      <!-- Bagian Kiri: Form Login -->
      <div class="login-container animate__animated animate__fadeInLeft">
        <div class="login-box">
          <h2 class="welcome animate__animated animate__fadeInDown">
            Selamat Datang
          </h2>
          <!-- Gambar Kecil di Atas Judul -->
          <img
            src="images/rb_7965.png"
            alt="Gambar Kecil"
            class="login-img animate__animated animate__fadeIn"
          />
          <h2 class="animate__animated animate__fadeIn">Sign Up</h2>
          <form action="login.php" method="post">
            <div class="textbox animate__animated animate__fadeIn">
              <label for="username">Username</label>
              <input
                type="text"
                placeholder="Masukan Username"
                name="username"
                required
              />
            </div>
            <div class="textbox animate__animated animate__fadeIn">
              <label for="Password">Password</label>
              <input
                type="password"
                placeholder="Masukan password"
                name="password"
                required
              />
            </div>
            <input
              type="submit"
              value="Login"
              class="btn animate__animated animate__fadeIn"
            />
          </form>
        </div>
      </div>

      <!-- Bagian Kanan: Konten (gambar dan teks) -->
      <div class="content-container animate__animated animate__fadeInRight">
        <h1 class="animate__animated animate__fadeInRight">
          Silahkan Login Untuk Mengoptimalkan!
        </h1>
        <p class="animate__animated animate__fadeInRight">
          Pengelolaan Pada Sistem Ini.
        </p>
        <img
          src="images/rb_7962.png"
          alt="Gambar Login"
          class="animate__animated animate__fadeIn"
        />
      </div>
    </div>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>
