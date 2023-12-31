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
            font-family: 'Poppins';
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

        /* Style for the table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            border: 2px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        #th1 {
            text-align: center;
            background-color: #ffcc66;
            color: #1c1b1b;
        }
        #th2 {
            text-align: center;
            background-color: #66cc66;
            color: #1c1b1b;
        }






        tr:hover {
            background-color: #f5f5f5;
        }



        h2 {
            color: #333;
            margin: 0;
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

      
        .detail {
            text-align: center;
        }
 
        .button-periksa {
            width: 70px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .button-periksa:hover {
            background-color: #45a049;
        }

        .button-hapus {
            width: 70px;
            padding: 8px 12px;
            background-color: #e74c3c;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .button-hapus:hover {
            background-color: #c0392b;
        }
        
    
        .button-lihat {
            width: 70px;
            padding: 8px 12px;
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-lihat:hover {
            background-color: #2980b9;
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
        <h2>Data Belum Diproses</h2>
        <!-- Menampilkan informasi jumlah data belum diproses -->
        <p>Jumlah Data Belum Diproses: <?php echo $numRowsBelumDiproses; ?></p>
        <table border='1'>
            <tr>
                <th id="th1" style="width: 15%;">Tanggal Pengajuan</th>
                <th id="th1" style="width: 20%;">NIK</th>
                <th id="th1" style="width: 15%;">Tanggal Lahir</th>
                <th id="th1" style="width: 25%;">Nama</th>
                <th id="th1" style="width: 15%;">Detail</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($resultBelumDiproses)) {
                echo "<tr>";
                echo "<td>" . $row['tanggal_submit'] . "</td>";
                echo "<td>" . $row['nik'] . "</td>";
                echo "<td>" . $row['tanggal_lahir'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td class='detail'>
                        <form style='display: inline-block;' action='detail.php' method='get'>
                            <input type='hidden' name='nik' value='" . $row['nik'] . "'>
                            <button class='button-periksa' type='submit'>Periksa</button>
                        </form>
                        <button class='button-hapus' onclick='confirmDelete(\"" . $row['nik'] . "\")'>Hapus</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
        <br><br>

        <h2>Data Sudah Diproses</h2>
        <!-- Menampilkan informasi jumlah data sudah diproses -->
        <p>Jumlah Data Sudah Diproses: <?php echo $numRowsSudahDiproses; ?></p>
        <table border='1'>
            <tr>
                <th id="th2" style="width: 15%;">Tanggal Pengajuan</th>
                <th id="th2" style="width: 20%;">NIK</th>
                <th id="th2" style="width: 15%;">Tanggal Lahir</th>
                <th id="th2" style="width: 25%;">Nama</th>
                <th id="th2" style="width: 15%;">Detail</th>
            </tr>

            <?php
            while ($row = mysqli_fetch_assoc($resultSudahDiproses)) {
                echo "<tr>";
                echo "<td>" . $row['tanggal_submit'] . "</td>";
                echo "<td>" . $row['nik'] . "</td>";
                echo "<td>" . $row['tanggal_lahir'] . "</td>";
                echo "<td>" . $row['nama'] . "</td>";
                echo "<td class='detail'>
                        <form style='display: inline-block;' action='detail_diterima.php' method='get'>
                            <input type='hidden' name='nik' value='" . $row['nik'] . "'>
                            <button class='button-lihat' type='submit'>Lihat</button>
                        </form>
                        <button class='button-hapus' onclick='confirmDelete(\"" . $row['nik'] . "\")'>Hapus</button>
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>

        
    </div>
    <div>
        <a href="javascript:void(0);" onclick="confirmDeleteAllFileTambahan()" class="button-hapus-semua">Hapus Semua File Tambahan di Database</a>

    </div>

    <script>
        function confirmLogout() {
                var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
                if (confirmLogout) {
                    window.location.href = "../logout.php";
                }
        }
  
        function confirmDelete(nik) {
            var isConfirmed = confirm("Apakah Anda yakin ingin menghapus data pengajuan?");
            if (isConfirmed) {
                window.location.href = "hapus_pengajuan.php?nik=" + nik;
            }
        }

        function confirmDeleteAllFileTambahan() {
            var isConfirmed = confirm("Apakah Anda yakin ingin menghapus semua file tambahan di database?");
            if (isConfirmed) {
                window.location.href = "hapus_semua_file_tambahan.php?hapus_semua_file_tambahan=1";
            }
        }

    </script>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>