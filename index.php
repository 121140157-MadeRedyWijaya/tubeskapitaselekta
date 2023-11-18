<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Kali Sari</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        #logo {
            max-width: 100%;
            height: auto;
        }

        h1 {
            font-family: 'Poppins', sans-serif;
            color: #333;
            margin-top: 20px;
        }

        .button-container {
            margin-top: 20px;
            display: flex;
            gap: 20px;
        }

        .button-container a {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #e86bd9;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: #e332ce;
        }

        #logo {
            max-width: 10%;
            height: auto;
        }
    </style>
</head>
<body>
    <img id="logo" src="logo.png" alt="Desa Kali Sari Logo">
    <h1>Pendataan Warga Desa Kali Sari</h1>
    <div class="button-container">
        <a href="login.php">Login</a>
        <a href="register.php">Daftar Akun</a>
    </div>
</body>
</html>
