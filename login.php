<?php
include 'koneksi.php';  // Memasukkan file koneksi.php

session_start();

if (isset($_SESSION['username'])) {
    // Jika sudah login, arahkan ke dashboard sesuai peran
    if ($_SESSION['role'] === 'admin') {
        header("Location: ./admin/admin_dashboard.php");
    } else {
        header("Location: ./user/user_dashboard.php");
    }
    exit;
}

if ($_SERVER && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'] ?? '';
    $input_password = $_POST['password'] ?? '';

    // Gunakan parameterized query untuk mencegah SQL injection
    $query = "SELECT username, password, role FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ss", $input_username, $input_password);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $username, $password, $role);

    // Fetch result
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    // Verifikasi pengguna
    if ($username && $password) {
        // Jika login berhasil, set session dan arahkan ke dashboard sesuai peran
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        if ($role === 'admin') {
            header("Location: ./admin/admin_dashboard.php");
        } else {
            header("Location: ./user/user_dashboard.php");
        }
        exit;
    } else {
        echo "<script>alert('Username atau password salah!');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Form Login</title>
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
        color: #DB6DD0;
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

        input[type="email"] {
        height: 30px;
        }

        input[type="password"] {
        height: 30px;
        }


        button {
            width: 20%; 
            background-color:#DB6DD0;
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
        background-color: #CB0CB8;
        }
    </style>
</head>
<body>
    
   
    <header>
    <a href="index.php" class="nav-link nav-link-left"> < Kembali ke Halaman Utama</a>
    <a href="register.php" class="nav-link nav-link-right">Daftar</a>
    </header>

    <h1>Login Akun</h1>
    <div class="form-container">
        <form method="post" action="">
            <div class="form-group">
                <label for="id">ID/Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan ID/Username" required>
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password" required>
            </div>
            <button type="submit" class="btn btn-primary" value="Login">Login</button>
        </form>
    </div>

    
</body>
</html>
