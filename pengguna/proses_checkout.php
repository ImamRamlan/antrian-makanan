<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_pelanggan'])) {
    header("Location: login_pelanggan.php");
    exit();
}

// Mengambil nilai maksimum dari kolom nama_transaksi
$query_max_transaksi = "SELECT MAX(CAST(SUBSTRING(nama_transaksi, 11) AS UNSIGNED)) AS max_transaksi FROM check_out";
$result_max_transaksi = mysqli_query($db, $query_max_transaksi);
$row_max_transaksi = mysqli_fetch_assoc($result_max_transaksi);
$max_transaksi = $row_max_transaksi['max_transaksi'];

// Jika tidak ada data transaksi sebelumnya, inisialisasi dengan 1
if (!$max_transaksi) {
    $max_transaksi = 0;
}

// Membuat atau mengambil nomor transaksi terakhir dari sesi
if (!isset($_SESSION['nomor_transaksi'])) {
    $_SESSION['nomor_transaksi'] = $max_transaksi + 1;
} else {
    $_SESSION['nomor_transaksi']++;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['bukti_pembayaran'])) {
        $ext = pathinfo($_FILES['bukti_pembayaran']['name'], PATHINFO_EXTENSION);
        $nama_file = uniqid('bukti_', true) . '.' . $ext;

        $target_dir = "upload_pembayaran/";
        $target_file = $target_dir . $nama_file;
        $uploadOk = 1;

        if (file_exists($target_file)) {
            $error = "Maaf, file bukti pembayaran sudah ada.";
            $uploadOk = 0;
        }

        if ($_FILES["bukti_pembayaran"]["size"] > 5000000) {
            $error = "Maaf, ukuran file bukti pembayaran terlalu besar.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $error = "Maaf, file bukti pembayaran gagal diupload.";
        } else {
            if (move_uploaded_file($_FILES["bukti_pembayaran"]["tmp_name"], $target_file)) {
                $tanggal_checkout = date("Y-m-d");
                $waktu_checkout = date("H:i:s");

                $query_checkout = "INSERT INTO check_out (id_pesanan, status_checkout, tanggal_checkout, waktu_checkout, bukti_pembayaran, nama_transaksi, total_bayar)
                                    VALUES ";
                $values = [];
                foreach ($_POST['pesanan_id'] as $pesanan_id) {
                    $total_bayar_per_pesanan = $_POST["total_bayar_$pesanan_id"];
                    $nama_transaksi = "Transaksi $_SESSION[nomor_transaksi]";
                    $values[] = "($pesanan_id, 'Proses Bayar', '$tanggal_checkout', '$waktu_checkout', '$nama_file', '$nama_transaksi', $total_bayar_per_pesanan)";
                }
                $query_checkout .= implode(", ", $values);
                mysqli_query($db, $query_checkout);

                $query_update_pesanan = "UPDATE pesanan SET status = 'Selesai' WHERE id_pesanan IN (" . implode(",", $_POST['pesanan_id']) . ")";
                mysqli_query($db, $query_update_pesanan);

                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Maaf, terjadi kesalahan saat mengupload file.";
            }
        }
    } else {
        $error = "Mohon unggah bukti pembayaran.";
    }
} else {
    header("Location: check_out.php");
    exit();
}
?>
