
<?php
$conn = mysqli_connect("localhost", "root", "");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$dbname = "lat_dbase";

$sql = "CREATE DATABASE IF NOT EXISTS `$dbname`";

if (mysqli_query($conn, $sql)) {
    echo "Database $dbname berhasil dibuat atau sudah tersedia.";
} else {
    echo "Gagal membuat database: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
