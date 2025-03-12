<?php
// Koneksi ke database
include 'koneksi.php';
?>

<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<style>
.pengguna-main-container {
  position: relative; /* Ubah dari absolute menjadi relative */
  margin: auto;
  left: 10%;
  width: 70%;
  padding: 30px;
  background-color: white;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
  border-radius: 10px;
  z-index: 1;
}

.pengguna-title {
  text-align: center;
  font-size: 24px;
  margin-bottom: 5px;
  color: #333;
}

.pengguna-table-wrapper {
  width: 100%;
  max-height: 400px; /* Sesuaikan dengan tinggi yang diinginkan */
  overflow-y: auto; /* Menambahkan scroll vertikal */
  margin-top: 20px;
}

.pengguna-table {
  width: 100%;
  border-collapse: collapse;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.pengguna-table th, .pengguna-table td {
  padding: 15px;
  text-align: center;
  border: 1px solid #ddd;
  font-size: 16px;
}

.pengguna-table th {
  background-color: #4caf50;
  color: white;
}

.pengguna-table tr:nth-child(even) td {
  background-color: #f9f9f9;
}

.pengguna-table tr:hover td {
  background-color: #eef7ee;
}

/* Tombol "Tambah Pengguna" di bawah tabel, sebelah kiri */
.btn-pengguna-add {
  display: block;
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  font-size: 16px;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  margin-top: 20px;
  transition: background-color 0.3s ease, transform 0.3s ease;
  float: left;
  margin-bottom: 20px; /* Menambahkan jarak antara tombol dan tabel */
}

/* Tombol hover */
.btn-pengguna-add:hover {
  background-color: #0056b3;
  transform: scale(1.05);
}

.thick {
  height: 1px;
  background-color: rgb(0, 0, 0);
  border: none;
}
</style>

<div class="pengguna-main-container">
  <h2 class="pengguna-title">Daftar Pengguna</h2>
  <hr class="thick">
  
  <!-- Wrapper untuk tabel dengan scroll -->
  <div class="pengguna-table-wrapper">
    <table class="pengguna-table">
     <thead>
    <tr>
        <th>No</th> <!-- Kolom No -->
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Aksi</th>
    </tr>
</thead>
<tbody>
    <?php
    // Menambahkan nomor urut
    $no = 1; // Variabel nomor urut
    // Query untuk mengambil data pengguna dari database
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    // Loop untuk menampilkan data pengguna
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>"; // Menampilkan nomor urut
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['password']) . "</td>"; // Menampilkan password asli dari database
            echo "<td>
                    <div class='btn-aturan-actions'>
                        <!-- Ikon Edit -->
                        <a href='edit_pengguna.php?id=" . $row['id_user'] . "' class='btn-aturan-edit'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <!-- Ikon Hapus -->
                        <a href='#' class='btn-aturan-delete' data-id='" . $row['id_user'] . "'>
                            <i class='fas fa-trash'></i>
                        </a>
                    </div>
                  </td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada data pengguna.</td></tr>";
    }
    ?>
</tbody>

    </table>
  </div>

  <!-- Tombol Tambah Pengguna -->
  <a href="tambah_pengguna.php" class="btn-pengguna-add">Tambah Pengguna</a>
</div>

<!-- Menyertakan SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Menangani klik pada tombol hapus
    document.querySelectorAll('.btn-aturan-delete').forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah default action (yaitu pengalihan halaman)

            const userId = this.getAttribute('data-id'); // Mendapatkan ID pengguna yang akan dihapus

            // Menampilkan konfirmasi SweetAlert sebelum menghapus data
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data pengguna ini akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika di konfirmasi, arahkan ke halaman hapus_pengguna.php dengan ID pengguna
                    window.location.href = 'hapus_pengguna.php?id=' + userId;
                }
            });
        });
    });

    // Cek status penghapusan atau penambahan dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    if (status === 'success') {
        // Jika status penghapusan berhasil, tampilkan notifikasi sukses
        Swal.fire({
            title: 'Sukses!',
            text: 'Data pengguna berhasil dihapus.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (status === 'add_success') {
        // Jika status penambahan berhasil, tampilkan notifikasi sukses
        Swal.fire({
            title: 'Sukses!',
            text: 'Pengguna baru berhasil ditambahkan.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } 
else if (status === 'edit_success') {
        // Jika status penambahan berhasil, tampilkan notifikasi sukses
        Swal.fire({
            title: 'Sukses!',
            text: 'Data pengguna berhasil diperbarui.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } 
    else if (status === 'error') {
        // Jika ada error, tampilkan pesan error
        const errorMessage = urlParams.get('error_message');
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan: ' + errorMessage,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
</script>

<?php include 'footer.php'; ?>
