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

        /* konten */
        .content {
            padding: 50px;
            text-align: center;
            background-color: #fff; /* Set background color */
            border-radius: 10px; /* Add some border-radius for a rounded appearance */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Add a subtle box shadow for depth */
            margin-top: 20px; /* Provide some space from the header */
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
            width: 50%;
        }

        input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #e86bd9;
            color: white;
            cursor: pointer;
            width: 8%;
        }

        input[type="submit"]:hover {
            background-color: #e332ce;
        }

        p {
            margin-top: 20px;
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
            <a href="user_dashboard.php" class="nav-link nav-link-right">Dashboard</a>
            <a href="data_form.php" class="nav-link nav-link-right">Formulir</a>
            <a href="application_table.php" class="nav-link nav-link-right">Pengajuan</a>
            <a>Warga <?php echo $_SESSION['username']; ?></a>
            <a href="../logout.php" class="nav-link"><img src="../i-logout.png" alt="Logout" width="50"></a>
        </div>
    </header>


    <div class="content">
        <h2>Welcome, User <?php echo $_SESSION['username']; ?></h2>
        
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
