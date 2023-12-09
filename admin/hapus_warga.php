<?php
ob_start();
session_start();
include __DIR__ . '/../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nik'])) {
    $nik = $_POST['nik'];

    // Query to delete the record from the warga_terdaftar table
    $queryDelete = "DELETE FROM warga_terdaftar WHERE nik = ?";
    $stmtDelete = mysqli_prepare($koneksi, $queryDelete);
    mysqli_stmt_bind_param($stmtDelete, "s", $nik);

    if (mysqli_stmt_execute($stmtDelete)) {
        echo "<script>alert('Data berhasil dihapus');</script>";
    } else {
        echo "<script>alert('Gagal menghapus data');</script>";
    }

    mysqli_stmt_close($stmtDelete);
}

// Redirect back to the page where the request originated
header("Location: data_terdaftar.php");
exit;
?>