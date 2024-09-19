<?php
session_start();
$title = "Data Pelanggan";

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
                        <li class="breadcrumb-item active">Data Pelanggan</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md">
                    <div class="card ">
                        <div class="card-body">
                            <h5>List Data Pelanggan</h5>
                            <?php
                            if (isset($_SESSION['notification'])) {
                                echo '<div class="alert alert-danger">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            }
                            ?>
                            <?php
                            if (isset($_SESSION['succesdeletes_message'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
                                unset($_SESSION['success_message']); // Hapus pesan sukses setelah ditampilkan
                            }
                            ?>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Nomor</th>
                                        <th scope="col">Alamat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_admin = mysqli_query($db, "SELECT * FROM pelanggan");
                                    while ($data_admin = mysqli_fetch_array($query_admin)) { ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <td><?php echo $data_admin['username']; ?></td>
                                            <td><?php echo $data_admin['nama']; ?></td>
                                            <td><?php echo $data_admin['nomor_kontak']; ?></td>
                                            <td><?php echo $data_admin['alamat']; ?></td>
                                            <td class="text-center">
                                                <a href="delete_pelanggan.php?id_pelanggan=<?php echo $data_admin['id_pelanggan']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                    <?php
                                        $no++;
                                    }
                                    ?>
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
