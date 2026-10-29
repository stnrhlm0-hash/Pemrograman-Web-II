<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "artikel_db";

$connection = mysqli_connect(
    $dbhost,
    $dbuser,
    $dbpass,
    $dbname
);

if (!$connection) {
    die("Tidak dapat terhubung dengan database: "
        . mysqli_connect_error());
}

echo "Koneksi database artikel_db berhasil.";
?>