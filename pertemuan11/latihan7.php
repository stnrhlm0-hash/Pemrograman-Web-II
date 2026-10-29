
<?php
$link = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$hasil = mysqli_query($link, "SELECT * FROM tbl_mhs");

if (!$hasil) {
    die("Query gagal: " . mysqli_error($link));
}

$hit = mysqli_num_rows($hasil);

echo "Jumlah record: " . $hit;

mysqli_close($link);
?>
