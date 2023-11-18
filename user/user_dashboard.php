<?php
include __DIR__ . '/../koneksi.php';

session_start();

// Pastikan hanya pengguna biasa yang dapat mengakses halaman ini
if ($_SESSION['role'] !== 'warga') {
    header("Location: ../login.php");
    exit;
}

// Inisialisasi variabel
$nik = "";
$tanggal_lahir = "";
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $nik = $_POST["nik"];
    $tanggal_lahir = $_POST["tanggal_lahir"];


    // Gunakan parameterized query untuk mencegah SQL injection
    $query = "SELECT * FROM warga_terdaftar WHERE nik = ? AND tanggal_lahir = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $nik, $tanggal_lahir);

    // Eksekusi query
    mysqli_stmt_execute($stmt);

    // Ambil hasil query
    $result = mysqli_stmt_get_result($stmt);

    // Periksa apakah data ditemukan atau tidak
    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $result = "Data ditemukan dalam database.";
        // Tambahkan logika atau tindakan tambahan jika diperlukan
    } else {
        $result = "Data tidak ditemukan dalam database.";
    }

    // Tutup statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff5f5;
            margin: 0;
            padding: 0;
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
            margin-top: 50px;
            text-align: center;
        }

        h2 {
            color: #ff1493;
        }

        form {
            margin-top: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #e86bd9;
            color: white;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #e332ce;
        }

        p {
            margin-top: 20px;
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
        <h2>Welcome, User <?php echo $_SESSION['username']; ?></h2>
        <!-- Tambahkan konten sesuai kebutuhan -->
        <p>This is the user dashboard.</p>

        <h2>Cek Data di Database</h2>
        <form method="post" action="">
            <label for="nik">NIK:</label><br>
            <input type="text" id="nik" name="nik" required><br><br>
            <label for="tanggal_lahir">Tanggal Lahir:</label><br>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required><br><br>
            <input type="submit" value="Cek Data">
        </form>

        <p><?php echo $result; ?></p>
        

        
    </div>

    
</body>
</html>
