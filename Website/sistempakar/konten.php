<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'koneksi.php'; 
$sqlPenyakit = "SELECT COUNT(*) as total_penyakit FROM penyakit";
$resultPenyakit = $conn->query($sqlPenyakit);
if ($resultPenyakit) {
    $row = $resultPenyakit->fetch_assoc();
    $totalPenyakit = $row['total_penyakit']; 
} else {
    echo "Error: " . $conn->error;
    $totalPenyakit = 0;
}
$sqlGejala = "SELECT COUNT(*) as total_gejala FROM gejala";
$resultGejala = $conn->query($sqlGejala);
if ($resultGejala) {
    $row = $resultGejala->fetch_assoc();
    $totalGejala = $row['total_gejala']; 
} else {
    
    echo "Error: " . $conn->error;
    $totalGejala = 0;
}
$sqlKonsultasi = "SELECT COUNT(*) as total_konsultasi FROM hasil_konsultasi";
$resultKonsultasi = $conn->query($sqlKonsultasi);
if ($resultKonsultasi) {
    $row = $resultKonsultasi->fetch_assoc();
    $totalkonsultasi = $row['total_konsultasi']; 
} else {
    echo "Error: " . $conn->error;
    $totalkonsultasi = 0;
}
$sqlRule = "SELECT COUNT(*) as total_rule FROM rule";
$resultRule = $conn->query($sqlRule);
if ($resultRule) {
    $row = $resultRule->fetch_assoc();
    $totalRule = $row['total_rule']; 
} else {
    echo "Error: " . $conn->error;
    $totalRule = 0;
}
$sqlPengguna = "SELECT COUNT(*) as total_pengguna FROM users";
$resultPengguna = $conn->query($sqlPengguna);
if ($resultPengguna) {
    $row = $resultPengguna->fetch_assoc();
    $totalPengguna = $row['total_pengguna']; 
} else {
    echo "Error: " . $conn->error;
    $totalPengguna = 0;
}
?>
<!-- konten.php -->
<div class="main-content animate__animated animate__fadeInDown">
    <div class="admin-header">
        <h3>Hello <?php echo $nama; ?>, Welcome to Dashboard</h3>
        <div class="admin-info">
            <img src="images/narkoboy.png" alt="admin icon" class="admin-icon">
            <span class="admin-name"><?php echo $nama; ?></span>
        </div>
    </div>

    <div class="wildcard-container animate__animated animate__fadeInUpBig">
        <!-- Wildcard pertama -->
        <div class="info-card">
            <img src="images/protection.png" alt="Icon Total" class="info-img">
            <div class="info-details">
                <div class="info-tex-area">
                    <p class="info-title">Total</p>
                    <p class="info-subtitle">Penyakit</p>
                </div>
                <p class="info-number"><?php echo $totalPenyakit; ?></p> 
            </div>
        </div>
        <!-- Wildcard kedua -->
        <div class="info-card">
            <img src="images/operational.png" alt="Icon Total" class="info-img">
            <div class="info-details">
                <div class="info-text-column">
                    <p class="info-title">Total</p>
                    <p class="info-subtitle">Gejala</p>
                </div>
                <p class="info-number"><?php echo $totalGejala; ?></p> 
            </div>
        </div>
        <!-- Wildcard ketiga -->
        <div class="info-card">
            <img src="images/test.png" alt="Icon Total" class="info-img">
            <div class="info-details">
                <div class="info-text-column">
                    <p class="info-title">Total</p>
                    <p class="info-subtitle">Rule</p>
                </div>
                <p class="info-number"><?php echo $totalPenyakit; ?></p> 
            </div>
        </div>
        <!-- Wildcard keempat -->
        <div class="info-card">
            <img src="images/usersss.png" alt="Icon Total" class="info-img">
            <div class="info-details">
                <div class="info-text-column">
                    <p class="info-title">Total</p>
                    <p class="info-subtitle">Pengguna</p>
                </div>
                <p class="info-number"><?php echo $totalPengguna; ?></p> 
            </div>
        </div>
        <!-- Wildcard kelima -->
        <div class="info-card">
            <img src="images/agen.png" alt="Icon Total" class="info-img">
            <div class="info-details">
                <div class="info-text-column">
                    <p class="info-title">Total</p>
                    <p class="info-subtitle">Konsultasi</p>
                </div>
                <p class="info-number"><?php echo $totalkonsultasi; ?></p>  
        </div>
    </div>
</div>

