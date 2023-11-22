<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan data dari tabel users
$query = "SELECT * FROM users";
$result = mysqli_query($koneksi, $query);

// Menghitung jumlah data
$num_rows = mysqli_num_rows($result);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Data User</title>
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
            color: #CB0CB8;
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
        }

        /* Style for the table */
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
            background-color: #555;
            color: white;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        /* Style for search input */
        label {
            margin-right: 10px;
            font-weight: bold;
        }

        #search {
            padding: 8px;
            margin-bottom: 10px;
        }

        /* Style for data info */
        p {
            margin-top: 10px;
            margin-bottom: 20px;
            font-weight: bold;
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
    <header>
        <div class="logo">
            <img src="../logo.png" alt="Logo">
            <h2>Pendataan Desa Kali Sari</h2>
        </div>

        <div class="nav-link-right">
            <a href="admin_dashboard.php" class="nav-link nav-link-right">Dashboard</a>
            <a href="data_pengajuan.php" class="nav-link nav-link-right">Pengajuan</a>
            <a href="data_terdaftar.php" class="nav-link nav-link-right">Warga</a>
            <a href="data_user.php" class="nav-link nav-link-right">Akun</a>
            <a>Admin <?php echo $_SESSION['username']; ?></a>
            <a href="../logout.php" class="nav-link"><img src="../i-logout.png" alt="Logout" width="50"></a>
        </div>
    </header>

    <div class="content">
        <h2>Data User</h2>
        <!-- Label untuk mencari data -->
        <label for="search">Cari data akun berdasarkan username:</label>
        <input type="text" id="search" name="search" oninput="searchAccount()">

        <!-- Menampilkan informasi jumlah data -->
        <p>Jumlah Data User: <?php echo $num_rows; ?></p>

        <table border='1' id="accountTable">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Password</th>
                <th>Role</th>
            </tr>
            <?php
            // Menampilkan data pengguna dari hasil query
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['password'] . "</td>";
                echo "<td>" . $row['role'] . "</td>";
                echo "</tr>";
            }
            ?>
        </table>

    </div>

    <!-- Tambahkan script JavaScript -->
    <script>
        function searchAccount() {
            // Ambil nilai pencarian dari input
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("search");
            filter = input.value.toUpperCase();
            table = document.getElementById("accountTable");
            tr = table.getElementsByTagName("tr");

            // Loop melalui semua baris dan sembunyikan yang tidak sesuai
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[1]; // Ganti angka 1 dengan indeks kolom yang ingin Anda cari
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
    </script>

</body>

</html>
