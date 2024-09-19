<?php
session_start();
$title = "Detail Checkout | Antrian Makanan";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter id_checkout tersedia di URL
if (!isset($_GET['id_checkout']) || empty($_GET['id_checkout'])) {
    // Jika tidak ada, kembali ke halaman data pesanan
    header("Location: data_detail_pesanan.php");
    exit();
}

// Ambil id_checkout dari parameter URL
$id_checkout = $_GET['id_checkout'];

// Query untuk mendapatkan detail checkout berdasarkan id_checkout
$query = "SELECT c.id_checkout, c.id_pesanan, c.status_checkout, c.tanggal_checkout, c.waktu_checkout, c.total_bayar, c.bukti_pembayaran, p.id_pelanggan, p.jumlah_pesanan, mm.nama_menu, mm.harga 
          FROM check_out c
          INNER JOIN pesanan p ON c.id_pesanan = p.id_pesanan
          INNER JOIN makanan_minuman mm ON p.id_menu = mm.id_menu
          WHERE c.id_checkout = '$id_checkout'";
$result = mysqli_query($db, $query);

// Periksa apakah data ditemukan
if (mysqli_num_rows($result) == 0) {
    // Jika tidak ada data dengan id_checkout yang diberikan, kembali ke halaman data pesanan
    header("Location: data_detail_pesanan.php");
    exit();
}

// Ambil data checkout
$row = mysqli_fetch_assoc($result);

// Proses perubahan status checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['status_checkout'])) {
    $new_status = $_POST['status_checkout'];
    $query_update_status = "UPDATE check_out SET status_checkout = '$new_status' WHERE id_checkout = '$id_checkout'";
    mysqli_query($db, $query_update_status);
    // Refresh halaman untuk melihat perubahan status
    header("Location: detail_checkout.php?id_checkout=$id_checkout");
    exit();
}
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Checkout</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Detail Checkout</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <h5>Detail Data Checkout</h5>
                            <table class="table">
                                <tr>
                                    <th>ID Pesanan</th>
                                    <td><?php echo $row['id_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th>Nama Menu</th>
                                    <td><?php echo $row['nama_menu']; ?></td>
                                </tr>
                                <tr>
                                    <th>Harga Menu</th>
                                    <td><?php echo $row['harga']; ?></td>
                                </tr>
                                <tr>
                                    <th>Jumlah Pesanan</th>
                                    <td><?php echo $row['jumlah_pesanan']; ?></td>
                                </tr>
                                <tr>
                                    <th>Total Bayar</th>
                                    <td><?php echo $row['total_bayar']; ?></td>
                                </tr>
                                <tr>
                                    <th>Status Checkout</th>
                                    <td>
                                        <?php echo $row['status_checkout']; ?>
                                        <form method="post" class="mt-2">
                                            <input type="hidden" name="status_checkout" value="Belum Bayar">
                                            <button type="submit" class="btn btn-warning btn-sm">Belum Bayar</button>
                                        </form>
                                        <form method="post" class="mt-2">
                                            <input type="hidden" name="status_checkout" value="Proses">
                                            <button type="submit" class="btn btn-info btn-sm">Proses</button>
                                        </form>
                                        <form method="post" class="mt-2">
                                            <input type="hidden" name="status_checkout" value="Lunas">
                                            <button type="submit" class="btn btn-success btn-sm">Lunas</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Tanggal Checkout</th>
                                    <td><?php echo $row['tanggal_checkout']; ?></td>
                                </tr>
                                <tr>
                                    <th>Waktu Checkout</th>
                                    <td><?php echo $row['waktu_checkout']; ?></td>
                                </tr>
                                <tr>
                                    <th>Bukti Pembayaran</th>
                                    <td><img src="pengguna/upload_pembayaran/<?php echo $row['bukti_pembayaran']; ?>" class="img-fluid" alt="Bukti Pembayaran"></td>
                                </tr>
                            </table>
                            <a href="data_detail.php" class="btn btn-success">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
