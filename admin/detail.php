
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

        if (isset($_GET['nik'])) {
            $nik = $_GET['nik'];

            // Query untuk mendapatkan data dari tabel warga_pengajuan
            $query = "SELECT * FROM warga_pengajuan WHERE nik = ?";
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
                    echo "<p>Lihat KK:<a href='../database/filetambahan/{$row['kk_filename']}' target='_blank'>Lihat KK</a></p>";
                }
                if (!empty($row['ktp_filename'])) {
                    echo "<p>Lihat KTP:<a href='../database/filetambahan/{$row['ktp_filename']}' target='_blank'>Lihat KTP</a></p>";
                }
            }
        }

        if (isset($_POST['konfirmasi'])) {
            $nik = $_GET['nik'];

            // Query untuk mengubah kolom diproses menjadi 1
            $queryUpdate = "UPDATE warga_pengajuan SET diproses = 1 WHERE nik = ?";
            $stmtUpdate = mysqli_prepare($koneksi, $queryUpdate);
            mysqli_stmt_bind_param($stmtUpdate, "s", $nik);

            // Query untuk menambahkan duplikat data ke warga_terdaftar
            $queryInsertTerdaftar = "INSERT INTO warga_terdaftar (nik, tanggal_lahir, nama, agama, jenis_kelamin, alamat, username) 
                                    SELECT nik, tanggal_lahir, nama, agama, jenis_kelamin, alamat, username
                                    FROM warga_pengajuan WHERE nik = ?";
            $stmtInsertTerdaftar = mysqli_prepare($koneksi, $queryInsertTerdaftar);
            mysqli_stmt_bind_param($stmtInsertTerdaftar, "s", $nik);

            // Eksekusi query
            if (mysqli_stmt_execute($stmtUpdate) && mysqli_stmt_execute($stmtInsertTerdaftar)) {
                echo "<script>alert('Data berhasil dikonfirmasi dan dipindahkan');</script>";
            } else {
                echo "<script>alert('Gagal memindahkan data ke warga_terdaftar');</script>";
            }

            // Mengarahkan kembali ke data_pengajuan.php setelah konfirmasi selesai
            header("Location: data_pengajuan.php");
            exit;
        }
        ?>

        <form method="post" action="detail.php?nik=<?php echo $nik; ?>" onsubmit="return confirmSubmission()">
            <input type="submit" name="konfirmasi" value="Terima Data Warga">
        </form>
        <a href="data_pengajuan.php" style="display: block; text-align: center;">Kembali</a>

    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>