<?php
include __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['nik'])) {
    $nik = $_GET['nik'];

    // Hapus data pengajuan berdasarkan NIK
    $queryDelete = "DELETE FROM warga_pengajuan WHERE nik = ?";
    $stmtDelete = mysqli_prepare($koneksi, $queryDelete);
    mysqli_stmt_bind_param($stmtDelete, "s", $nik);

    if (mysqli_stmt_execute($stmtDelete)) {
        echo "<script>alert('Data pengajuan berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data pengajuan');</script>";
    }

    mysqli_stmt_close($stmtDelete);
    mysqli_close($koneksi);

    // Redirect kembali ke halaman data_pengajuan.php
    header("Location: data_pengajuan.php");
    exit;
} else {
    // Redirect ke halaman data_pengajuan.php jika tidak ada parameter NIK
    header("Location: data_pengajuan.php");
    exit;
}
?>
