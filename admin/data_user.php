<?php
include __DIR__ . '/../koneksi.php';

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
            background-color: grey;
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
        <h2>Data User</h2>
        <!-- Menampilkan informasi jumlah data -->
        <p>Jumlah Data User: <?php echo $num_rows; ?></p>

        <table border='1'>
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
</body>

</html>
