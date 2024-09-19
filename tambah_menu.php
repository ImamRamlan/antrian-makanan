<?php
session_start();
$title = "Tambah Menu Makanan dan Minuman";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Proses tambah menu jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['nama_menu'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];

    // Tentukan lokasi penyimpanan file
    $target_dir = "pengguna/gambar_makanan/";
    $target_file = $target_dir . basename($gambar);

    // Lakukan validasi atau sanitasi data jika diperlukan

    // Proses upload file
    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
        // Lakukan query untuk menambahkan data menu baru
        $query_insert = mysqli_query($db, "INSERT INTO makanan_minuman (nama_menu, jenis, harga, deskripsi, gambar) VALUES ('$nama_menu', '$jenis', '$harga', '$deskripsi', '$gambar')");
        if ($query_insert) {
            $_SESSION['success_message'] = "Menu berhasil ditambahkan.";
            header("Location: makanan_minuman.php");
            exit();
        } else {
            $error_message = "Gagal menambahkan menu. Silakan coba lagi.";
        }
    } else {
        $error_message = "Gagal mengunggah gambar. Silakan coba lagi.";
    }
}
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Tambah Menu Makanan dan Minuman</h1>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Tambah Menu</h3>
                        </div>
                        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_menu">Nama Menu</label>
                                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control" id="jenis" name="jenis" required>
                                        <option value="makanan">Makanan</option>
                                        <option value="minuman">Minuman</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control" id="harga" name="harga" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Unggah Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar" required>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Tambah Menu</button>
                                <a href="makanan_minuman.php" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
