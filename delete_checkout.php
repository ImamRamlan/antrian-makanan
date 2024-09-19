<?php
session_start();
include 'koneksi.php';

// Periksa apakah pengguna sudah login atau belum
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Periksa apakah id_checkout ada di URL
$id_checkout = isset($_GET['id_checkout']) ? $_GET['id_checkout'] : null;

if (!$id_checkout) {
    $_SESSION['notification'] = "ID detail pesanan tidak ditemukan.";
    header("Location: data_detail.php");
    exit();
}

// Ambil path foto pembayaran
$query_bukti_pembayaran = "SELECT bukti_pembayaran FROM check_out WHERE id_checkout = ?";
$stmt_bukti_pembayaran = $db->prepare($query_bukti_pembayaran);
$stmt_bukti_pembayaran->bind_param("i", $id_checkout);
$stmt_bukti_pembayaran->execute();
$stmt_bukti_pembayaran->store_result();
$stmt_bukti_pembayaran->bind_result($bukti_pembayaran);
$stmt_bukti_pembayaran->fetch();

// Tentukan path lengkap ke folder upload_pembayaran
$upload_folder = __DIR__ . 'pengguna/upload_pembayaran';

// Gabungkan path folder dengan nama file
$bukti_pembayaran_path = $upload_folder . $bukti_pembayaran;

// Hapus foto pembayaran jika ada
if ($bukti_pembayaran && file_exists($bukti_pembayaran_path)) {
    if (unlink($bukti_pembayaran_path)) {
        $_SESSION['delete_message'] = "Foto pembayaran berhasil dihapus.";
    } else {
        $_SESSION['notification'] = "Gagal menghapus foto pembayaran: Tidak dapat menghapus file.";
        header("Location: data_detail.php");
        exit();
    }
}

// Hapus detail pesanan dari database
$query_delete_detail = "DELETE FROM check_out WHERE id_checkout = ?";
$stmt_delete_detail = $db->prepare($query_delete_detail);
$stmt_delete_detail->bind_param("i", $id_checkout);

// Jalankan query delete
if ($stmt_delete_detail->execute()) {
    $_SESSION['delete_message'] = "Detail pesanan berhasil dihapus.";
} else {
    $_SESSION['notification'] = "Gagal menghapus detail pesanan.";
}

$stmt_delete_detail->close();
$db->close();

header("Location: data_detail.php");
exit();
?>
