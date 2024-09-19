<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah ID menu diberikan
if (isset($_GET['id_menu'])) {
    $id_menu = $_GET['id_menu'];

    // Ambil data menu dari database untuk mendapatkan nama file gambar
    $query_select = "SELECT gambar FROM makanan_minuman WHERE id_menu = $id_menu";
    $result_select = mysqli_query($db, $query_select);
    $menu = mysqli_fetch_assoc($result_select);

    // Query untuk menghapus data menu berdasarkan ID
    $query_delete = "DELETE FROM makanan_minuman WHERE id_menu = $id_menu";

    try {
        if (mysqli_query($db, $query_delete)) {
            // Jika gambar ada, hapus file gambar dari server
            if ($menu['gambar'] && file_exists("pengguna/gambar_makanan/" . $menu['gambar'])) {
                unlink("pengguna/gambar_makanan/" . $menu['gambar']);
            }

            $_SESSION['delete_message'] = "Menu berhasil dihapus.";
        } else {
            throw new Exception("Pesanan sedang digunakan diharap hapus diwaktu lain.");
        }
    } catch (Exception $e) {
        $_SESSION['notification'] = "Error: " . $e->getMessage();
    }
} else {
    $_SESSION['notification'] = "ID Menu tidak diberikan.";
}

// Redirect ke halaman makanan_minuman.php
header("Location: makanan_minuman.php");
exit();
?>
