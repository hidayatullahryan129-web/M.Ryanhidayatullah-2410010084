<?php
session_start();
include 'koneksi.php';

// Proteksi keamanan: Hanya admin yang boleh mengeksekusi file ini
if ($_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='dashboard.php';</script>";
    exit;
}

// Menangkap data dari form POST
$id_pengaduan = $_POST['id_pengaduan'];
$status_baru = $_POST['status'];

// Query Update
$update = mysqli_query($koneksi, "UPDATE tb_pengaduan SET status='$status_baru' WHERE id_pengaduan='$id_pengaduan'");

if ($update) {
    // Jika berhasil, langsung kembali ke dashboard tanpa pesan untuk efisiensi
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Gagal mengubah status!'); window.location='dashboard.php';</script>";
}
?>