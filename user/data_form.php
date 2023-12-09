<?php
include __DIR__ . '/../koneksi.php';
session_start();
// Definisikan fungsi isValidFile
function isValidFile($file, $allowedTypes, $maxSize) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    // Cek apakah file ada sebelum menggunakan finfo_file
    if (file_exists($file)) {
        $fileType = finfo_file($finfo, $file);
        $fileSize = filesize($file);

        finfo_close($finfo);

        // Pengecekan tipe file dan ukuran
        return in_array($fileType, $allowedTypes) && $fileSize <= $maxSize;
    } else {
        finfo_close($finfo);
        echo "<script>alert('File tidak ditemukan atau tidak dapat diakses.');</script>";
        exit;
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
    
    $kk_file = $target_dir . basename($_FILES["kk"]["name"]);
    if (!empty($_FILES["kk"]["name"])) {
        move_uploaded_file($_FILES["kk"]["tmp_name"], $kk_file);
    }
    
    // KTP
    $ktp_file = $target_dir . basename($_FILES["ktp"]["name"]);
    if (!empty($_FILES["ktp"]["name"])) {
        move_uploaded_file($_FILES["ktp"]["tmp_name"], $ktp_file);
    }


    $query = "INSERT INTO warga_pengajuan (nik, no_kk, nama, tempat_lahir, tanggal_lahir, jenis_kelamin, agama, pendidikan_terakhir, pekerjaan, golongan_darah, status_kawin, hubungan, warga_negara, sukuetnis, nama_ayah, nama_ibu, status_penduduk, no_telpon, rw, rt, alamat, username, kk_filename, ktp_filename, tanggal_submit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";


        
    // Prepare the query
    $stmt = mysqli_prepare($koneksi, $query);

    // Check if preparation was successful
    if ($stmt === false) {
        die("Error in preparing the statement: " . mysqli_error($koneksi));
    }

    // Bind parameter with the appropriate data type

    mysqli_stmt_bind_param(
        $stmt,
        "sssssssssssssssssssssssss", 
        $nik,
        $no_kk,
        $nama,
        $tempat_lahir,
        $tanggal_lahir,
        $jenis_kelamin,
        $agama,
        $pendidikan_terakhir,
        $pekerjaan,
        $golongan_darah,
        $status_kawin,
        $hubungan,
        $warga_negara,
        $sukuetnis,
        $nama_ayah,
        $nama_ibu,
        $status_penduduk,
        $no_telpon,
        $rw,
        $rt,
        $alamat,
        $username,
        basename($kk_file),
        basename($ktp_file),
        $tanggal_submit_gmt7

    );

    // Assign values to the parameters
    $nik = $_POST['nik'];
    $no_kk = $_POST['no_kk'];
    $nama = $_POST['nama'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $agama = $_POST['agama'];
    $pendidikan_terakhir = $_POST['pendidikan_terakhir'];
    $pekerjaan = $_POST['pekerjaan'];
    $golongan_darah = $_POST['golongan_darah'];
    $status_kawin = $_POST['status_kawin'];
    $hubungan = $_POST['hubungan'];
    $warga_negara = $_POST['warga_negara'];
    $sukuetnis = $_POST['sukuetnis'];
    $nama_ayah = $_POST['nama_ayah'];
    $nama_ibu = $_POST['nama_ibu'];
    $status_penduduk = $_POST['status_penduduk'];
    $no_telpon = $_POST['no_telpon'];
    $rw = $_POST['rw'];
    $rt = $_POST['rt'];
    $alamat = $_POST['alamat'];
    $username = $_SESSION['username'];

    // Jalankan pernyataan
    if (mysqli_stmt_execute($stmt)) {
        // Data berhasil disimpan ke database
        header('Location: application_table.php');
        exit;
    } else {
        // Gagal menyimpan data
        die("Error in executing the statement: " . mysqli_error($koneksi));
    }
    
    // Tutup pernyataan
    mysqli_stmt_close($stmt);
    
    // ... Kode sebelumnya ...
    
    // Tampilkan alert JavaScript dan pernyataan lainnya di sini
    echo "<script>alert('Data berhasil dikirim dan disimpan');</script>";

    
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

        select {
            width: 60%;
            height: 34px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        /* Opsi untuk menambahkan warna latar belakang saat dihover */
        select:hover {
            background-color: #f8f8f8;
        }

        /* Opsi untuk menambahkan efek transisi ketika memilih opsi */
        select:focus {
            outline: none;
            border-color: #66afe9;
            box-shadow: 0 0 5px rgba(102, 175, 233, 0.6);
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

                <label for="no_kk">KK:</label>
                <input type="text" id="no_kk" name="no_kk" required>

                <label for="nama">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" required>

                <label for="tempat_lahir">Tempat Lahir:</label>
                <input type="text" id="tempat_lahir" name="tempat_lahir" required>

                <label for="tanggal_lahir">Tanggal Lahir:</label>
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" required>

                <label for="jenis_kelamin">Jenis Kelamin:</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="" style="display:none;" selected disabled>Pilih Jenis Kelamin</option>
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                </select>
                
                <label for="agama">Agama:</label>
                <select id="agama" name="agama" required>
                    <option value="" style="display:none;" selected disabled>Pilih Agama</option>
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katholik">Katholik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Khonghucu">Khonghucu</option>
                    <option value="Kepercayaan Lain">Kepercayaan Lain</option>
                </select>
                
                <label for="pendidikan_terakhir">Pendidikan Terakhir:</label>
                <select id="pendidikan_terakhir" name="pendidikan_terakhir" required>
                    <option value="" style="display:none;" selected disabled>Pilih Pendidikan</option>
                    <option value="Tidak/Belum Sekolah">Tidak/Belum Sekolah</option>
                    <option value="Belum Tamat SD/Sederajat">Belum Tamat SD/Sederajat</option>
                    <option value="Tamat SD/Sederajat">Tamat SD/Sederajat</option>
                    <option value="SLTP/Sederajat">SLTP/Sederajat</option>
                    <option value="SLTA/Sederajat">SLTA/Sederajat</option>
                    <option value="Diploma I/II">Diploma I/II</option>
                    <option value="Akademi/Diploma III/S. Muda">Akademi/Diploma III/S. Muda</option>
                    <option value="Diploma IV/Strata I">Diploma IV/Strata I</option>
                    <option value="Strata II">Strata II</option>
                    <option value="Strata III">Strata III</option>
                </select>
                
                <label for="pekerjaan">Pekerjaan:</label>
                <input type="text" id="pekerjaan" name="pekerjaan" required>
                
                <label for="golongan_darah">Golongan Darah:</label>
                <select id="golongan_darah" name="golongan_darah" required>
                    <option value="" style="display:none;" selected disabled>Pilih Golongan Darah</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                    <option value="O">O</option>
                    <option value="A+">A+</option>
                    <option value="A-">A-</option>
                    <option value="B+">B+</option>
                    <option value="B-">B-</option>
                    <option value="AB+">AB+</option>
                    <option value="AB-">AB-</option>
                    <option value="O+">O+</option>
                    <option value="O-">O-</option>
                    <option value="Tidak Tahu">Tidak Tahu</option>
                </select>
                
                <label for="status_kawin">Status Kawin:</label>
                <select id="status_kawin" name="status_kawin" required>
                    <option value="" style="display:none;" selected disabled>Pilih Status Kawin</option>
                    <option value="Belum Kawin">Belum Kawin</option>
                    <option value="Kawin">Kawin</option>
                    <option value="Cerai Hidup">Cerai Hidup</option>
                    <option value="Cerai Mati">Cerai Mati</option>
                </select>

                
            </div>
            
            <!-- Kolom Tengah -->
            <div class="form-group">
                <label for="hubungan">Hubungan Dalam Keluarga:</label>
                <select id="hubungan" name="hubungan" required>
                    <option value="" style="display:none;" selected disabled>Pilih Hubungan Keluarga</option>
                    <option value="Kepala Keluarga">Kepala Keluarga</option>
                    <option value="Suami">Suami</option>
                    <option value="Istri">Istri</option>
                    <option value="Anak">Anak</option>
                    <option value="Menantu">Menantu</option>
                    <option value="Cucu">Cucu</option>
                    <option value="Mertua">Mertua</option>
                    <option value="Pembantu">Pembantu</option>
                </select>
                
                <label for="warga_negara">Warga Negara:</label>
                <select id="warga_negara" name="warga_negara" required>
                    <option value="" style="display:none;" selected disabled>Pilih Warga Negara</option>
                    <option value="WNI">WNI</option>
                    <option value="WNA">WNA</option>
                    <option value="Dua Kewarganegaraan">Dua Kewarganegaraan</option>
                </select>
                
                <label for="sukuetnis">Suku/Etnis (opsional):</label>
                <input type="text" id="sukuetnis" name="sukuetnis">
                
                <label for="nama_ayah">Nama Ayah:</label>
                <input type="text" id="nama_ayah" name="nama_ayah">
                
                <label for="nama_ibu">Nama Ibu:</label>
                <input type="text" id="nama_ibu" name="nama_ibu">
                
                <label for="status_penduduk">Status Penduduk:</label>
                <select id="status_penduduk" name="status_penduduk" required>
                    <option value="" style="display:none;" selected disabled>Pilih Status Penduduk</option>
                    <option value="Tetap">Tetap</option>
                    <option value="Tidak Tetap">Tidak Tetap</option>
                </select>

                <label for="no_telpon">Nomor Telepon:</label>
                <input type="text" id="no_telepon" name="no_telpon">
                
                <label for="rw">Dusun:</label>
                <select id="rw" name="rw" required>
                    <option value="" style="display:none;" selected disabled>Pilih Dusun</option>
                    <option value="KALIASIN I">KALIASIN I</option>
                    <option value="KALIASIN II">KALIASIN II</option>
                    <option value="KALIASIN III">KALIASIN III</option>
                    <option value="KALIASIN IV">KALIASIN IV</option>
                    <option value="BANJARSARI I">BANJARSARI I</option>
                    <option value="BANJARSARI II">BANJARSARI II</option>
                    <option value="BANJARSARI III">BANJARSARI III</option>
                </select>
                
                <label for="rt">RT:</label>
                <select id="rt" name="rt" required>
                    <option value="" style="display:none;" selected disabled>Pilih RT</option>
                    <option value="RT 001">RT 001</option>
                    <option value="RT 002">RT 002</option>
                    <option value="RT 003">RT 003</option>
                    <option value="RT 004">RT 004</option>
                    <option value="RT 005">RT 005</option>
                    <option value="RT 006">RT 006</option>
                    <option value="RT 007">RT 007</option>
                    <option value="RT 008">RT 008</option>
                    <option value="RT 009">RT 009</option>
                    <option value="RT 010">RT 010</option>
                    <option value="RT 011">RT 011</option>
                    <option value="RT 012">RT 012</option>
                    <option value="RT 013">RT 013</option>
                    <option value="RT 014">RT 014</option>
                    <option value="RT 015">RT 015</option>
                    <option value="RT 016">RT 016</option>
                    <option value="RT 017">RT 017</option>
                    <option value="RT 018">RT 018</option>
                    <option value="RT 019">RT 019</option>
                    <option value="RT 020">RT 020</option>
                    <option value="RT 021">RT 021</option>
                    <option value="RT 022">RT 022</option>
                    <option value="RT 023">RT 023</option>
                    <option value="RT 024">RT 024</option>
                    <option value="RT 025">RT 025</option>
                </select>

                <label for="alamat">Alamat Sekarang:</label>
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
