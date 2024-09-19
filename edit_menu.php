<?php
session_start();
$title = "Edit Menu Makanan dan Minuman";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID menu dari parameter URL
$id_menu = $_GET['id_menu'];

// Ambil data menu dari database
$query_menu = "SELECT * FROM makanan_minuman WHERE id_menu = $id_menu";
$result_menu = mysqli_query($db, $query_menu);
$menu = mysqli_fetch_assoc($result_menu);

// Proses logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Proses edit menu jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_menu = $_POST['nama_menu'];
    $jenis = $_POST['jenis'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $gambar_temp = $_FILES['gambar']['tmp_name'];

    // Jika gambar tidak diunggah, gunakan gambar yang sudah ada
    if (empty($gambar)) {
        $gambar = $menu['gambar'];
    } else {
        $target_dir = "pengguna/gambar_makanan/";
        $target_file = $target_dir . basename($gambar);

        // Pindahkan file gambar yang diunggah ke folder tujuan
        if (move_uploaded_file($gambar_temp, $target_file)) {
            // Jika berhasil diunggah, hapus gambar lama (opsional)
            if ($menu['gambar'] && file_exists($target_dir . $menu['gambar'])) {
                unlink($target_dir . $menu['gambar']);
            }
        } else {
            $error_message = "Gagal mengunggah gambar. Silakan coba lagi.";
        }
    }

    // Lakukan query untuk memperbarui data menu
    $query_update = "UPDATE makanan_minuman SET 
                        nama_menu = '$nama_menu', 
                        jenis = '$jenis', 
                        harga = '$harga', 
                        deskripsi = '$deskripsi', 
                        gambar = '$gambar' 
                     WHERE id_menu = $id_menu";

    if (mysqli_query($db, $query_update)) {
        $_SESSION['success_message'] = "Menu berhasil diperbarui.";
        header("Location: makanan_minuman.php");
        exit();
    } else {
        $error_message = "Gagal memperbarui menu. Silakan coba lagi.";
    }
}
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Menu Makanan dan Minuman</h1>
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
                            <h3 class="card-title">Form Edit Menu</h3>
                        </div>
                        <form role="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id_menu=' . $id_menu; ?>" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama_menu">Nama Menu</label>
                                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" value="<?php echo $menu['nama_menu']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jenis">Jenis</label>
                                    <select class="form-control" id="jenis" name="jenis" required>
                                        <option value="makanan" <?php if ($menu['jenis'] == 'makanan') echo 'selected'; ?>>Makanan</option>
                                        <option value="minuman" <?php if ($menu['jenis'] == 'minuman') echo 'selected'; ?>>Minuman</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" class="form-control" id="harga" name="harga" value="<?php echo $menu['harga']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo $menu['deskripsi']; ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="gambar">Unggah Gambar</label>
                                    <input type="file" class="form-control" id="gambar" name="gambar">
                                    <small>Biarkan kosong jika tidak ingin mengganti gambar.</small>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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
