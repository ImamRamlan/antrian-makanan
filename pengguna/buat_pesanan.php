<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

// Ambil ID menu dari URL
if (!isset($_GET['id_menu'])) {
    echo "ID menu tidak ditemukan.";
    exit();
}

$id_menu = $_GET['id_menu'];

// Ambil ID pelanggan dari sesi
$id_pelanggan = $_SESSION['id_pelanggan'];

// Jika form dikirim, proses pesanan
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $jumlah_pesanan = intval($_POST['jumlah']);
    
    // Buat pesanan baru di tabel pesanan
    $tanggal_pesan = date('Y-m-d');
    $waktu_pesan = date('H:i:s');
    $status = 'Pending';
    
    // Insert ke tabel pesanan
    $query_pesanan = "INSERT INTO pesanan (id_pelanggan, tanggal_pesan, waktu_pesan, status, jumlah_pesanan, id_menu) VALUES ('$id_pelanggan', '$tanggal_pesan', '$waktu_pesan', '$status', '$jumlah_pesanan', '$id_menu')";
    if (mysqli_query($db, $query_pesanan)) {
        // Redirect ke halaman check_out
        header("Location: check_out.php");
        exit();
    } else {
        echo "Error: " . $query_pesanan . "<br>" . mysqli_error($db);
    }
    mysqli_close($db);
    exit();
} else {
    // Ambil informasi menu untuk ditampilkan dalam form
    $query_menu = "SELECT * FROM makanan_minuman WHERE id_menu='$id_menu'";
    $result_menu = mysqli_query($db, $query_menu);
    $data_menu = mysqli_fetch_assoc($result_menu);
}

include 'header.php';
include 'navbar.php';
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pesan Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="menu.php">Menu</a></li>
                        <li class="breadcrumb-item active">Pesan Menu</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <img src="gambar_makanan/<?php echo $data_menu['gambar']; ?>" class="card-img-top" alt="<?php echo $data_menu['nama_menu']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $data_menu['nama_menu']; ?></h5>
                            <p class="card-text"><?php echo $data_menu['deskripsi']; ?></p>
                            <p class="card-text">Rp<?php echo number_format($data_menu['harga'], 0, ',', '.'); ?></p>
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
