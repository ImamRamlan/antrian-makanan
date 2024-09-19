<?php
session_start();
$title = "Data Makanan dan Minuman";

include 'koneksi.php';
include 'header.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Proses logout jika tombol logout diklik
if (isset($_POST['logout'])) {
    // Hapus semua variabel sesi
    session_unset();

    // Hancurkan sesi
    session_destroy();

    // Redirect ke halaman login
    header("Location: login.php");
    exit();
}
if (isset($_GET['search'])) {
    $keyword = $_GET['search'];
    $query_menu = mysqli_query($db, "SELECT * FROM makanan_minuman WHERE nama_menu LIKE '%$keyword%'");
} else {
    $query_menu = mysqli_query($db, "SELECT * FROM makanan_minuman");
}
?>
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
                        <li class="breadcrumb-item active">Data Makanan dan Minuman</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Menu Makanan dan Minuman</h3>
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
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12 order-2 order-md-1">
                        <div class="row">
                            <div class="col-12">
                                <h4>Daftar Makanan dan Minuman</h4>
                                <form action="" method="GET" class="mb-3">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Cari berdasarkan nama menu" name="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="submit">Cari</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-sm-6">
                                    <a href="tambah_menu.php" class="btn btn-primary">Tambah Menu + </a>
                                </div><!-- /.col --><Br>
                                <?php
                                if (isset($_SESSION['success_message'])) {
                                    echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                    unset($_SESSION['success_message']); // Hapus pesan sukses setelah ditampilkan
                                }
                                ?>
                                <?php
                                if (isset($_SESSION['delete'])) {
                                    echo '<div class="alert alert-danger">' . $_SESSION['delete'] . '</div>';
                                    unset($_SESSION['delete']); // Hapus pesan sukses setelah ditampilkan
                                }
                                ?>
                                <div class="row">
                                    <?php
                                    // Pagination
                                    $limit = 5; // Jumlah data per halaman
                                    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Halaman saat ini
                                    $start = ($page - 1) * $limit; // Batas awal query

                                    // Query dengan limit
                                    $query_menu = mysqli_query($db, "SELECT * FROM makanan_minuman LIMIT $start, $limit");
                                    while ($data_menu = mysqli_fetch_array($query_menu)) { ?>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <img src="pengguna/gambar_makanan/<?php echo $data_menu['gambar']; ?>" class="card-img-top" alt="...">
                                                <div class="card-body">
                                                    <h4 class="card-title"><b><?php echo $data_menu['nama_menu']; ?></b></h4>
                                                    <p class="card-text"><?php echo $data_menu['deskripsi']; ?></p>
                                                    <p class="card-text">Rp.<?php echo $data_menu['harga']; ?></p>
                                                    <a href="edit_menu.php?id_menu=<?php echo $data_menu['id_menu']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="delete_menu.php?id_menu=<?php echo $data_menu['id_menu']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>

                                <!-- Pagination links -->
                                <?php
                                $result_pagination = mysqli_query($db, "SELECT COUNT(id_menu) AS total FROM makanan_minuman");
                                $data_pagination = mysqli_fetch_assoc($result_pagination);
                                $total_pages = ceil($data_pagination['total'] / $limit); // Total halaman

                                // Tampilkan link halaman
                                echo "<ul class='pagination justify-content-center'>";
                                for ($i = 1; $i <= $total_pages; $i++) {
                                    echo "<li class='page-item'><a class='page-link' href='makanan_minuman.php?page=" . $i . "'>" . $i . "</a></li>";
                                }
                                echo "</ul>";
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

    </section>
</div>
<?php include 'footer.php'; ?>