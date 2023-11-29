<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Query untuk mengambil data dari database
$query = "SELECT * FROM warga_terdaftar";
$result = mysqli_query($koneksi, $query);

// Menghitung jumlah data
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <title>Data Warga Terdaftar</title>
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
            padding: 0 10px;
        }

        header h2 {
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

        th {
            text-align: center;
            background-color: #3db0ef;
            color: #1c1b1b;
        }

        tr:hover {
            background-color: #f5f5f5;
        }


        .button-lihat {
            width: 70px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .button-lihat:hover {
            background-color: #45a049;
        }

    
        label.search-label {
            margin-right: 10px;
            font-weight: bold;
        }

        input.search-input {
            padding: 8px;
            margin-bottom: 10px;
        }

  
        .count-info {
            margin-top: 10px;
            font-weight: bold;
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

        .button-lihat {
            width: 70px;
            padding: 8px 12px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .button-lihat:hover {
            background-color: #45a049;
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
        <h2>Data Warga Terdaftar</h2>

        <!-- Label untuk mencari data -->
        <label for="search">Cari data warga berdasarkan nama:</label>
        <input type="text" id="search" name="search" oninput="searchWarga()">

        <!-- Jumlah data -->
        <div class="count-info">Jumlah data: <?php echo $num_rows; ?></div>

        <!-- Tabel data warga -->
        <table id="wargaTable">
            <thead>
                <tr>
                    <th style="width: 20%;">NIK</th>
                    <th style="width: 15%;">Tanggal Lahir</th>
                    <th style="width: 30%;">Nama</th>
                    <th style="width: 10%;">Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop untuk menampilkan data dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['nik']}</td>";
                    echo "<td>{$row['tanggal_lahir']}</td>";
                    echo "<td>{$row['nama']}</td>";
                    echo "<td class='detail'>
                            <form action='detail_warga.php' method='get'>
                            <input type='hidden' name='nik' value='{$row['nik']}'>
                                <button class='button-lihat' type='submit'>Lihat</button>
                                </form>
                                </td>";
                                echo "</tr>";
                            }
                            ?>
            </tbody>
        </table>
    </div>

    <!-- Tambahkan script JavaScript -->
    <script>
        function searchWarga() {
            // Ambil nilai pencarian dari input
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("wargaTable");
            tr = table.getElementsByTagName("tr");
            
            // Loop melalui semua baris dan sembunyikan yang tidak sesuai
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[2]; // Ganti angka 1 dengan indeks kolom yang ingin Anda cari
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
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
