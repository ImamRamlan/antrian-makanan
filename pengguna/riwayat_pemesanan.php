<?php
session_start();
$title = "Riwayat Checkout";
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
                    <h1 class="m-0">Riwayat Checkout</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Riwayat Checkout</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row">
                <?php
                $id_pelanggan = $_SESSION['id_pelanggan'];
                $query_checkout = mysqli_query($db, "SELECT co.*, mm.nama_menu, mm.gambar
                                                        FROM check_out co
                                                        INNER JOIN pesanan p ON co.id_pesanan = p.id_pesanan
                                                        INNER JOIN makanan_minuman mm ON p.id_menu = mm.id_menu
                                                        WHERE p.id_pelanggan = $id_pelanggan");

                if (mysqli_num_rows($query_checkout) > 0) {
                    while ($data_checkout = mysqli_fetch_array($query_checkout)) {
                ?>
                        <div class="col-md-4">
                            <div class="card mb-4 shadow-sm">
                                <img src="gambar_makanan/<?php echo $data_checkout['gambar']; ?>" class="card-img-top" alt="<?php echo $data_checkout['nama_menu']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $data_checkout['nama_menu']; ?></h5>
                                    <p class="card-text">Total Bayar: Rp<?php echo number_format($data_checkout['total_bayar'], 0, ',', '.'); ?></p>
                                    <p class="card-text">Status Checkout: <?php echo $data_checkout['status_checkout']; ?></p>
                                    <p class="card-text">Tanggal Checkout: <?php echo date('d-m-Y', strtotime($data_checkout['tanggal_checkout'])); ?></p>
                                    <p class="card-text">Waktu Checkout: <?php echo date('H:i:s', strtotime($data_checkout['waktu_checkout'])); ?></p>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<div class="col-md-12"><div class="alert alert-info">Tidak ada riwayat checkout.</div></div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
