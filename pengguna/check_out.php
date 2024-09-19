<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

$query_pesanan = "SELECT p.id_pesanan, mm.nama_menu, mm.harga, p.jumlah_pesanan
                    FROM pesanan p
                    INNER JOIN makanan_minuman mm ON p.id_menu = mm.id_menu
                    WHERE p.id_pelanggan = {$_SESSION['id_pelanggan']} AND p.status = 'Pending'";
$result_pesanan = mysqli_query($db, $query_pesanan);

$total_bayar = 0;

include 'header.php';
include 'navbar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Check Out</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item active">Check Out</li>
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
                            <?php if (mysqli_num_rows($result_pesanan) > 0) { ?>
                                <form method="post" action="proses_checkout.php" enctype="multipart/form-data">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Menu</th>
                                                <th>Harga</th>
                                                <th>Jumlah Pesanan</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($row_pesanan = mysqli_fetch_assoc($result_pesanan)) { ?>
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="pesanan_id[]" value="<?php echo $row_pesanan['id_pesanan']; ?>" onchange="calculateTotal()">
                                                    </td>
                                                    <td><?php echo $row_pesanan['nama_menu']; ?></td>
                                                    <td><?php echo $row_pesanan['harga']; ?></td>
                                                    <td><?php echo $row_pesanan['jumlah_pesanan']; ?></td>
                                                    <td><?php echo $row_pesanan['harga'] * $row_pesanan['jumlah_pesanan']; ?></td>
                                                    <input type="hidden" name="total_bayar_<?php echo $row_pesanan['id_pesanan']; ?>" value="<?php echo $row_pesanan['harga'] * $row_pesanan['jumlah_pesanan']; ?>">
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td colspan="4"><strong>Total Bayar</strong></td>
                                                <td><strong><span id="totalBayar"><?php echo $total_bayar; ?></span></strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-group">
                                        <label for="bukti_pembayaran">Unggah Bukti Pembayaran</label>
                                        <input type="file" class="form-control-file" id="bukti_pembayaran" name="bukti_pembayaran" required>
                                    </div>
                                    <input type="hidden" name="total_bayar" id="totalBayarInput" value="<?php echo $total_bayar; ?>">
                                    <button type="submit" class="btn btn-primary">Check Out</button>
                                </form>
                            <?php } else { ?>
                                <div class="alert alert-info" role="alert">
                                    Tidak ada pesanan yang sedang diproses.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>

<script>
    function calculateTotal() {
        var checkboxes = document.getElementsByName('pesanan_id[]');
        var totalBayar = 0;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                var row = checkboxes[i].parentNode.parentNode;
                var harga = parseFloat(row.cells[2].innerText);
                var jumlah = parseInt(row.cells[3].innerText);
                totalBayar += harga * jumlah;
            }
        }

        document.getElementById('totalBayar').innerText = totalBayar;
        document.getElementById('totalBayarInput').value = totalBayar;
    }
</script>