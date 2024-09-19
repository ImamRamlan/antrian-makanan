<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada parameter ID Admin yang diberikan
if (!isset($_GET['id_admin']) || empty($_GET['id_admin'])) {
    // Jika tidak ada, kembali ke halaman data_karyawan.php
    header("Location: data_karyawan.php");
    exit();
}

// Tangkap ID Admin dari parameter URL
$id_admin = $_GET['id_admin'];

// Lakukan penghapusan data dari database
$query = "DELETE FROM admin WHERE id_admin = $id_admin";
$result = mysqli_query($db, $query);

if ($result) {
    // Jika penghapusan berhasil, set notifikasi dan kembali ke halaman data_karyawan.php
    $_SESSION['notification'] = "Data karyawan berhasil dihapus.";
    header("Location: data_karyawan.php");
    exit();
} else {
    // Jika terjadi kesalahan, tampilkan pesan kesalahan
    echo "Gagal menghapus data karyawan: " . mysqli_error($db);
}
?>
