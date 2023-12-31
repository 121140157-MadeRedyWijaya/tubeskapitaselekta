<?php
ob_start();
session_start();
?>
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
            height: 170vh; 
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

                echo "<p><strong>NIK: " . $row['nik'] . "</p>";
                echo "<p><strong>No. KK: " . $row['no_kk'] . "</p>";
                echo "<p><strong>Nama Lengkap: " . $row['nama'] . "</p>";
                echo "<p><strong>Tempat Lahir: " . $row['tempat_lahir'] . "</p>";
                echo "<p><strong>Tanggal Lahir: " . $row['tanggal_lahir'] . "</p>";
                echo "<p><strong>Jenis Kelamin: " . $row['jenis_kelamin'] . "</p>";
                echo "<p><strong>Agama: " . $row['agama'] . "</p>";
                echo "<p><strong>Pendidikan Terakhir: " . $row['pendidikan_terakhir'] . "</p>";
                echo "<p><strong>Pekerjaan: " . $row['pekerjaan'] . "</p>";
                echo "<p><strong>Golongan Darah: " . $row['golongan_darah'] . "</p>";
                echo "<p><strong>Status Kawin: " . $row['status_kawin'] . "</p>";
                echo "<p><strong>Hubungan Dalam Keluarga: " . $row['hubungan'] . "</p>";
                echo "<p><strong>Warga Negara: " . $row['warga_negara'] . "</p>";
                echo "<p><strong>Suku/Etnis: " . $row['sukuetnis'] . "</p>";
                echo "<p><strong>Nama Ayah: " . $row['nama_ayah'] . "</p>";
                echo "<p><strong>Nama Ibu: " . $row['nama_ibu'] . "</p>";
                echo "<p><strong>Status Penduduk: " . $row['status_penduduk'] . "</p>";
                echo "<p><strong>Nomor Telepon: " . $row['no_telpon'] . "</p>";
                echo "<p><strong>Dusun: " . $row['rw'] . "</p>";
                echo "<p><strong>RT: " . $row['rt'] . "</p>";
                echo "<p><strong>Alamat Sekarang: " . $row['alamat'] . "</p>";

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
            $queryInsertTerdaftar = "INSERT INTO warga_terdaftar (nik, no_kk, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, pendidikan_terakhir, pekerjaan, golongan_darah, status_kawin, hubungan, warga_negara, sukuetnis, nama_ayah, nama_ibu, status_penduduk, no_telpon, rw, rt, alamat, username) 
                                    SELECT nik, no_kk, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, pendidikan_terakhir, pekerjaan, golongan_darah, status_kawin, hubungan, warga_negara, sukuetnis, nama_ayah, nama_ibu, status_penduduk, no_telpon, rw, rt, alamat, username
                                    FROM warga_pengajuan WHERE nik = ?";
            $stmtInsertTerdaftar = mysqli_prepare($koneksi, $queryInsertTerdaftar);
            mysqli_stmt_bind_param($stmtInsertTerdaftar, "s", $nik);


            // Eksekusi query setelah eksekusi statement update
            if (mysqli_stmt_execute($stmtInsertTerdaftar) && mysqli_stmt_execute($stmtUpdate)) {
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