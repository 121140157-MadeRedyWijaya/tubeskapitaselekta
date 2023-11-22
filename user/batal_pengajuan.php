<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id_pengajuan = $_GET["id"];

    // Cek apakah data dengan ID tersebut milik pengguna yang sedang login
    $query = "SELECT * FROM warga_pengajuan WHERE id = ? AND username = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "is", $id_pengajuan, $_SESSION['username']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $data_pengajuan = mysqli_fetch_assoc($result);

        // Cek apakah data sudah diproses
        if ($data_pengajuan['diproses'] == 0) {
            // Hapus data pengajuan
            $deleteQuery = "DELETE FROM warga_pengajuan WHERE id = ?";
            $deleteStmt = mysqli_prepare($koneksi, $deleteQuery);
            mysqli_stmt_bind_param($deleteStmt, "i", $id_pengajuan);

            if (mysqli_stmt_execute($deleteStmt)) {
                // Redirect kembali ke halaman pengajuan
                header("Location: application_table.php");
                exit;
            } else {
                echo "Error: " . mysqli_error($koneksi);
            }
        } else {
            echo "Data ini sudah diproses dan tidak dapat dibatalkan.";
        }
    } else {
        // Jika data tidak ditemukan atau tidak milik pengguna yang sedang login
        echo "Data tidak ditemukan atau Anda tidak memiliki akses.";
    }
} else {
    // Jika tidak ada parameter ID yang dikirimkan
    echo "Invalid request.";
}

// Tutup koneksi database
mysqli_close($koneksi);
?>
