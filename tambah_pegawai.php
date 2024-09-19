<?php
session_start();
include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus semua variabel sesi
    session_unset();

    // Hancurkan sesi
    session_destroy();

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Inisialisasi variabel pesan kesalahan
$error_message = "";

// Tangkap data dari formulir jika ada yang dikirimkan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $username = $_POST['username'];
    $password = $_POST['katasandi']; // Sesuaikan dengan nama input pada formulir
    $nama = $_POST['nama'];
    $role = $_POST['role'];

    // Validasi data
    if (empty($username) || empty($password) || empty($nama) || empty($role)) {
        $error_message = "Semua field harus diisi.";
    } else {
        // Periksa apakah username sudah ada di database
        $check_query = "SELECT * FROM admin WHERE username = '$username'";
        $check_result = mysqli_query($db, $check_query);
        if (mysqli_num_rows($check_result) > 0) {
            $error_message = "Username sudah digunakan. Silakan gunakan username lain.";
        } else {
            // Lakukan penyimpanan data ke dalam tabel admin
            $query = "INSERT INTO admin (username, password, nama, role) VALUES ('$username', '$password', '$nama', '$role')";
            $result = mysqli_query($db, $query);

            if ($result) {
                $_SESSION['notification'] = "Data karyawan berhasil ditambahkan.";
                header("Location: data_karyawan.php");
                exit();
            } else {
                $error_message = "Gagal menambahkan data karyawan: " . mysqli_error($db);
            }
        }
    }
}
?>

<?php include 'sidebar.php'; ?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Karyawan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card ">
                        <div class="card-body">
                            <h5>Tambah Data Karyawan</h5>
                            <?php
                            if (!empty($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            } elseif (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <a href="data_karyawan.php">Kembali</a>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                                <div class="form-group">
                                    <label for="katasandi">Katasandi:</label>
                                    <input type="password" class="form-control" id="katasandi" name="katasandi" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" name="nama" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="">Pilih Role</option>
                                        <option value="Admin" >Admin</option>
                                        <option value="Karyawan">Karyawan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Tambah Data</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
