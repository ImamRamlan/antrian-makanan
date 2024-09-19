<?php
$db = mysqli_connect("localhost", "root", "", "db_antrian");

if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
?>
