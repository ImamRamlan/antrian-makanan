<?php
session_start();
$title = "Menu";
include 'koneksi.php';
include 'header.php';
include 'navbar.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}
?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Menu Makanan & Minuman</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <?php
                $query_menu = mysqli_query($db, "SELECT * FROM makanan_minuman");
                while ($data_menu = mysqli_fetch_array($query_menu)) { ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="gambar_makanan/<?php echo $data_menu['gambar']; ?>" class="card-img-top" alt="<?php echo $data_menu['nama_menu']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $data_menu['nama_menu']; ?></h5>
                                <p class="card-text">Rp<?php echo number_format($data_menu['harga'], 0, ',', '.'); ?></p>
                                <p class="card-text"><?php echo nl2br($data_menu['deskripsi']); ?></p> <!-- Menampilkan deskripsi -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="buat_pesanan.php?id_menu=<?php echo $data_menu['id_menu']; ?>" class="btn btn-sm btn-outline-primary">Pesan Sekarang</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
