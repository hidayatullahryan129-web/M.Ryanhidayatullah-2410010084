<?php
session_start();
include 'koneksi.php';

//proteksi keamanan:hanya admin yang bisa mencetak laporan
if ($_SESSION ['role']!= 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.close();</script";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Pengaduan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS tambahan untuk merapikan hasil cetak di kertas */
        @media print {
            .btn-print {
                display: none;
            }

            /* Menyembunyikan tombol print saat dicetak */
        }
    </style>
</head>

<body class="bg-white">
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h2>LAPORAN DATA PENGADUAN MASYARAKAT</h2>
            <p>Pemerintah Desa / Kota Banjarmasin</p>
            <hr>
        </div>

        <table class="table table-bordered table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th width="5%" class="text-center">No</th>
                    <th width="15%">Tanggal</th>
                    <th width="20%">Nama Pelapor</th>
                    <th width="45%">Isi Laporan</th>
                    <th width="15%" class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
    <?php
    $no = 1;
    $query = mysqli_query($koneksi, "SELECT tb_pengaduan.*, tb_user.nama_lengkap FROM tb_pengaduan INNER JOIN tb_user ON tb_pengaduan.id_user = tb_user.id_user ORDER BY tgl_pengaduan DESC");

    while ($row = mysqli_fetch_array($query)) {
    ?>
        <tr>
            <td class="text-center"><?php echo $no++; ?></td>
            <td><?php echo date('d M Y', strtotime($row['tgl_pengaduan'])); ?></td>
            <td><?php echo $row['nama_lengkap']; ?></td>
            <td><?php echo $row['isi_laporan']; ?></td>
            <td class="text-center"><?php echo ucfirst($row['status']); ?></td>
        </tr>
    <?php } ?>
</tbody>
</table>
        </table>

        <div class="row mt-5">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p>Banjarmasin, 12-05-2026</p>
                <br><br><br>
                <p><strong>Administrator</strong></p>
            </div>
        </div>

        <div class="text-center mt-4 btn-print">
            <button onclick="window.print()" class="btn btn-success">Cetak Dokumen</button>
        </div>
    </div>

    <script>
        window.print();
    </script>
</body>

</html>
