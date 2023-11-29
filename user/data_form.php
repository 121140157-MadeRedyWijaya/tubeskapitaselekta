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
            font-family: 'Poppins';
            background-color: #f4f4f4;
        }

        /* Header */
        header {
            width: 100%;
            height: 100px;
            color: #fff;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px 0 10px;

        }

        header h2{
            color: #333;
            margin: 0;
        }

        a {
            text-decoration: none;
            color: #333;
        }

        .nav-link {
            color: #333;
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: bold;
            margin-left: 5px; 
        }

        .nav-link:hover {
            color: #045676;
        }

        .nav-link-left {
            float: left;
        }

        .nav-link-right {
            display: flex;
            align-items: center;
        }

        .nav-link-right a {
            margin-left: 20px; 
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            max-width: 50px;
            margin-right: 10px;
        }

        /* konten  */
        .content {
            padding: 20px; 
            text-align: center;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        h2{
            color: #333;
            margin: 0;
        }

        form {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap; 
        }

        .form-group {
            flex: 0 0 50%; 
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block; 
        }

        input[type="text"],
        input[type="date"],
        input[type="file"],
        input[type="hidden"] {
            width: 100%;
            width: 380.514px; 
            height: 34.229px;
            flex-shrink: 0;
            border-radius: 9.908px;
            border: 0.225px solid #000;
            background: #EDF2F7;
            }

            input[type="submit"] {
            display: block;
            margin: 0 auto; 
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #3081D0;
            color: white;
            cursor: pointer;
            width: 10%;
        }

        input[type="submit"]:hover {
            background-color: #045676;
        }

        p {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <header>
        <div class="logo">
            <img src="../asset/logo.png" alt="Logo">
            <h2>Pendataan Desa Kali Sari</h2>
        </div>

        <div class="nav-link-right">
            <a href="user_dashboard.php" class="nav-link nav-link-right">Dashboard</a>
            <a href="data_form.php" class="nav-link nav-link-right">Formulir</a>
            <a href="application_table.php" class="nav-link nav-link-right">Pengajuan</a>
            <a style="color: #0012b3; text-decoration: none; font-weight: bold;" href="#"><?php echo $_SESSION['username']; ?></a>
            <a href="#" onclick="confirmLogout()" class="nav-link"><img src="../asset/i-logout.png" alt="Logout" width="50"></a>
        </div>
    </header>
    
    <div class="content">
        <h2>Formulir Pendataan Warga</h2>
        <form method="post" action="" enctype="multipart/form-data" onsubmit="return confirmSubmission()">
            <!-- Kolom Kiri -->
            <div class="form-group">
                <label for="nik">NIK:</label>
                <input type="text" id="nik" name="nik" required>

                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <!-- Kolom Kanan -->
            <div class="form-group">
                <label for="agama">Agama:</label>
                <input type="text" id="agama" name="agama" required>

                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <input type="text" id="jenis_kelamin" name="jenis_kelamin" required>

                <label for="alamat">Alamat:</label>
                <input type="text" id="alamat" name="alamat" required>
            </div>

            <!-- Kolom Tengah -->
            <div class="form-group">
                <label for="kk">Unggah file KK sebagai bukti tambahan:</label>
                <input type="file" id="kk" name="kk" accept="image/*" required>
            </div>

            <!-- Kolom Tengah -->
            <div class="form-group">
                <label for="ktp">Unggah file KTP sebagai bukti tambahan (Opsional):</label>
                <input type="file" id="ktp" name="ktp" accept="image/*">
            </div>

            <input type="hidden" name="username" value="<?php echo $username; ?>"> <!-- Tambahkan ini untuk menyimpan username -->

            <!-- Tombol Submit -->
            <input type="submit" value="Submit">
        </form>
    </div>

    <script>
        function confirmSubmission() {
            return confirm('Apakah Anda yakin ingin mengirim formulir?');
        }

        function confirmLogout() {
                var confirmLogout = confirm("Apakah Anda yakin ingin logout?");
                if (confirmLogout) {
                    window.location.href = "../logout.php";
                }
        }
    </script>

</body>
</html>

<?php
// Tutup koneksi database
mysqli_close($koneksi);
?>