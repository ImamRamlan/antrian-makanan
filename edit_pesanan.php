<?php
session_start();
$title = "Edit Pesanan";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID pesanan dari URL
$id_pesanan = $_GET['id_pesanan'];

// Proses form ketika data dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $tanggal_pesan = $_POST['tanggal_pesan'];
    $waktu_pesan = $_POST['waktu_pesan'];
    $status = $_POST['status'];

    // Query untuk mengupdate data pesanan
    $query = "UPDATE pesanan SET 
              id_pelanggan = '$id_pelanggan', 
              tanggal_pesan = '$tanggal_pesan', 
              waktu_pesan = '$waktu_pesan', 
              status = '$status' 
              WHERE id_pesanan = '$id_pesanan'";

    if (mysqli_query($db, $query)) {
        $_SESSION['success_message'] = "Pesanan berhasil diperbarui.";
        header("Location: data_pesan.php");
        exit();
    } else {
        $error_message = "Error: " . mysqli_error($db);
    }
}

// Query untuk mengambil data pesanan berdasarkan ID
$query_pesanan = "SELECT * FROM pesanan WHERE id_pesanan = '$id_pesanan'";
$result_pesanan = mysqli_query($db, $query_pesanan);
$data_pesanan = mysqli_fetch_assoc($result_pesanan);

// Query untuk mengambil data pelanggan
$pelanggan_query = "SELECT * FROM pelanggan";
$pelanggan_result = mysqli_query($db, $pelanggan_query);
?>
<?php include 'sidebar.php'; ?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit Pesanan</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">Edit Pesanan</li>
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
                            <h5>Form Edit Pesanan</h5>
                            <?php
                            if (isset($error_message)) {
                                echo '<div class="alert alert-danger">' . $error_message . '</div>';
                            }
                            ?>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="id_pelanggan">Nama Pelanggan</label>
                                    <select class="form-control" id="id_pelanggan" name="id_pelanggan" required>
                                        <option value="">Pilih Pelanggan</option>
                                        <?php while ($row = mysqli_fetch_assoc($pelanggan_result)) : ?>
                                            <option value="<?php echo $row['id_pelanggan']; ?>" <?php echo $row['id_pelanggan'] == $data_pesanan['id_pelanggan'] ? 'selected' : ''; ?>>
                                                <?php echo $row['nama']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_pesan">Tanggal Pesan</label>
                                    <input type="date" class="form-control" id="tanggal_pesan" name="tanggal_pesan" value="<?php echo $data_pesanan['tanggal_pesan']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="waktu_pesan">Waktu Pesan</label>
                                    <input type="time" class="form-control" id="waktu_pesan" name="waktu_pesan" value="<?php echo $data_pesanan['waktu_pesan']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Pending" <?php echo $data_pesanan['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Diproses" <?php echo $data_pesanan['status'] == 'Diproses' ? 'selected' : ''; ?>>Diproses</option>
                                        <option value="Selesai" <?php echo $data_pesanan['status'] == 'Selesai' ? 'selected' : ''; ?>>Selesai</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary btn-round">Update Pesanan</button>
                                <a href="data_pesan.php" class="btn btn-secondary btn-round">Kembali</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php include 'footer.php'; ?>
