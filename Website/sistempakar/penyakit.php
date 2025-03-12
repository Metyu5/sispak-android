<?php
session_start();
// Pastikan user sudah login sebelum mengakses halaman ini
if (!isset($_SESSION['username'])) {     
    header("Location: login.php");     
    exit; 
}
?>

<!-- Menyertakan header.php -->
<?php include 'header.php'; ?>

<!-- Menyertakan sidebar.php -->
<?php include 'sidebar.php'; ?>
<!-- Menyertakan footer.php -->
<?php include 'footer.php'; ?>

<!-- Konten utama -->
<div class="main-content">
    <div class="container">
        <!-- Tombol Kembali ke Dashboard -->
        <a href="dashboard.php" class="btn-back"> <i class="fas fa-arrow-left"></i>Kembali ke Dashboard</a>

        <h2>Data Penyakit Ikan Betta</h2>

        <!-- Kartu untuk Tabel Penyakit -->
        <div class="card animate__animated animate__fadeIn">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Penyakit</th>
                        <th>Nama Penyakit</th>
                        <th>Gejala Penyakit</th>
                        <th>Cara Penanganan</th>
                        <th>Aksi</th> <!-- Kolom Aksi -->
                    </tr>
                </thead>
                <tbody>
                <?php
                include 'koneksi.php'; // Pastikan file koneksi disertakan

                $sql = "SELECT * FROM penyakit"; // Query untuk mengambil data penyakit
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $no = 1; // Menambahkan nomor urut
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$no}</td>                            
                            <td>{$row['kode_penyakit']}</td>
                            <td>{$row['nama_penyakit']}</td>
                            <td>{$row['gejala']}</td>
                            <td>{$row['penanganan']}</td>
                            <td>
                                <div class='btn-actions'>
                                    <a href='edit_penyakit.php?id={$row['kode_penyakit']}' class='btn-edit'><i class='fas fa-edit'></i></a>
                                    <a href='hapus_penyakit.php' class='btn-delete' data-id='{$row['kode_penyakit']}' onclick='confirmDelete(event)'><i class='fas fa-trash'></i></a>
                                </div>
                            </td>
                        </tr>";
                         $no++; // Increment nomor urut
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data penyakit tersedia.</td></tr>";
                }
                ?>
            </tbody>
            </table>
        </div>

        <!-- Tombol Tambah Penyakit di bawah tabel -->
        <a href="tambah_penyakit.php" class="btn-tambah">Tambah Penyakit</a>
    </div>
</div>

<?php
// Jika ada parameter success=1, tampilkan SweetAlert
if (isset($_GET['success']) && $_GET['success'] == 1) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: 'Data penyakit berhasil ditambahkan.',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'penyakit.php'; // Redirect setelah menutup SweetAlert
        });
    </script>";
    exit(); 
}

// Jika ada parameter success=2, tampilkan SweetAlert (untuk data berhasil diupdate)
if (isset($_GET['success']) && $_GET['success'] == 2) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: 'Data penyakit berhasil diperbarui.',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'penyakit.php'; // Redirect setelah menutup SweetAlert
        });
    </script>";
    exit();
}

//  parameter success=3, tampilkan SweetAlert (untuk data berhasil dihapus)
if (isset($_GET['success']) && $_GET['success'] == 3) {
    echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Sukses!',
            text: 'Data penyakit berhasil dihapus.',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location = 'penyakit.php'; // Redirect setelah menutup SweetAlert
        });
    </script>";
    exit();
}
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function confirmDelete(event) {
        event.preventDefault(); // Mencegah aksi default (redirect)

        // Ambil nilai data-id dari tombol yang diklik
        const id = event.target.closest('a').getAttribute('data-id'); // Ambil id dari data-id

        // Tampilkan konfirmasi dengan SweetAlert2
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data penyakit ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                // Jika pengguna mengkonfirmasi penghapusan, alihkan ke halaman hapus_penyakit.php
                window.location.href = `hapus_penyakit.php?id=${id}`;
            }
        });
    }
</script>


