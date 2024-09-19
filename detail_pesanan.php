<?php
session_start();
$title = "Detail Pesanan";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil nama_transaksi dari URL
if (isset($_GET['nama_transaksi'])) {
    $nama_transaksi = $_GET['nama_transaksi'];

    // Query untuk mendapatkan data pesanan berdasarkan nama_transaksi
    $query_pesanan = "SELECT p.id_pesanan, pelanggan.nama AS nama_pelanggan, p.waktu_pesan, makanan_minuman.nama_menu, p.status, p.jumlah_pesanan, co.nama_transaksi
                      FROM pesanan p
                      INNER JOIN pelanggan ON p.id_pelanggan = pelanggan.id_pelanggan
                      INNER JOIN makanan_minuman ON p.id_menu = makanan_minuman.id_menu
                      INNER JOIN check_out co ON p.id_pesanan = co.id_pesanan
                      WHERE co.nama_transaksi = '$nama_transaksi'";
    $result_pesanan = mysqli_query($db, $query_pesanan);

    // Ambil data pesanan jika ada
    $pesananList = [];
    if ($result_pesanan && mysqli_num_rows($result_pesanan) > 0) {
        while ($row = mysqli_fetch_assoc($result_pesanan)) {
            $pesananList[] = $row;
        }
    } else {
        // Tampilkan pesan jika tidak ada pesanan dengan nama transaksi tersebut
        echo '<div class="alert alert-warning" role="alert">Pesanan tidak ditemukan dengan nama transaksi ' . $nama_transaksi . '</div>';
        // Hentikan eksekusi script
        exit();
    }
} else {
    // Redirect jika nama_transaksi tidak ada dalam URL
    header("Location: data_pesan.php");
    exit();
}
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="data_pesan.php">Data Pesanan</a></li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-title">Pesanan dengan Nama Transaksi <?php echo $nama_transaksi; ?></h1><br>
                            <h5>Nama Transaksi: <?php echo $pesananList[0]['nama_transaksi']; ?></h5>
                            <br>
                            <a href="data_pesan.php" class="btn btn-secondary">Kembali</a>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Pelanggan</th>
                                        <th>Waktu Pesan</th>
                                        <th>Nama Pesanan</th>
                                        <th>Status</th>
                                        <th>Jumlah Pesanan</th>
                                        <th>Nama Transaksi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pesananList as $pesanan) : ?>
                                        <tr>
                                            <td><?php echo $pesanan['nama_pelanggan']; ?></td>
                                            <td><?php echo $pesanan['waktu_pesan']; ?></td>
                                            <td><?php echo $pesanan['nama_menu']; ?></td>
                                            <td><?php echo $pesanan['status']; ?></td>
                                            <td><?php echo $pesanan['jumlah_pesanan']; ?></td>
                                            <td><?php echo $pesanan['nama_transaksi']; ?></td>
                                            <td class="text-center">
                                                <a href="delete_pesanan.php?id_pesanan=<?php echo $pesanan['id_pesanan']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
