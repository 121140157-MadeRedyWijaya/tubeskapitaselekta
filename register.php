<?php
include 'koneksi.php';
// Selanjutnya, baris-baris kode PHP Anda
?>
<!-- Formulir Registrasi -->
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

        .content {
            width: 300px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        form {
            width: 280px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
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
    </style>

</head>
<body>
    <div class="content">
        <h2>Form Registrasi</h2>
        <form method="post" action="">
            <label for="username">Username baru:</label><br>
            <input type="text" id="username" name="username" required><br>
            <label for="email">Email:</label><br>
            <input type="text" id="email" name="email" required><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password" required><br>
            <input type="submit" value="Register">
            <p>Kembali ke halaman <a href="login.php">Login</a></p>
        </form>

    </div>
</body>
</html>

<!-- Logika Penyimpanan Data Registrasi -->
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
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
        $query = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $password, $role);

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
