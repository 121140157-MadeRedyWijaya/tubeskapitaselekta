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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        /* Header */
        header {
            width: 100%;
            height: 100px;
            color: #fff;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding:0 10px 0 10px;
        
        }

        header h2{
            color: #333;
            margin: 0;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        .nav-link {
            color: #333;
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            margin-left: 5px; 
        }

        .nav-link:hover {
            color: #045676;
        }

        .nav-link-left {
            float: left;
        }

        .nav-link-right {
            display: flex;
            align-items: center;
        }

        .nav-link-right a {
            margin-left: 20px; 
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            max-width: 50px;
            margin-right: 10px;
        }

        /* konten */
        .content {
            padding: 50px;
            text-align: center;
            background-color: #fff; /* Set background color */
            border-radius: 10px; /* Add some border-radius for a rounded appearance */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
            margin-top: 20px; /* Provide some space from the header */
        }

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


        @media only screen and (max-width: 600px) {
            header {
                flex-direction: column; /* Mengubah arah flex ke kolom pada layar kecil */
                align-items: center;
            }

            a{
            }
            
            .nav-link-right {
                margin-top: 10px; /* Menambahkan margin atas pada nav-link-right */
                font-size:12px;
            }

            .nav-link-right a {
                margin-left: 0px; 
                margin-right: 0px;
                padding-left: 8px;
                padding-right: 8px;
            }

            .nav-link {
                margin: 5px 0; /* Memberikan margin atas dan bawah pada nav-link */
            }

            .info-box h3 {
                font-size: 10px;
                margin-bottom: 10px;
            }
            
            .info-box p {
                font-weight: bold;
                font-size: 50px;
                margin: 0;
            }
            .nav-link-right a:last-child img {
                width: 25px; /* Sesuaikan dengan ukuran yang diinginkan */
            }
        }


        
    </style>

</head>
<body>
    <header>
    <div class="logo">
        <img src="../asset/logo.png" alt="Logo">
        <h2>Pendataan Desa Kali Sari</h2>
    </div>

    <div class="nav-link-right">
        <a href="admin_dashboard.php" class="nav-link nav-link-right">Dashboard</a>
        <a href="data_pengajuan.php" class="nav-link nav-link-right">Pengajuan</a>
        <a href="data_terdaftar.php" class="nav-link nav-link-right">Warga</a>
        <a href="data_user.php" class="nav-link nav-link-right">Akun</a>
        <a style="color: #0012b3; text-decoration: none; font-weight: bold;" href="#">Admin <?php echo $_SESSION['username']; ?></a>
        <a href="#" onclick="confirmLogout()" class="nav-link"><img src="../asset/i-logout.png" alt="Logout" width="50"></a>
    </div>

  
    </header>

 
    
    

    <div class="content">
        <h2>Informasi Pendataan Warga Desa</h2>
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

    <script>
        function confirmLogout() {
                var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
                if (confirmLogout) {
                    window.location.href = "../logout.php";
                }
        }
    </script>


</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
