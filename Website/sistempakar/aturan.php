<?php
include('koneksi.php'); // Koneksi ke database
include('header.php');   // Header yang berisi navigasi dan elemen umum
include('sidebar.php');  // Sidebar untuk navigasi

// Query untuk mengambil data penyakit beserta gejalanya menggunakan JOIN
$sql = "
    SELECT p.kode_penyakit, p.nama_penyakit, g.nama_gejala
    FROM penyakit p
    JOIN rule r ON p.id_penyakit = r.id_penyakit
    JOIN gejala g ON g.id_gejala = r.id_gejala
";
$result = $conn->query($sql);

// Menyimpan data penyakit dan gejala terkait
$penyakit_data = [];
while ($row = $result->fetch_assoc()) {
    $kode_penyakit = $row['kode_penyakit'];
    $nama_penyakit = $row['nama_penyakit'];
    $nama_gejala = $row['nama_gejala'];

    // Cek apakah penyakit sudah ada dalam array $penyakit_data
    if (!isset($penyakit_data[$kode_penyakit])) {
        $penyakit_data[$kode_penyakit] = [
            'kode_penyakit' => $kode_penyakit,
            'nama_penyakit' => $nama_penyakit,
            'gejala' => []
        ];
    }

    // Tambahkan gejala ke dalam array gejala untuk penyakit yang sesuai
    $penyakit_data[$kode_penyakit]['gejala'][] = $nama_gejala;
}

// Menyusun data untuk chart
$chart_data = [];
foreach ($penyakit_data as $penyakit) {
    $chart_data[] = [
        'label' => $penyakit['nama_penyakit'],
        'jumlah_gejala' => count($penyakit['gejala']),
        'gejala' => $penyakit['gejala']
    ];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relasi Penyakit dan Gejala Ikan Betta</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .content {
            margin-left: 300px;
            width: calc(100% - 260px);
            padding: 20px;
        }

        .container {
            max-width: 900px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
        }

        h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #3a6ea5;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th, table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table th {
            text-align: center;
            font-weight: 700;
            background-color: #45a049;
        }

        canvas {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        #gejalaInfo {
            margin-top: 30px;
            padding: 20px;
            background-color: #fafafa;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: left;
            display: inline-block;
            width: 100%;
            max-width: 400px;
        }

        #gejalaInfo h3 {
            font-size: 1.5rem;
            color: #3a6ea5;
            margin-bottom: 10px;
        }

        #gejalaText {
            font-size: 1rem;
            color: #666;
        }
    </style>
</head>
<body>

    <div class="content">
        <div class="container">
            <h1>Relasi Penyakit dan Gejala Betta Fish</h1>
            
            <!-- Tabel Penyakit dan Gejala -->
            <table>
                <thead>
                    <tr>
                        <th>No</th> <!-- Menambahkan kolom No -->
                        <th>Kode Penyakit</th>
                        <th>THEN</th>
                        <th>IF</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; // Menambahkan nomor urut ?>
                    <?php foreach ($penyakit_data as $penyakit): ?>
                        <tr>
                            <td><?php echo $no++; ?></td> <!-- Menampilkan nomor urut -->
                            <td><?php echo $penyakit['kode_penyakit']; ?></td>
                            <td><?php echo $penyakit['nama_penyakit']; ?></td>
                            <td><?php echo implode(', ', $penyakit['gejala']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Grafik Polar Area -->
            <canvas id="bettaChart" width="350" height="300"></canvas>

            <!-- Info Gejala -->
            <div id="gejalaInfo">
                <h3>Gejala Penyakit:</h3>
                <p id="gejalaText">Pilih potongan grafik untuk melihat gejala terkait.</p>
            </div>
            
            <!-- Tombol Reset -->
            <button onclick="resetChart()">Reset</button>
        </div>
    </div>

<script>
    // Data penyakit dan gejala terkait yang diambil dari PHP
    const gejala = <?php echo json_encode($chart_data); ?>;
    const data = {
        labels: <?php echo json_encode(array_column($chart_data, 'label')); ?>,
        datasets: [{
            label: 'Jumlah Gejala Terkait',
            data: <?php echo json_encode(array_column($chart_data, 'jumlah_gejala')); ?>,
            backgroundColor: generateUniqueColors(gejala.length), // Menghasilkan warna unik
            borderColor: generateBorderColors(gejala.length),
            borderWidth: 1
        }]
    };

    // Fungsi untuk menghasilkan warna latar belakang unik secara dinamis
    function generateUniqueColors(count) {
        const pastelColors = [
            'rgba(255, 182, 193, 0.6)', 'rgba(255, 228, 196, 0.6)', 'rgba(173, 216, 230, 0.6)', 
            'rgba(144, 238, 144, 0.6)', 'rgba(255, 255, 224, 0.6)', 'rgba(255, 218, 185, 0.6)', 
            'rgba(240, 128, 128, 0.6)', 'rgba(186, 85, 211, 0.6)', 'rgba(221, 160, 221, 0.6)', 
            'rgba(152, 251, 152, 0.6)', 'rgba(255, 99, 71, 0.6)', 'rgba(255, 140, 0, 0.6)', 
            'rgba(100, 149, 237, 0.6)', 'rgba(238, 130, 238, 0.6)', 'rgba(255, 105, 180, 0.6)'
        ];
        
        const uniqueColors = [];
        for (let i = 0; i < count; i++) {
            uniqueColors.push(pastelColors[i % pastelColors.length]);
        }

        return uniqueColors;
    }

    // Fungsi untuk menghasilkan warna border secara dinamis
    function generateBorderColors(count) {
        const borderColors = [];
        const brightBorderColors = [
            'rgba(255, 105, 180, 1)', 'rgba(255, 140, 0, 1)', 'rgba(100, 149, 237, 1)', 
            'rgba(255, 99, 71, 1)', 'rgba(255, 165, 0, 1)', 'rgba(0, 191, 255, 1)', 
            'rgba(255, 215, 0, 1)', 'rgba(34, 193, 195, 1)', 'rgba(255, 99, 132, 1)', 
            'rgba(255, 69, 0, 1)', 'rgba(102, 205, 170, 1)', 'rgba(218, 112, 214, 1)', 
            'rgba(255, 222, 173, 1)', 'rgba(240, 128, 128, 1)', 'rgba(0, 255, 255, 1)'
        ];

        for (let i = 0; i < count; i++) {
            borderColors.push(brightBorderColors[i % brightBorderColors.length]);
        }

        return borderColors;
    }

    // Konfigurasi chart
    const config = {
        type: 'polarArea',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        title: function(tooltipItem) {
                            const penyakit = tooltipItem[0].label;
                            return penyakit;
                        },
                        afterLabel: function(tooltipItem) {
                            const penyakitName = tooltipItem.label;
                            const gejalaList = gejala.find(item => item.label === penyakitName).gejala;
                            return `Gejala Terkait: \n- ${gejalaList.join("\n- ")}`;
                        }
                    }
                }
            }
        }
    };

    // Membuat chart
    const ctx = document.getElementById('bettaChart').getContext('2d');
    const bettaChart = new Chart(ctx, config);

    // Event listener untuk menampilkan gejala ketika pengguna mengklik potongan
    const chartContainer = document.getElementById('bettaChart');
    chartContainer.addEventListener('click', (event) => {
        const activePoints = bettaChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, false);
        if (activePoints.length > 0) {
            const clickedIndex = activePoints[0].index;
            const penyakitName = data.labels[clickedIndex];
            const gejalaList = gejala.find(item => item.label === penyakitName).gejala;
            const gejalaText = gejalaList.join('<br>');
            document.getElementById('gejalaText').innerHTML = `Gejala untuk ${penyakitName}: <br>${gejalaText}`;
        }
    });

    // Fungsi reset chart (jika diperlukan)
    function resetChart() {
        document.getElementById('gejalaText').innerHTML = 'Pilih potongan grafik untuk melihat gejala terkait.';
    }
</script>

<?php include('footer.php'); ?>
</body>
</html>