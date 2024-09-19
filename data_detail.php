<?php
session_start();
$title = "Data Detail Checkout | Antrian Makanan";

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
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Data Detail Pesanan</li>
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
                            <h5>List Data Detail Pesanan</h5>
                            <?php
                            if (isset($_SESSION['delete_message'])) {
                                echo '<div class="alert alert-danger">' . $_SESSION['delete_message'] . '</div>';
                                unset($_SESSION['delete_message']); // Hapus notifikasi setelah ditampilkan
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['success_message'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); // Hapus pesan sukses setelah ditampilkan
                            }
                            ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">ID Pesanan</th>
                                        <th scope="col">Status Checkout</th>
                                        <th scope="col">Tanggal Checkout</th>
                                        <th scope="col">Waktu Checkout</th>
                                        <th scope="col">Total Bayar</th>
                                        <th scope="col">Bukti Pembayaran</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = mysqli_query($db, "SELECT * FROM check_out");
                                    $no = 1;
                                    while ($data = mysqli_fetch_assoc($query)) {
                                    ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo $data['id_pesanan']; ?></td>
                                            <td><?php echo $data['status_checkout']; ?></td>
                                            <td><?php echo $data['tanggal_checkout']; ?></td>
                                            <td><?php echo $data['waktu_checkout']; ?></td>
                                            <td><?php echo $data['total_bayar']; ?></td>
                                            <td><?php echo $data['bukti_pembayaran']; ?></td>
                                            <td class="text-center">
                                                <a href="delete_checkout.php?id_checkout=<?php echo $data['id_checkout']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                                                <a href="detail_checkout.php?id_checkout=<?php echo $data['id_checkout']; ?>" class="btn btn-info"><i class="fas fa-eye"></i> Detail</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
