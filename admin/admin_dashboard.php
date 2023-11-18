<?php

include __DIR__ . '/../koneksi.php';

session_start();

// Pastikan hanya admin yang dapat mengakses halaman ini
if ($_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Menghitung jumlah total warga
$queryTotalWarga = "SELECT COUNT(*) as total_warga FROM warga_terdaftar";
$resultTotalWarga = mysqli_query($koneksi, $queryTotalWarga);
$dataTotalWarga = mysqli_fetch_assoc($resultTotalWarga);
$totalWarga = $dataTotalWarga['total_warga'];

// Menghitung jumlah pengajuan belum diproses
$queryBelumDiproses = "SELECT COUNT(*) as belum_diproses FROM warga_pengajuan WHERE diproses = '0'";
$resultBelumDiproses = mysqli_query($koneksi, $queryBelumDiproses);
$dataBelumDiproses = mysqli_fetch_assoc($resultBelumDiproses);
$jumlahBelumDiproses = $dataBelumDiproses['belum_diproses'];

// Menghitung jumlah pengajuan sudah diproses
$querySudahDiproses = "SELECT COUNT(*) as sudah_diproses FROM warga_pengajuan WHERE diproses = '1'";
$resultSudahDiproses = mysqli_query($koneksi, $querySudahDiproses);
$dataSudahDiproses = mysqli_fetch_assoc($resultSudahDiproses);
$jumlahSudahDiproses = $dataSudahDiproses['sudah_diproses'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .sidebar {
            background-color: #ff77a9;
            width: 250px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px;
        }

        .menu-item a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .menu-item a:hover {
            text-decoration: underline;
        }

        .content {
            margin-left: 280px;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }
        /* Tambahkan style untuk link logout */
        .logout-link {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #fff;
            text-decoration: none;
        }

        .logout-link:hover {
            text-decoration: underline;
        }

        /* info box */

        .info-box-container {
            display: flex;
        }

        .info-box {
            flex: 1;
            background-color: #e86bd9;
            color: white;
            padding: 20px;
            margin-right: 20px;
            text-align: center;
            border-radius: 10px;
        }

        .info-box:nth-child(1) {
            background-color: #ffcc66; /* Warna untuk Info Box 1 */
            color: white;
        }

        .info-box:nth-child(2) {
            background-color: #66cc66; /* Warna untuk Info Box 2 */
            color: white;
        }

        .info-box:nth-child(3) {
            background-color: #3db0ef; /* Warna untuk Info Box 3 */
            color: white;
        }

        .info-box:last-child {
            margin-right: 0; /* Menghapus margin-right pada info-box terakhir */
        }

        .info-box h3 {
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .info-box p {
            font-weight: bold;
            font-size: 50px;
            margin: 0;
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="menu-item">
            <a href="./admin_dashboard.php">Dashboard Admin</a>
        </div>
        <div class="menu-item">
            <a href="./data_pengajuan.php">Cek Data Pengajuan</a>
        </div>
        <div class="menu-item">
            <a href="./data_terdaftar.php">Cek Data Warga</a>
        </div>
        <div class="menu-item">
            <a href="./data_user.php">Cek Data User</a>
        </div>

        <!-- Letakkan link logout di bagian bawah sidebar -->
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>
    <div class="content">
        <h2>Welcome, Admin <?php echo $_SESSION['username']; ?></h2>

        <!-- Info Box Container -->
        <div class="info-box-container">
            <!-- Info Box 1 -->
            <div class="info-box">
                <h3>BELUM DIPROSES</h3>
                <p><?php echo $jumlahBelumDiproses; ?></p>
            </div>
            
            <!-- Info Box 2 -->
            <div class="info-box">
                <h3>SUDAH DIPROSES</h3>
                <p><?php echo $jumlahSudahDiproses; ?></p>
            </div>
            
            <!-- Info Box 3 -->
            <div class="info-box">
                <h3>TOTAL WARGA</h3>
                <p><?php echo $totalWarga; ?></p>
            </div>
        </div>
        
    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
