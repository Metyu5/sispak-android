<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>
<?php include 'footer.php'; ?>

<?php
// Menyertakan koneksi ke database
include 'koneksi.php';

// Query untuk mengambil data hasil konsultasi
$sql = "SELECT * FROM hasil_konsultasi ORDER BY tanggal_diagnosa DESC"; // Ganti nama tabel dan kolom sesuai struktur database Anda
$result = $conn->query($sql);
?>

<div class="konsultasi">
    <div class="konsultasi-container">
        <h2>Hasil Konsultasi</h2>

        <!-- Tombol Download -->
        <div class="download-buttons">
            <button id="downloadPDF" class="btn-download">Download PDF</button>
            <button id="downloadExcel" class="btn-download">Download Excel</button>
            <button id="printTable" class="btn-download">Print</button>
        </div>

        <!-- Tabel Hasil Diagnosa -->
        <div class="table-container">
            <table class="konsultasi-table" id="konsultasiTable">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Pengguna</th>
                        <th>Diagnosa Penyakit</th>
                        <th>Gejala Kategori</th>
                        <th>Hasil Diagnosa</th>
                        <th>Tanggal Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1; // Menambahkan nomor urut
                        while($row = $result->fetch_assoc()) {
                            // Ambil data dari kolom
                            $nama_pengguna = $row['nama_pengguna'];
                            $nama_penyakit = $row['nama_penyakit'];
                            $gejala_kategori = $row['gejala_kategori'];
                            $hasil_diagnosa = $row['hasil_diagnosa'];
                            $tanggal_diagnosa = $row['tanggal_diagnosa'];
                    ?>
                    <tr>
                        <th><?php echo $no++; ?></th>
                        <td><?php echo $nama_pengguna; ?></td>
                        <td><?php echo $nama_penyakit; ?></td>
                        <td><?php echo $gejala_kategori; ?></td>
                        <td><?php echo $hasil_diagnosa; ?></td>
                        <td><?php echo $tanggal_diagnosa; ?></td>
                    </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>Tidak ada data hasil konsultasi.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .konsultasi {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 20px;
        width: 100%;
        box-sizing: border-box;
    }

    .konsultasi-container {
        width: 80%; /* Menyesuaikan lebar container untuk memberi ruang di kiri dan kanan */
        padding: 20px;
        margin-left: 300px;
        box-sizing: border-box;
        overflow-x: auto; /* Mengatasi tabel yang bisa digeser secara horizontal */
    }

    .download-buttons {
        margin-bottom: 20px;
        text-align: center;
    }

    .btn-download {
        background-color: #4CAF50;
        color: white;
        padding: 10px 20px;
        margin-right: 10px;
        border: none;
        cursor: pointer;
        font-size: 16px;
        border-radius: 5px;
        display: inline-block;
    }

    .btn-download:hover {
        background-color: #45a049;
    }

    .table-container {
        width: 100%;
        overflow-x: auto; /* Membuat tabel bisa scroll jika kontennya melebar */
    }

    .konsultasi-table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .konsultasi-table th, .konsultasi-table td {
        padding: 12px 15px;
        text-align: center;
        border: 1px solid #ddd;
        font-size: 14px;
        word-wrap: break-word;
    }

    .konsultasi-table th {
        background-color: #4CAF50;
        color: white;
        font-size: 16px;
        font-weight: 600;
    }

    .konsultasi-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .konsultasi-table tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .konsultasi-table tr:hover {

        background-color: #80e0f0;
        box-shadow: 0px 4px 10px rgba(0, 128, 255, 0.2);
    }


     @media print {
            footer {
                display: none !important; /* Menyembunyikan footer dengan cara paksa */
            }

            header {
                display: block !important; /* Menjaga agar header tetap tampil */
            }

            body * {
                visibility: hidden; /* Menyembunyikan semua elemen dalam body */
            }

            header, .konsultasi-container, .download-buttons, .table-container {
                visibility: visible; /* Menampilkan header dan elemen-elemen yang perlu dicetak */
            }

            .konsultasi-table {
                border: 1px solid black; /* Mengatur border agar tabel terlihat jelas */
            }
        }

</style>

<!-- Library JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.18/jspdf.plugin.autotable.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.1/xlsx.full.min.js"></script>

<script>
    // Fungsi untuk Download PDF
    document.getElementById("downloadPDF").addEventListener("click", function () {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Menambahkan tabel ke dokumen PDF
        doc.autoTable({ html: '#konsultasiTable' });

        // Menyimpan file PDF
        doc.save('hasil_konsultasi.pdf');
    });

    // Fungsi untuk Download Excel
   document.getElementById("downloadExcel").addEventListener("click", function () {
    const table = document.getElementById('konsultasiTable');
    const wb = XLSX.utils.table_to_book(table, { sheet: "Sheet 1" });

    // Menyesuaikan lebar kolom agar tidak terpotong
    wb.Sheets["Sheet 1"]["!cols"] = [
        { width: 10 }, // Menyesuaikan lebar kolom "No"
        { width: 20 }, // Menyesuaikan lebar kolom "Pengguna"
        { width: 30 }, // Menyesuaikan lebar kolom "Diagnosa Penyakit"
        { width: 230 }, // Menyesuaikan lebar kolom "Gejala Kategori"
        { width: 30 }, // Menyesuaikan lebar kolom "Hasil Diagnosa"
        { width: 15 }, // Menyesuaikan lebar kolom "Tanggal Diagnosa"
    ];

    const ws = wb.Sheets["Sheet 1"];

    // Styling header Excel dengan warna latar belakang dan teks
    const headerRange = "A1:F1";  // Rentang header
    for (let i = 0; i < 6; i++) {
        const cell = ws[XLSX.utils.encode_cell({ r: 0, c: i })];
        if (cell) {
            cell.s = {
                fill: {
                    fgColor: { rgb: "4CAF50" } // Hijau untuk latar belakang header
                },
                font: {
                    color: { rgb: "FFFFFF" }, // Putih untuk teks header
                    bold: true
                },
                border: {
                    top: { style: "thin", color: { rgb: "000000" } },
                    bottom: { style: "thin", color: { rgb: "000000" } },
                    left: { style: "thin", color: { rgb: "000000" } },
                    right: { style: "thin", color: { rgb: "000000" } }
                }
            };
        }
    }
    const range = ws['!rows'] || [];
    const rowCount = range.length;
    for (let r = 1; r < rowCount; r++) {
        for (let c = 0; c < 6; c++) {
            const cell = ws[XLSX.utils.encode_cell({ r: r, c: c })];
            if (cell) {
                let rowColor = (r % 2 === 0) ? "#f9f9f9" : "#ffffff"; 
                cell.s = {
                    fill: {
                        fgColor: { rgb: rowColor.replace("#", "") } 
                    },
                    border: {
                        top: { style: "thin", color: { rgb: "000000" } },
                        bottom: { style: "thin", color: { rgb: "000000" } },
                        left: { style: "thin", color: { rgb: "000000" } },
                        right: { style: "thin", color: { rgb: "000000" } }
                    }
                };
            }
        }
    }

    // Menyimpan file Excel
    XLSX.writeFile(wb, 'hasil_konsultasi.xlsx');
});


document.getElementById("printTable").addEventListener("click", function () {
    const originalTitle = document.title; // Simpan judul asli
    document.title = "Hasil Konsultasi"; // Ganti judul menjadi "Hasil Konsultasi"
    
    const printContents = document.getElementById('konsultasiTable').outerHTML;
    const originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    
    document.body.innerHTML = originalContents; // Kembalikan konten asli halaman
    document.title = originalTitle; // Pulihkan judul asli
});

</script>
