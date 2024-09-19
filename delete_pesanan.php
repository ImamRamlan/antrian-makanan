<?php
session_start();

include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah parameter id_pesanan telah diterima dari URL
if (isset($_GET['id_pesanan'])) {
    $id_pesanan = $_GET['id_pesanan'];

    // Periksa apakah ada catatan dalam tabel check_out yang terkait dengan pesanan ini
    $query_check_out = "SELECT * FROM check_out WHERE id_pesanan = '$id_pesanan'";
    $result_check_out = mysqli_query($db, $query_check_out);

    if (mysqli_num_rows($result_check_out) > 0) {
        // Jika ada catatan dalam tabel check_out yang terkait, tampilkan pesan kesalahan
        $_SESSION['error_message'] = "Pesanan masih dalam proses check-out. Harap hapus check-out terlebih dahulu.";
        header("Location: data_pesan.php");
        exit();
    } else {
        // Jika tidak ada catatan dalam tabel check_out yang terkait, lanjutkan untuk menghapus pesanan
        $query = "DELETE FROM pesanan WHERE id_pesanan = '$id_pesanan'";
        $result = mysqli_query($db, $query);

        if ($result) {
            // Pesanan berhasil dihapus, redirect kembali ke halaman data_pesan.php dengan pesan sukses
            $_SESSION['success_message'] = "Pesanan berhasil dihapus";
            header("Location: data_pesan.php");
            exit();
        } else {
            // Gagal menghapus pesanan, redirect kembali ke halaman data_pesan.php dengan pesan error
            $_SESSION['error_message'] = "Gagal menghapus pesanan";
            header("Location: data_pesan.php");
            exit();
        }
    }
} else {
    // Jika parameter id_pesanan tidak diterima dari URL, redirect kembali ke halaman data_pesan.php
    header("Location: data_pesan.php");
    exit();
}
?>
