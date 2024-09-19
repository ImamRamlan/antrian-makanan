<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ada parameter ID Admin yang diberikan
if (!isset($_GET['id_pelanggan']) || empty($_GET['id_pelanggan'])) {
    // Jika tidak ada, kembali ke halaman data_karyawan.php
    header("Location: data_pelanggan.php");
    exit();
}

// Tangkap ID Admin dari parameter URL
$id_pelanggan = $_GET['id_pelanggan'];

// Lakukan penghapusan data dari database
$query = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";
$result = mysqli_query($db, $query);

if ($result) {
    // Jika penghapusan berhasil, set notifikasi dan kembali ke halaman data_karyawan.php
    $_SESSION['notification'] = "Data Pelanggan berhasil dihapus.";
    header("Location: data_pelanggan.php");
    exit();
} else {
    // Jika terjadi kesalahan, tampilkan pesan kesalahan
    echo "Gagal menghapus data pelanggan: " . mysqli_error($db);
}
?>
