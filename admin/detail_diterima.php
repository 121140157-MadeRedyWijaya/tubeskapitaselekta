
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
                echo "<h2>Detail Data Diterima</h2>";
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
                echo "<p><strong>NIK Ayah: " . $row['nik_ayah'] . "</p>";
                echo "<p><strong>Nama Ayah: " . $row['nama_ayah'] . "</p>";
                echo "<p><strong>NIK Ibu: " . $row['nik_ibu'] . "</p>";
                echo "<p><strong>Nama Ibu: " . $row['nama_ibu'] . "</p>";
                echo "<p><strong>Status Penduduk: " . $row['status_penduduk'] . "</p>";
                echo "<p><strong>Nomor Telepon: " . $row['no_telpon'] . "</p>";
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
        ?>

        <a href="data_pengajuan.php" style="display: block; text-align: center;">Kembali</a>

    </div>
</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>