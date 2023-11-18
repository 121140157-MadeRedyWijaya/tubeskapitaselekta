<?php
include __DIR__ . '/../koneksi.php';

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Mendapatkan data belum diproses dari database
$queryBelumDiproses = "SELECT tanggal_submit, nik, tanggal_lahir, nama FROM warga_pengajuan WHERE diproses = 0";
$resultBelumDiproses = mysqli_query($koneksi, $queryBelumDiproses);

// Mendapatkan data sudah diproses dari database
$querySudahDiproses = "SELECT tanggal_submit, nik, tanggal_lahir, nama FROM warga_pengajuan WHERE diproses = 1";
$resultSudahDiproses = mysqli_query($koneksi, $querySudahDiproses);


// Menghitung jumlah data belum diproses
$numRowsBelumDiproses = mysqli_num_rows($resultBelumDiproses);

// Menghitung jumlah data sudah diproses
$numRowsSudahDiproses = mysqli_num_rows($resultSudahDiproses);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Pengajuan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            margin-bottom: 20px;
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
        <h2>Data Belum Diproses</h2>
        <!-- Menampilkan informasi jumlah data belum diproses -->
        <p>Jumlah Data Belum Diproses: <?php echo $numRowsBelumDiproses; ?></p>
        <table border='1'>
            <tr>
                <th>Tanggal Pengajuan</th>
                <th>NIK</th>
                <th>Tanggal Lahir</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($resultBelumDiproses)) {
                echo "<tr>";
                echo "<td>" . $row['tanggal_submit'] . "</td>";
                echo "<td>" . $row['nik'] . "</td>";
                echo "<td>" . $row['tanggal_lahir'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td><a href='detail.php?nik=" . $row['nik'] . "'>Detail</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Data Sudah Diproses</h2>
        <!-- Menampilkan informasi jumlah data sudah diproses -->
        <p>Jumlah Data Sudah Diproses: <?php echo $numRowsSudahDiproses; ?></p>
        <table border='1'>
            <tr>
                <th>Tanggal Pengajuan</th>
                <th>NIK</th>
                <th>Tanggal Lahir</th>
                <th>Nama</th>
                <th>Action</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($resultSudahDiproses)) {
                echo "<tr>";
                echo "<td>" . $row['tanggal_submit'] . "</td>";
                echo "<td>" . $row['nik'] . "</td>";
                echo "<td>" . $row['tanggal_lahir'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td><a href='detail_diterima.php?nik=" . $row['nik'] . "'>Detail</a></td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>
</body>
</html>
