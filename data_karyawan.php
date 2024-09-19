<?php
session_start();
$title = "Data Karyawan";

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
                        <li class="breadcrumb-item active">Data Pegawai</li>
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
                            <h5>List Data Pegawai</h5>
                            <?php
                            if (isset($_SESSION['notification'])) {
                                echo '<div class="alert alert-success">' . $_SESSION['notification'] . '</div>';
                                unset($_SESSION['notification']); // Hapus notifikasi setelah ditampilkan
                            }
                            ?>
                            <a href="tambah_pegawai.php" class="btn btn-success mt-3"><i class="fas fa-plus-square"> Tambah Pegawai</i></a>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Username</th>
                                        <th scope="col">Katasandi</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Role</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $query_admin = mysqli_query($db, "SELECT * FROM admin");
                                    while ($data_admin = mysqli_fetch_array($query_admin)) { ?>
                                        <tr>
                                            <th><?php echo $no; ?></th>
                                            <td><?php echo $data_admin['username']; ?></td>
                                            <td><?php echo $data_admin['password']; ?></td>
                                            <td><?php echo $data_admin['nama']; ?></td>
                                            <td><?php echo $data_admin['role']; ?></td>
                                            <td class="text-center">
                                                <a href="edit_pegawai.php?id_admin=<?php echo $data_admin['id_admin']; ?>" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                <a href="delete_pegawai.php?id_admin=<?php echo $data_admin['id_admin']; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?');"><i class="fas fa-trash"></i></a>
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