<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$con) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "DELETE FROM tbl_mhs
        WHERE LastName = 'Prabowo'";

if (mysqli_query($con, $sql)) {
    echo "Data mahasiswa dengan LastName Prabowo berhasil dihapus.";
} else {
    echo "Gagal menghapus data: " . mysqli_error($con);
}

mysqli_close($con);
?>