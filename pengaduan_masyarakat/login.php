<?php
//Memulai Sesi
session_start();

//Koneksi ke Database
include 'koneksi.php';

//Jika Tombol Login di Tekan
if (isset($_POST['btn_login'])){
    //Panggil semua field pada form (name)
    $username = $_POST ['username'];
    $password = $_POST ['password'];

    //cocokkan isi field dengan database (tb_pengguna)
    $cek_user = mysqli_query($koneksi, "SELECT * FROM tb_user WHERE username = '$username' AND password = '$password'");

    //Jika cocok
    if (mysqli_num_rows($cek_user) > 0) {
        //ambil semua data user
        $data = mysqli_fetch_array($cek_user);

        //Menyimpan data ke dalam session
        $_SESSION ['id_user'] = $data ['id_user'];
        $_SESSION ['nama_lengkap'] = $data ['nama_lengkap'];
        $_SESSION ['role'] = $data ['role'];
        $_SESSION ['status_login'] = true;

        //arahkan ke halaman dashboard
        header("location: dashboard.php");

        //jika tidak cocok
    } else {
        //arahkan ke halaman login
        echo "<script>alert('Login Gagal! Username atau Password Salah');</script>";
    }
    
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengaduan Masyarakat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="dist/style.css">
</head>
<body class="bg-salmon d-flex align-items-center" style="height: 100vh;">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header bg-white text-center pt-4 pb-3">
                        <h3 class="font-weight-light">Login Sistem</h3>
                        <p class="text-muted mb-0">Layanan Pengaduan Masyarakat</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="" method="POST">
                            <div class="form-floating mb-3">
                                <input class="form-control" id="inputUsername" type="text" name="username" placeholder="Masukkan Username" required />
                                <label for="inputUsername">Username</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Masukkan Password" required />
                                <label for="inputPassword">Password</label>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary btn-lg" type="submit" name="btn_login">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="#" class="text-decoration-none">Belum punya akun? Daftar sebagai Masyarakat</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>