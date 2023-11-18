<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Mengambil data dari database
$query = "SELECT * FROM warga_pengajuan WHERE username = ?";
$stmt = mysqli_prepare($koneksi, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Table</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: lightgray;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }
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

        /* Tambahkan style untuk status */
        .status-sedang-diproses {
            color: white;
            background-color: #ff6666; /* Merah */
        }

        .status-sudah-diproses {
            color: white;
            background-color: #66cc66; /* Hijau */
        }

    </style>
</head>
<body>
    <div class="sidebar">
        <div class="menu-item">
            <a href="./user_dashboard.php">Dashboard Pengguna</a>
        </div>
        <div class="menu-item">
            <a href="./data_form.php">Formulir Permohonan Pendataan</a>
        </div>
        <div class="menu-item">
            <a href="./application_table.php">Tabel Permohonan</a>
        </div>
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>



    <div class="content">
        <h2>Tabel Data Pengajuan</h2>

        <?php
        if (mysqli_num_rows($result) > 0) {
            // Tampilkan tabel jika ada data
            ?>
            <table>
                <tr>
                    <th>Waktu pengajuan</th>
                    <th>NIK</th>
                    <th>Tanggal Lahir</th>
                    <th>Nama</th>
                    <th>Agama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Status</th> <!-- Kolom status ditambahkan -->
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // Tentukan class status berdasarkan nilai diproses
                    $statusClass = $row['diproses'] == 1 ? 'status-sudah-diproses' : 'status-sedang-diproses';

                    echo "<tr>";
                    echo "<td>" . $row['tanggal_submit'] . "</td>";
                    echo "<td>" . $row['nik'] . "</td>";
                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['agama'] . "</td>";
                    echo "<td>" . $row['jenis_kelamin'] . "</td>";
                    echo "<td>" . $row['alamat'] . "</td>";
                    echo "<td class='{$statusClass}'>" . ($row['diproses'] == 1 ? 'Sudah diproses' : 'Sedang diproses') . "</td>";
                    echo "</tr>";
                }
                ?>
            </table>
            <?php
        } else {
            // Tampilkan pesan jika tabel kosong
            echo "<p>Data pengajuan kosong.</p>";
        }
        ?>
    </div>

</body>
</html>
