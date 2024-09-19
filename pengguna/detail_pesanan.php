<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

// Ambil daftar ID pesanan yang dipilih
$pesanan_id_list = isset($_POST['pesanan_id']) ? $_POST['pesanan_id'] : array();

// Jika tidak ada pesanan yang dipilih, kembalikan ke halaman pesanan.php
if (empty($pesanan_id_list)) {
    header("Location: pesanan.php");
    exit();
}

// Query untuk mendapatkan detail pesanan berdasarkan ID yang dipilih
$query_pesanan = "SELECT p.*, mm.nama_menu, mm.harga
                    FROM pesanan p
                    INNER JOIN makanan_minuman mm ON p.id_menu = mm.id_menu
                    WHERE p.id_pesanan IN (" . implode(",", $pesanan_id_list) . ")";
$result_pesanan = mysqli_query($db, $query_pesanan);

// Inisialisasi total bayar
$total_bayar = 0;

include 'header.php';
include 'navbar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Detail Pesanan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="pesanan.php">Pesanan</a></li>
                        <li class="breadcrumb-item active">Detail Pesanan</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Detail Pesanan</h5>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Harga</th>
                                        <th>Jumlah Pesanan</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)) { ?>
                                        <tr>
                                            <td><?php echo $row_pesanan['nama_menu']; ?></td>
                                            <td><?php echo $row_pesanan['harga']; ?></td>
                                            <td><?php echo $row_pesanan['jumlah_pesanan']; ?></td>
                                            <td><?php echo $row_pesanan['harga'] * $row_pesanan['jumlah_pesanan']; ?></td>
                                        </tr>
                                        <?php
                                        // Hitung total bayar
                                        $total_bayar += $row_pesanan['harga'] * $row_pesanan['jumlah_pesanan'];
                                        ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <p>Total Bayar: <?php echo $total_bayar; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
