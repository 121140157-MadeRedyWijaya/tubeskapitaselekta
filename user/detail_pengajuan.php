<?php
include __DIR__ . '/../koneksi.php';
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Check if the ID parameter is set in the URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to retrieve detailed information based on the ID
    $query = "SELECT * FROM warga_pengajuan WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, "i", $id); // Assuming ID is an integer
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if the query is successful and data is found
    if ($row = mysqli_fetch_assoc($result)) {
        echo "<h2>Detail Data Pengajuan</h2>";
        echo "<p>NIK: " . $row['nik'] . "</p>";
        echo "<p>Tanggal Lahir: " . $row['tanggal_lahir'] . "</p>";
        echo "<p>Nama: " . $row['nama'] . "</p>";
        echo "<p>Agama: " . $row['agama'] . "</p>";
        echo "<p>Jenis Kelamin: " . $row['jenis_kelamin'] . "</p>";
        echo "<p>Alamat: " . $row['alamat'] . "</p>";


        // Back link to the previous page
        echo "<p><a href='application_table.php'>Back to Data Pengajuan</a></p>";
    } else {
        // If no data is found
        echo "<p>Data not found.</p>";
    }

    // Close the prepared statement
    mysqli_stmt_close($stmt);
} else {
    // If no ID parameter is set in the URL
    echo "<p>Invalid request. Please provide a valid ID.</p>";
}

// Close the database connection
mysqli_close($koneksi);
?>
