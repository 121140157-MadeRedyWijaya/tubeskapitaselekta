<?php
$host = "localhost";
$username = "pendata2_admin";
$password = "Kalisari_1234";
$database = "pendata2_kalisari";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
