<?php
session_start();
$title = "Data Pesanan";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Data Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Pesanan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card">
                        <div class="card-body">
                            <h5>List Data Pesan</h5>
                            <?php
                            // Tampilkan pesan kesalahan jika ada
                            if (isset($_SESSION['error_message'])) {
                                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error_message'] . '</div>';
                                unset($_SESSION['error_message']); // Hapus pesan kesalahan setelah ditampilkan
                            }
                            ?>
                            <?php
                            // Tampilkan pesan kesalahan jika ada
                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); // Hapus pesan kesalahan setelah ditampilkan
                            }
                            ?>
                            <ul class="list-group col-md-5">
                                <?php
                                // Ambil nama transaksi terkait dari tabel check_out
                                $query_transaksi = mysqli_query($db, "SELECT co.nama_transaksi
                                    FROM check_out co
                                    GROUP BY co.nama_transaksi
                                    ORDER BY co.nama_transaksi DESC LIMIT 5");

                                while ($data_transaksi = mysqli_fetch_assoc($query_transaksi)) {
                                    $nama_transaksi = $data_transaksi['nama_transaksi'];
                                ?>
                                    <a href="detail_pesanan.php?nama_transaksi=<?php echo $nama_transaksi; ?>" class="mt-3">
                                        <li class="list-group-item list-group-item-primary"><?php echo $nama_transaksi; ?></li>
                                    </a>
                                <?php } ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
