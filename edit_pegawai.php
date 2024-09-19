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

// Ambil ID karyawan dari parameter URL
if (!isset($_GET['id_admin']) || empty($_GET['id_admin'])) {
    // Jika ID tidak tersedia, redirect ke halaman data_karyawan.php
    header("Location: data_karyawan.php");
    exit();
}

// Tangkap ID karyawan
$id_admin = $_GET['id_admin'];

// Ambil data karyawan dari database berdasarkan ID
$query_admin = "SELECT * FROM admin WHERE id_admin = $id_admin";
$result_admin = mysqli_query($db, $query_admin);

// Periksa apakah data karyawan dengan ID yang diberikan ada atau tidak
if (mysqli_num_rows($result_admin) == 0) {
    // Jika tidak ada data dengan ID tersebut, redirect ke halaman data_karyawan.php
    header("Location: data_karyawan.php");
    exit();
}

// Ambil data karyawan
$data_admin = mysqli_fetch_assoc($result_admin);

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
    if (empty($username) || empty($nama) || empty($role)) {
        $error_message = "Semua field harus diisi.";
    } else {
        // Lakukan pembaruan data ke dalam tabel admin
        $query = "UPDATE admin SET username='$username', password='$password', nama='$nama', role='$role' WHERE id_admin=$id_admin";
        $result = mysqli_query($db, $query);

        if ($result) {
            $_SESSION['notification'] = "Data karyawan berhasil diperbarui.";
            header("Location: data_karyawan.php");
            exit();
        } else {
            $error_message = "Gagal memperbarui data karyawan: " . mysqli_error($db);
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
                        <li class="breadcrumb-item"><a href="data_karyawan.php">Data Karyawan</a></li>
                        <li class="breadcrumb-item active">Edit Pegawai</li>
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
                            <h5>Edit Data Pegawai</h5>
                            <?php
                            if (!empty($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <form action="<?php echo $_SERVER['PHP_SELF'] . '?id_admin=' . $id_admin; ?>" method="post">
                                <div class="form-group">
                                    <label for="username">Username:</label>
                                    <input type="text" class="form-control" id="username" name="username" value="<?php echo $data_admin['username']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="katasandi">Katasandi:</label>
                                    <input type="password" class="form-control" id="katasandi" name="katasandi" value="<?php echo $data_admin['password']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama">Nama:</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data_admin['nama']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="role">Role:</label>
                                    <select class="form-control" id="role" name="role" required>
                                        <option value="Admin" <?php if ($data_admin['role'] == 'Admin') echo 'selected'; ?>>Admin</option>
                                        <option value="Karyawan" <?php if ($data_admin['role'] == 'Karyawan') echo 'selected'; ?>>Karyawan</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary" name="submit">Simpan Perubahan</button>
                                <a href="data_karyawan.php" class="btn btn-secondary">Batal</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>
