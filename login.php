<?php
// Memasukkan koneksi ke database
require_once("koneksi.php");

// Mulai sesi
session_start();

// Proses form saat dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk memeriksa keberadaan username dan password dalam database
    $query = "SELECT * FROM admin WHERE username='$username' AND password='$password'";
    $result = mysqli_query($db, $query);

    // Periksa apakah hasil query mengembalikan baris data
    if (mysqli_num_rows($result) == 1) {
        // Jika ditemukan, simpan data ke dalam sesi
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id_admin'] = $row['id_admin'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['password'] = $row['password'];
        $_SESSION['nama'] = $row['nama'];
        $_SESSION['role'] = $row['role'];

        // Redirect ke halaman utama atau halaman berikutnya
        header("Location: halaman_utama.php");
        exit();
    } else {
        // Jika tidak ditemukan, tampilkan pesan kesalahan
        $error = "Username atau password salah.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Antrian</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('background_login.jpeg'); /* Ganti dengan path ke gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Masuk | Karyawan</h3>
                    </div>
                    <div class="card-body">
                        <p class="text-center text-muted">Masuk untuk memulai sesi Anda.</p>
                        <?php if(isset($error)) { ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $error; ?>
                            </div>
                        <?php } ?>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" id="username" name="username" required placeholder="Masukkan Username..">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" id="password" name="password" required placeholder="Masukkan Kata Sandi..">
                            </div>
                            <button type="submit" class="btn btn-success">Masuk</button>
                            <span class="text-muted">Lupa sandi? Konfirmasi ke owner.</span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
