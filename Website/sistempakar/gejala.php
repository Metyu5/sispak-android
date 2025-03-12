<?php
// Koneksi ke database
include 'koneksi.php';

// Query untuk mendapatkan data gejala
$sqlGejala = "SELECT * FROM gejala";
$resultGejala = $conn->query($sqlGejala);
?>

<!-- Menyertakan header.php -->
<?php include 'header.php'; ?>

<!-- Menyertakan sidebar.php -->
<?php include 'sidebar.php'; ?>

<!-- Menyertakan footer.php -->
<?php include 'footer.php'; ?>

<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="gejala-main-container">
    <div class="gejala-content-container">
        <!-- Tombol Kembali ke Dashboard -->
        <a href="dashboard.php" class="btn-back-gejala "> <i class="fas fa-arrow-left"></i>Kembali ke Dashboard</a>
        <h2 class="gejala-title">Daftar Gejala</h2>
        <table class="gejala-table">
            <thead>
                <tr>
                    <th>No</th> <!-- Menambahkan kolom No -->
                    <th>Kode Gejala</th>
                    <th>Nama Gejala</th>
                    <th>Nilai CF</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultGejala->num_rows > 0) : ?>
                    <?php $no = 1; // Menambahkan nomor urut ?>
                    <?php while($row = $resultGejala->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                            <td><?php echo htmlspecialchars($row['kode_gejala']); ?></td>
                            <td><?php echo htmlspecialchars($row['nama_gejala']); ?></td>
                            <td><?php echo htmlspecialchars($row['nilai_cf']); ?></td>
                            <td>
                                <div class='btn-actions'>
                                    <!-- Tombol Edit -->
                                    <a href='edit_gejala.php?id=<?php echo $row['id_gejala']; ?>' class='btn-edit'>
                                        <i class='fas fa-edit'></i> 
                                    </a>
                                    <!-- Tombol Hapus -->
                                    <a href="javascript:void(0);" class="btn-delete" onclick="hapusGejala(<?php echo $row['id_gejala']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5">Data gejala tidak ditemukan.</td> <!-- Kolom ditambah 1 untuk kolom No -->
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <!-- Tombol Tambah Gejala -->
        <a href="tambah_gejala.php" class="btn-tambah-gejala">Tambah Gejala</a>
    </div>
</div>

<!-- Script SweetAlert2 untuk konfirmasi hapus -->
<script>
function hapusGejala(idGejala) {
    // Menampilkan SweetAlert2 konfirmasi
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Gejala ini akan dihapus!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Mengarahkan ke halaman hapus_gejala.php dengan parameter ID gejala
            window.location.href = 'hapus_gejala.php?id=' + idGejala;
        }
    });
}
</script>

<!-- Script untuk menampilkan SweetAlert2 notifikasi -->
<script>
<?php
// Cek apakah ada parameter success atau error di URL
if (isset($_GET['success']) && $_GET['success'] == 3) {
    echo "
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: 'Gejala berhasil dihapus!',
        timer: 3000
    });
    ";
} elseif (isset($_GET['error']) && $_GET['error'] == 1) {
    echo "
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: 'Gagal menghapus gejala!',
        timer: 3000
    });
";
exit ();
}
?>
</script>
