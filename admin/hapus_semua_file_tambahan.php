<?php
ob_start();
session_start();
include __DIR__ . '/../koneksi.php';

// Periksa apakah admin sudah login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Fungsi untuk menghapus semua file di folder database/filetambahan
function hapusSemuaFileTambahan() {
    $folderPath = __DIR__ . '/../database/filetambahan';

    // Mengecek apakah folder filetambahan ada
    if (is_dir($folderPath)) {
        // Mendapatkan semua file di dalam folder
        $files = glob($folderPath . '/*');

        // Menghapus setiap file
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        // Mengembalikan true jika penghapusan berhasil
        return true;
    }

    // Mengembalikan false jika folder tidak ditemukan
    return false;
}

// Memproses penghapusan jika tombol di klik
if (isset($_GET['hapus_semua_file_tambahan'])) {
    if (hapusSemuaFileTambahan()) {
        echo '<script>alert("Semua file tambahan berhasil dihapus.");</script>';

        // Menambahkan jeda selama 3 detik
        sleep(3);

        // Alihkan kembali ke data_pengajuan.php
        header("Location: data_pengajuan.php");
        exit;
    } else {
        echo '<script>alert("Folder filetambahan tidak ditemukan.");</script>';
    }
    die(); // Tambahkan ini untuk memastikan eksekusi berhenti setelah header
}


// Tutup koneksi database jika diperlukan
mysqli_close($koneksi);
?>