<?php
$host = "localhost";
$username = "id21610075_pendataankalisari";
$password = "Kalisari_123";
$database = "id21610075_kalisari";

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
