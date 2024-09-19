<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan data dari form login
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query SQL untuk memeriksa apakah username dan password cocok
    $query = "SELECT * FROM pelanggan WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($db, $query);

    if (mysqli_num_rows($result) == 1) {
        // Jika data ditemukan, simpan data ke dalam session
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_pelanggan'] = $row['id_pelanggan'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['nomor_kontak'] = $row['nomor_kontak'];
        $_SESSION['alamat'] = $row['alamat'];
        $_SESSION['username'] = $row['username'];

        // Redirect ke halaman dashboard atau halaman lain sesuai kebutuhan
        header("location: dashboard.php");
    } else {
        // Jika tidak ditemukan, beri pesan error
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pengguna | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Antrian </b>Makanan</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Masuk Untuk memulai sesi anda.</p>
                <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <form action="" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Username" name="username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4 float-right">
                            <button type="submit" class="btn btn-primary btn-block">Masuk</button>
                        </div>
                        <div class="col-4"></div>
                        <div class="col-4">
                            <a href="registrasi.php" class="btn btn-success btn-block">
                                Registrasi
                            </a>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.min.js"></script>
</body>

</html>