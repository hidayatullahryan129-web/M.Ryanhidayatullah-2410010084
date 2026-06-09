<?php
//memulai sesi
session_start();

//panggil file koneksi
include 'koneksi.php';

//jika belum login, paksa user ke halaman login
if (!isset($_SESSION['status_login'])) {
    header("location: login.php");
    exit();
}

//Proteksi, hanya masyarakat yang boleh mengakses halaman ini
if ($_SESSION ['role'] != 'masyarakat') {
    echo "<script>alert('hanya masyarakat yang boleh mengakses halaman ini!'); window.location =
    'dashboard.php';</script>";
    exit();
}

//Proses simpan data ke database
if (isset ($_POST['btn_simpan'])) {
    //Ambil field yang akan disimpan
    $tgl_pengaduan = date ('Y-m-d');
    $id_user = $_SESSION ['id_user'];
    $isi_laporan = $_POST ['isi_laporan'];
    $status = 'pending';

    //Simpan data ke database
    $simpan = mysqli_query($koneksi, "INSERT INTO tb_pengaduan VALUES (NULL, '$tgl_pengaduan',
    '$id_user', '$isi_laporan', '$status')");
    if ($simpan) {
        echo "<script>alert('Pengaduan berhasil ditambahkan!'); window.location = 'dashboard.php';
        </script>";
    } else {
        echo "<script>alert('Pengaduan gagal ditambahkan!'); window.location = 'dashboard.php';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">E-Pengaduan</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Data Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cetak Laporan</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-danger btn-sm mt-1" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Form Pengaduan Masyarakat</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label">Tulis isi Laporan Anda:</label>
                                <textarea class="form-control" name="isi_laporan" rows="5" required placeholder="Jelaskan laporan anda disini..."></textarea>
                            </div>
                            <button type="submit" name="btn_simpan" class="btn btn-success">Kirim Laporan</button>
                            <a href="dashboard.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>