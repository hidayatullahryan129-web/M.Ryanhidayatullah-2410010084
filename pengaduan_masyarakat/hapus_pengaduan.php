<?php
session_start();
include 'koneksi.php';

// Proteksi keamanan: Hanya admin yang boleh menghapus
if ($_SESSION['role'] != 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='dashboard.php';</script>";
    exit;
}

// Menangkap ID dari URL (Metode GET)
// Perhatikan penggunaan fungsi isset() untuk memastikan id ada di URL
if (isset($_GET['id'])) {
    $id_pengaduan = $_GET['id'];

    // Query Delete
    $hapus = mysqli_query($koneksi, "DELETE FROM tb_pengaduan WHERE id_pengaduan='$id_pengaduan'");

    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Data gagal dihapus!'); window.location='dashboard.php';</script>";
    }
} else {
    // Jika tidak ada parameter ID di URL, kembalikan ke dashboard
    header("Location: dashboard.php");
}
?>