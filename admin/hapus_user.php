<?php
ob_start();
session_start();
include __DIR__ . '/../koneksi.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Ambil role sebelum menghapus
    $queryGetRole = "SELECT role FROM users WHERE username = '$username'";
    $resultGetRole = mysqli_query($koneksi, $queryGetRole);
    
    if ($resultGetRole) {
        $rowRole = mysqli_fetch_assoc($resultGetRole);
        $role = $rowRole['role'];

        // Pengecekan role sebelum menghapus
        if ($role !== 'admin') {
            // Query untuk menghapus akun berdasarkan username
            $query = "DELETE FROM users WHERE username = '$username'";
            $result = mysqli_query($koneksi, $query);

            // Redirect kembali ke halaman data_user.php setelah menghapus
            header("Location: data_user.php");
            exit;
        } else {
            // Role adalah admin, tidak dapat dihapus
            echo "Role admin tidak dapat dihapus.";
        }
    } else {
        // Gagal mengambil role
        echo "Gagal mengambil informasi role.";
    }
}
?>