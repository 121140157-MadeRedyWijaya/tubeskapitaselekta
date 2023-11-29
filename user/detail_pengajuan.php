



















<!DOCTYPE html>
<html>
<head>
    <title>Detail Data</title>
    <style>
        body {
            font-family: 'Poppins';
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh; 
            text-align: left; 
        }

        h2 {
            color: #333;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            text-align: center; 
        }

        p {
            margin: 10px 0;
            color: #555;
            text-align: left; 
            padding-left: 20px; 
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            margin-top: 20px;
            text-align: center; 
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>

    <script>
        function confirmSubmission() {
            return confirm("Apakah anda yakin menerima pengajuan ini?");
        }
    </script>
</head>
<body>
    <div class="container">
    <?php
        include __DIR__ . '/../koneksi.php';
        session_start();

        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        // Check if the ID parameter is set in the URL
        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            // Query to retrieve detailed information based on the ID
            $query = "SELECT * FROM warga_pengajuan WHERE id = ?";
            $stmt = mysqli_prepare($koneksi, $query);
            mysqli_stmt_bind_param($stmt, "i", $id); // Assuming ID is an integer
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            // Check if the query is successful and data is found
            if ($row = mysqli_fetch_assoc($result)) {
                echo "<h2>Detail Data Pengajuan</h2>";
                echo "<p>NIK: " . $row['nik'] . "</p>";
                echo "<p>Tanggal Lahir: " . $row['tanggal_lahir'] . "</p>";
                echo "<p>Nama: " . $row['nama'] . "</p>";
                echo "<p>Agama: " . $row['agama'] . "</p>";
                echo "<p>Jenis Kelamin: " . $row['jenis_kelamin'] . "</p>";
                echo "<p>Alamat: " . $row['alamat'] . "</p>";


            } else {
                // If no data is found
                echo "<p>Data not found.</p>";
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            // If no ID parameter is set in the URL
            echo "<p>Invalid request. Please provide a valid ID.</p>";
        }
        ?>

       
        <a href="application_table.php" style="display: block; text-align: center;">Kembali</a>

    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>