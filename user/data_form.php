<?php
// Definisikan fungsi isValidFile
function isValidFile($file, $allowedTypes) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    // Cek apakah file ada sebelum menggunakan finfo_file
    if (file_exists($file)) {
        $fileType = finfo_file($finfo, $file);
        finfo_close($finfo);

        return in_array($fileType, $allowedTypes);
    } else {
        finfo_close($finfo);
        echo "<script>alert('File tidak ditemukan atau tidak dapat diakses.');</script>";
        exit;
    }
}

include __DIR__ . '/../koneksi.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil nilai dari formulir
    $nik = $_POST['nik'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $alamat = $_POST['alamat'] ?? '';
    $username = $_SESSION['username'] ?? ''; // Mengambil username dari sesi pengguna yang sudah login

    // Tambahkan kolom tanggal_submit
    $tanggal_submit = date('Y-m-d H:i:s'); // Mengambil tanggal dan waktu saat ini
    $timezone = new DateTimeZone('Asia/Jakarta');
    $datetime = new DateTime($tanggal_submit);
    $datetime->setTimezone($timezone);
    $tanggal_submit_gmt7 = $datetime->format('Y-m-d H:i:s');

    // Proses file yang diunggah
    $target_dir = "../database/filetambahan/";

    // Membuat direktori jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // KK
    $kk_file = $target_dir . basename($_FILES["kk"]["name"]);
    $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
    if (isValidFile($_FILES["kk"]["tmp_name"], $allowedTypes)) {
        move_uploaded_file($_FILES["kk"]["tmp_name"], $kk_file);
    } else {
        echo "<script>alert('File KK tidak valid. Hanya file gambar (jpeg, jpg, png), PDF, atau DOCX yang diperbolehkan.');</script>";
        exit;
    }

    // KTP
    $ktp_file = $target_dir . basename($_FILES["ktp"]["name"]);
    if (!empty($_FILES["ktp"]["name"])) {
        if (isValidFile($_FILES["ktp"]["tmp_name"], $allowedTypes)) {
            move_uploaded_file($_FILES["ktp"]["tmp_name"], $ktp_file);
        } else {
            echo "<script>alert('File KTP tidak valid. Hanya file gambar (jpeg, jpg, png), PDF, atau DOCX yang diperbolehkan.');</script>";
            exit;
        }
    }

    // Simpan data ke database
    $query = "INSERT INTO warga_pengajuan (nik, tanggal_lahir, nama, agama, jenis_kelamin, alamat, username, kk_filename, ktp_filename, tanggal_submit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssss", $nik, $tanggal_lahir, $nama, $agama, $jenis_kelamin, $alamat, $username, basename($kk_file), basename($ktp_file), $tanggal_submit_gmt7);

    if (mysqli_stmt_execute($stmt)) {
        // Data berhasil disimpan ke database
        echo "<script>alert('Data berhasil dikirim dan disimpan');</script>";
        header('Location: application_table.php');
        exit;
    } else {
        // Gagal menyimpan data
        echo "<script>alert('Gagal menyimpan data ke database');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulir Pendataan Warga</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            background-color: #ff77a9;
            width: 250px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 20px;
        }

        .menu-item a {
            display: block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 10px;
        }

        .menu-item a:hover {
            text-decoration: underline;
        }

        .content {
            margin-left: 280px;
            padding: 20px;
        }

        h2 {
            color: #ff1493;
        }

        form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="hidden"] {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            width: 100%;
        }

        input[type="submit"] {
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #e86bd9;
            color: white;
            cursor: pointer;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #e332ce;
        }

        p {
            margin-top: 20px;
        }
        .logout-link {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: #fff;
            text-decoration: none;
        }

        .logout-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="menu-item">
            <a href="./user_dashboard.php">Dashboard Pengguna</a>
        </div>
        <div class="menu-item">
            <a href="./data_form.php">Formulir Permohonan Pendataan</a>
        </div>
        <div class="menu-item">
            <a href="./application_table.php">Tabel Permohonan</a>
        </div>
        <a class="logout-link" href="../logout.php">Logout</a>
    </div>
    
    <div class="content">
        <h2>Formulir Pendataan Warga</h2>
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return confirmSubmission()">
            <!-- Input formulir -->
            <label for="nik">NIK:</label><br>
            <input type="text" id="nik" name="nik" required><br><br>
            <label for="tanggal_lahir">Tanggal Lahir:</label><br>
            <input type="date" id="tanggal_lahir" name="tanggal_lahir" required><br><br>
            <label for="nama">Nama:</label><br>
            <input type="text" id="nama" name="nama" required><br><br>
            <label for="agama">Agama:</label><br>
            <input type="text" id="agama" name="agama" required><br><br>
            <label for="jenis_kelamin">Jenis Kelamin:</label><br>
            <input type="text" id="jenis_kelamin" name="jenis_kelamin" required><br><br>
            <label for="alamat">Alamat:</label><br>
            <input type="text" id="alamat" name="alamat" required><br><br>

            <label for="kk">Unggah file KK sebagai bukti tambahan:</label><br>
            <input type="file" id="kk" name="kk" accept="image/*" required><br>
            <label for="ktp">Unggah file KTP sebagai bukti tambahan (Opsional):</label><br>
            <input type="file" id="ktp" name="ktp" accept="image/*"><br>
            <input type="hidden" name="username" value="<?php echo $username; ?>"> <!-- Tambahkan ini untuk menyimpan username -->
            
            <!-- Tombol Submit -->
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function confirmSubmission() {
            return confirm('Apakah Anda yakin ingin mengirim formulir?');
        }
    </script>

</body>
</html>
