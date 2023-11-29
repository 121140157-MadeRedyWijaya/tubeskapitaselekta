<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

</head>
<body>
    <?php
    include __DIR__ . '/../koneksi.php';

    if (isset($_GET['nik'])) {
        $nik = $_GET['nik'];

        // Query untuk mendapatkan data dari tabel warga_terdaftar
        $query = "SELECT * FROM warga_terdaftar WHERE nik = ?";
        $stmt = mysqli_prepare($koneksi, $query);
        mysqli_stmt_bind_param($stmt, "s", $nik);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Menampilkan detail data berdasarkan NIK
        if ($row = mysqli_fetch_assoc($result)) {
            echo "<h2>Detail Data</h2>";
            echo "<p><strong>NIK:</strong> " . $row['nik'] . "</p>";
            echo "<p><strong>Tanggal Lahir:</strong> " . $row['tanggal_lahir'] . "</p>";
            echo "<p><strong>Nama:</strong> " . $row['nama'] . "</p>";
            echo "<p><strong>Agama:</strong> " . $row['agama'] . "</p>";
            echo "<p><strong>Jenis Kelamin:</strong> " . $row['jenis_kelamin'] . "</p>";
            echo "<p><strong>Alamat:</strong> " . $row['alamat'] . "</p>";

            // Menampilkan link ke file KK dan KTP jika tersedia
            if (!empty($row['kk_filename'])) {
                echo "<p><strong>Lihat KK:</strong> <a href='../database/filetambahan/{$row['kk_filename']}' target='_blank'>Kartu Keluarga</a></p>";
            }
            if (!empty($row['ktp_filename'])) {
                echo "<p><strong>Lihat KTP:</strong> <a href='../database/filetambahan/{$row['ktp_filename']}' target='_blank'>Kartu Tanda Penduduk</a></p>";
            }
        }
    }
    ?>

    <form method="get" action="data_terdaftar.php">
        <input type="submit" value="Kembali">
    </form>
</body>
</html>


<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>