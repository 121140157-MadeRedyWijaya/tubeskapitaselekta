<?php
include __DIR__ . '/../koneksi.php';

// Query untuk mengambil data dari database
$query = "SELECT * FROM warga_terdaftar";
$result = mysqli_query($koneksi, $query);

// Menghitung jumlah data
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Warga Terdaftar</title>
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

        h2 {
            color: #ff1493;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #e86bd9;
            color: white;
        }

        .search-label {
            margin-bottom: 10px;
        }

        .count-info {
            margin-top: 10px;
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
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop untuk menampilkan data dalam tabel
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['nik']}</td>";
                    echo "<td>{$row['nama']}</td>";
                    echo "<td>{$row['tanggal_lahir']}</td>";
                    echo "<td><a href='detail_warga.php?nik={$row['nik']}'>Detail</a></td>";
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

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
