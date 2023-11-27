<?php
include 'koneksi.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Registrasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            background-size: cover;
            background-position: center;
        }

        header {
        width: 100%;
        height: 50px;
        color: #fff;
        text-align: center;
        margin-bottom : 50px;
        }

        a {
        text-decoration: none;
        color:#2F2F2F;
        }

        .nav-link {
        display: inline-block;
        padding: 10px 20px;
        font-size: 18px;
        font-weight: bold;
        color:#2F2F2F;
        }

        .nav-link:hover {
        color: #045676;
        }

        .nav-link-left {
        float: left;
        }

        .nav-link-right {
        float: right;
        }

        h1 {
        font-size: 24px;
        margin-bottom: 10px;
        text-align: center;
        color:#2F2F2F;
        }

        

        .form-container {
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
        }

        .form-group {
        margin-bottom: 10px;
        align-items: center;
        color:#2F2F2F;
        }

        .form-control {
            margin-bottom: 10px;
            border-radius: 5px;
            background-color: #E6E6E6;
        }

        label {
        font-weight: bold;
        }

        input {
        width: 93%;
        padding: 10px;
        border: 1px solid #ccc;
        }

        input[type="text"] {
        height: 30px;
        }

        input[type="nomorhp"] {
        height: 30px;
        }

        input[type="password"] {
        height: 30px;
        }


        button {
            width: 20%; 
            background-color:#3081D0;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            display: block; 
            margin: 20px auto; 
            border-radius: 10px;
            margin-bottom: 5px;
        }

        button:hover {
        background-color: #045676;
        }
    </style>

</head>
<body>

    <header>
    <a href="index.php" class="nav-link nav-link-left"> < Kembali ke Halaman Utama</a>
    <a href="login.php" class="nav-link nav-link-right">Login</a>
    </header>

    <h1>Daftar Akun</h1>
    <div class="form-container">
        <form  id="registrationForm" method="post" action="">
            <div class="form-group">
                <label for="id">ID/Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan ID/Username" required>
                <label for="nomorhp">Nomor HP</label>
                <input type="nomorhp" class="form-control" id="nomorhp" name="nomorhp" placeholder="Masukkan Nomor HP" required>
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="confirmRegistration()">Daftar</button>
        </form>
    </div>

    <script>
    function confirmRegistration() {
        var isConfirmed = confirm("Apakah data tersebut sudah benar?");
        if (isConfirmed) {
            // Jika pengguna mengonfirmasi, kirim formulir
            document.getElementById("registrationForm").submit();
        } else {
            // Jika pengguna membatalkan, tidak lakukan apa-apa
        }
    }
    </script>

</body>
</html>

<!-- Logika Penyimpanan Data Registrasi -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $nomorhp = $_POST['nomorhp'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = 'warga';

    // Pengecekan apakah username sudah ada
    $check_query = "SELECT COUNT(*) FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($koneksi, $check_query);
    mysqli_stmt_bind_param($check_stmt, "s", $username);
    mysqli_stmt_execute($check_stmt);
    mysqli_stmt_bind_result($check_stmt, $existing_user);
    mysqli_stmt_fetch($check_stmt);
    mysqli_stmt_close($check_stmt);

    if ($existing_user > 0) {
        // Jika username sudah ada, berikan pesan error atau tindakan yang sesuai
        echo "Username sudah digunakan. Silakan pilih username lain.";
    } else {
        // Jika username belum ada, lanjutkan proses registrasi
        $query = "INSERT INTO users (username, nomorhp, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $nomorhp, $password, $role);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Pendaftaran Akun Berhasil');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
            exit;
        } else {
            echo "Gagal menyimpan data registrasi.";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($koneksi);
}
?>
