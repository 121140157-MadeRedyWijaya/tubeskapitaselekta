<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER && isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';

    // Query to get the password from the database
    $query = "SELECT password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($koneksi, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['username']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $plain_text_password);

        if (mysqli_stmt_fetch($stmt)) {
            mysqli_stmt_close($stmt);

            // Verifying the current password
            if ($current_password == $plain_text_password) {
                // Update query for the new password
                $update_query = "UPDATE users SET password = ? WHERE username = ?";
                $update_stmt = mysqli_prepare($koneksi, $update_query);

                if ($update_stmt) {
                    mysqli_stmt_bind_param($update_stmt, "ss", $new_password, $_SESSION['username']);
                    mysqli_stmt_execute($update_stmt);

                    if (mysqli_stmt_affected_rows($update_stmt) > 0) {
                        echo "<script>alert('Password updated successfully');</script>";
                    } else {
                        echo "<script>alert('Failed to update password');</script>";
                        echo "Error: " . mysqli_error($koneksi);
                    }

                    mysqli_stmt_close($update_stmt);
                } else {
                    echo "<script>alert('Failed to prepare statement for updating password');</script>";
                    echo "Error: " . mysqli_error($koneksi);
                }
            } else {
                echo "<script>alert('Current password is incorrect');</script>";
            }
        } else {
            echo "<script>alert('Failed to fetch password data from the database');</script>";
        }
    } else {
        echo "<script>alert('Failed to prepare statement for fetching password');</script>";
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Kata Sandi</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            border-radius: 5px;
            text-align: left;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            background-color: #3081D0;
            color: #fff;
            padding: 10px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #045676;
        }

        p {
            margin-top: 10px;
            color: #333;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        /* Media queries for mobile devices */
        @media only screen and (max-width: 600px) {
            form {
                width: 90%;
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <h1>Ganti Kata Sandi</h1>
    
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    } elseif (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="">
        <label for="current_password">Kata Sandi Lama:</label>
        <input type="password" name="current_password" required>

        <label for="new_password">Kata Sandi Baru:</label>
        <input type="password" name="new_password" required>

        <label for="confirm_password">Konfirmasi Kata Sandi Baru:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Ganti Kata Sandi</button>
    </form>

    <a href="./login.php">Kembali</a>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>
