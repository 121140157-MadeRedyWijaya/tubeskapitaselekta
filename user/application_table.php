<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Mengambil data dari database

$query = "SELECT * FROM warga_pengajuan WHERE username = ? ORDER BY tanggal_submit DESC";
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
            color:#045676;
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
            background-color: #fff; 
            border-radius: 10px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); 
            margin-top: 20px; 
        }

        h2 {
            text-align: center;
            color: #333;
            margin: 0;
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
            text-align: center;
            color: #FFFF;
            background-color: #3081D0;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
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

        .detail-link {
            background-color: #3498db;
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
        }

        .detail-link:hover {
            background-color: #2980b9;
        }

         /* Tambahkan style untuk tombol batal */
        /* Tambahkan style untuk tombol detail dan batal */
   

        .detail-link,
        .batal-link {
            flex: 1;
            margin-right: 5px;
            max-width: 50px; 
        }

        .batal-link {
            background-color: #e74c3c; /* Merah */
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            border-radius: 4px;
        }

        .batal-link:hover {
            background-color: #c0392b; /* Merah tua saat dihover */
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
            <a href="user_dashboard.php" class="nav-link nav-link-right">Dashboard</a>
            <a href="data_form.php" class="nav-link nav-link-right">Formulir</a>
            <a href="application_table.php" class="nav-link nav-link-right">Pengajuan</a>
            <a style="color: #0012b3; text-decoration: none; font-weight: bold;" href="#"><?php echo $_SESSION['username']; ?></a>
            <a href="#" onclick="confirmLogout()" class="nav-link"><img src="../asset/i-logout.png" alt="Logout" width="50"></a>
        </div>
    </header>



    <div class="content">
        <h2>Tabel Data Pengajuan</h2>
        <?php
        if (mysqli_num_rows($result) > 0) {
            // Tampilkan tabel jika ada data
            ?>
            <table>
                <tr>
                    <th>NIK</th>
                    <th>Tanggal Lahir</th>
                    <th>Nama</th>
                    <th>Detail</th>
                    <th>Status</th>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    // Tentukan class status berdasarkan nilai diproses
                    $statusClass = $row['diproses'] == 1 ? 'status-sudah-diproses' : 'status-sedang-diproses';
                    
                    echo "<tr>";
                    echo "<td>" . $row['nik'] . "</td>";
                    echo "<td>" . $row['tanggal_lahir'] . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td class='detail-batal-container'>";
                    echo "<a class='detail-link' href='detail_pengajuan.php?id={$row['id']}'>Detail</a>";
                    // Tambahkan tombol batal dengan konfirmasi JavaScript
                    // Tambahkan kondisi untuk menampilkan tombol batal hanya jika status belum diproses
                    if ($row['diproses'] == 0) {
                        echo "<a class='batal-link' href='javascript:void(0);' onclick='konfirmasiBatal({$row['id']})'>Batalkan</a>";
                    }
                    
                    echo "</td>";
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

    <!-- Tambahkan script JavaScript untuk konfirmasi  -->
    <script>
        function konfirmasiBatal(id) {
            var konfirmasi = confirm("Apakah Anda yakin ingin membatalkan pengajuan?");
            if (konfirmasi) {
                window.location.href = 'batal_pengajuan.php?id=' + id;
            }
        }

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