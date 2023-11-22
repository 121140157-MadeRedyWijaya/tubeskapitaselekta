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

<!DOCTYPE html>
<html>
<head>
    <title>Detail Data</title>
    <style>
        
    </style>
</head>
<body>
    <form method="post" action="detail.php?nik=<?php echo $nik; ?>">
        <input type="submit" name="konfirmasi" value="Terima Data Warga">
    </form>
    <a href="data_pengajuan.php">Kembali</a>
</body>
</html>
