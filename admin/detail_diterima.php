<?php
include __DIR__ . '/../koneksi.php';

if (isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Query untuk mendapatkan data dari tabel warga_pengajuan_diterima
    $query = "SELECT * FROM warga_pengajuan WHERE nik = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "s", $nik);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Menampilkan detail data berdasarkan NIK
    if ($row = mysqli_fetch_assoc($result)) {
        echo "<h2>Detail Data</h2>";
        echo "<p>NIK: " . $row['nik'] . "</p>";
        echo "<p>Tanggal Lahir: " . $row['tanggal_lahir'] . "</p>";
        echo "<p>Nama: " . $row['nama'] . "</p>";
        echo "<p>Agama: " . $row['agama'] . "</p>";
        echo "<p>Jenis Kelamin: " . $row['jenis_kelamin'] . "</p>";
        echo "<p>Alamat: " . $row['alamat'] . "</p>";

        // Menampilkan link ke file KK dan KTP jika tersedia
        if (!empty($row['kk_filename'])) {
            echo "<p><a href='../database/filetambahan/{$row['kk_filename']}' target='_blank'>Lihat KK</a></p>";
        }
        if (!empty($row['ktp_filename'])) {
            echo "<p><a href='../database/filetambahan/{$row['ktp_filename']}' target='_blank'>Lihat KTP</a></p>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            background-color: #e86bd9;
            color: white;
            cursor: pointer;
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #e332ce;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            background-color: #5cb85c;
            color: white;
            text-decoration: none;
        }

        a.button:hover {
            background-color: #449d44;
        }
    </style>
</head>
<body>
    <form method="get" action="data_pengajuan.php">
        <input type="submit" value="Kembali">
    </form>
</body>
</html>
