<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desa Kali Sari</title>
    <style>
        /* Common styles for both desktop and mobile */
        body {
            background-image: url('./asset/background.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            font-family: 'Poppins';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            position: relative;
        }

        #logo {
            max-width: 10%;
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
            flex-direction: column;
            align-items: center;
        }

        .button-container a {
            text-align: center;
            text-decoration: none;
            padding: 10px 20px;
            background-color: #3081D0;
            color: white;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
            transition: background-color 0.3s;
        }

        .button-container a:hover {
            background-color: #045676;
        }

        /* Footer styles for both desktop and mobile */
        footer {
            background-color: #5E5E5E;
            padding: 10px;
            width: 100%;
            text-align: center;
            position: fixed;
            bottom: 0;
        }

        footer a {
            text-decoration: none;
            color: #FFF;
            margin: 0 10px;
        }

        /* Media query for mobile devices */
        @media only screen and (max-width: 600px) {
            #logo {
                max-width: 30%;
                height: auto;
            }
            h1 {
                font-size: 20px;
                text-align: center;
            }

            .button-container a {
                width: 80%;
            }

            body {
                min-height:60vh;
            }
        }
    </style>
</head>
<body>
    <img id="logo" src="./asset/logo.png" alt="Desa Kali Sari Logo">
    <h1>Pendataan Warga Desa Kali Sari</h1>
    <div class="button-container">
        <a href="login.php">Login</a>
        <a href="register.php">Daftar Akun</a>
    </div>

    <!-- Footer -->
    <footer>
        <a href="https://kalisarinatar.id/">Tentang Desa</a>
    </footer>
</body>
</html>
