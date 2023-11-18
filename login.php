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

        .content {
            width: 300px;
            margin: 0 auto;
            margin-top: 100px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        form {
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
        }

        input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #e86bd9;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #e332ce;
        }

        p {
            text-align: center;
            margin-top: 10px;
        }

        a {
            color: #0645AD;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="content">
        <h2>Form Login</h2>
        <form method="post" action="">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username"><br>
            <label for="password">Password:</label><br>
            <input type="password" id="password" name="password"><br>
            <input type="submit" value="Login">
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>

    </div>
</body>
</html>
