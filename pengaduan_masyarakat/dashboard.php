<?php
session_start();

include 'koneksi.php';

//menghitung total laporan
$query_total = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM tb_pengaduan");
$data_total = mysqli_fetch_array($query_total);

//menghitung laporan pending
$query_pending = mysqli_query($koneksi,"SELECT COUNT(*) AS pending FROM tb_pengaduan WHERE status ='pending'");
$data_pending = mysqli_fetch_array($query_pending);

//menghitung laporan selesai 
$query_selesai = mysqli_query($koneksi, "SELECT COUNT(*) AS selesai FROM tb_pengaduan WHERE status = 'selesai'");
$data_selesai = mysqli_fetch_array($query_selesai);

if (!isset($_SESSION['status_login'])){
    header("location; login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pengaduan Masyarakat</title>
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
                    <?php if ($_SESSION['role'] == 'admin') { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="cetak_laporan.php" target="_blank">Cetak Laporan</a>
                        </li>
                    <?php } ?>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-danger btn-sm mt-1" href="login.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-success shadow-sm" role="alert">
                    <h4 class="alert-heading">Selamat Datang, <?php echo $_SESSION ['nama_lengkap']; ?></h4>
                    <p class="mb-0">Anda login sebagai <strong> <?php echo $_SESSION ['role']; ?></strong>. Anda dapat menulis pengaduan baru atau melihat status pengaduan Anda di bawah ini.</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-secondary shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Pengaduan</h5>
                        <h2 class="mb-0"><?php echo $data_total['total']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Pending</h5>
                        <h2 class="mb-0"><?php echo $data_pending['pending']; ?></h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Laporan Selesai</h5>
                        <h2 class="mb-0"><?php echo $data_selesai ['selesai']; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h5 class="mb-0">Daftar Laporan Terbaru</h5>
                <?php if ($_SESSION['role'] == 'masyarakat') { ?>
                <a href="tambah_pengaduan.php" class="btn btn-primary btn-sm">+ buat laporan</a>
                <?php } ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="15%">Tanggal</th>
                                <th width="20%">Pelapor</th>
                                <th width="40%">Isi Laporan</th>
                                <th width="10%">Status</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($koneksi, "SELECT  tb_pengaduan.*, tb_user.nama_lengkap FROM tb_pengaduan INNER JOIN tb_user ON tb_pengaduan.id_user = tb_user.id_user ORDER BY tgl_pengaduan DESC");
                            while ($data = mysqli_fetch_array($query)){
                            ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $data['tgl_pengaduan'];?></td>
                                    <td><?php echo $data['nama_lengkap'];?></td>
                                    <td><?php echo $data['isi_laporan'];?></td>
                                    <td>
                                        <?php
                                            if($data['status'] == 'pending') {
                                                echo '<span class="badge bg-danger">pending</span';
                                            }else if ($data['status'] == 'proses') {
                                                echo '<span class="badge bg-warning">proses</span';
                                            }else if ($data['status'] == 'selesai') {
                                                echo '<span class="badge bg-primary">selesai</span';
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <?php if ($_SESSION['role'] == 'admin') { ?>
                                            <form action="update_status.php" method="POST" class="d-inline">
                                                <input type="hidden" name="id_pengaduan" value="<?php echo $data['id_pengaduan']; ?>">
                                                <select name="status" class="form-select form-select-sm d-inline w-auto" onchange="this.form.submit()">
                                                    <option value="pending" <?php if ($data['status'] == 'pending') echo 'selected'; ?>>pending</option>
                                                    <option value="proses" <?php if ($data['status'] == 'proses') echo 'selected'; ?>>proses</option>
                                                    <option value="selesai" <?php if ($data['status'] == 'selesai') echo 'selected'; ?>>selesai</option>
                                                </select>
                                            </form>

                                            <a href="hapus_pengaduan.php?id=<?php echo $data['id_pengaduan']; ?>"
                                            class="btn btn-danger btn-sm mt-1" onclick="return confirm('Yakin ingin menghapus laporan ini?')">Hapus</a>

                                        <?php } else { ?>
                                            <span class="text-muted">Menunggu Admin</span>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>