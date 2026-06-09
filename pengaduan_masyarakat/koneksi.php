<?php
// Konfigurasi database
$host       = "localhost"; // Server lokal
$username   = "root";      // Username default XAMPP
$password   = "";          // Password default XAMPP (kosong)
$database   = "db_pengaduan"; // Nama database yang baru dibuat

// Membuat koneksi menggunakan mysqli (Native/Struktural)
$koneksi = mysqli_connect($host, $username, $password, $database);

// Mengecek apakah koneksi berhasil (Untuk testing saat praktikum)
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Buka komentar di bawah ini hanya untuk menguji saat pertama kali dijalankan
// echo "Koneksi ke database berhasil!";
?>