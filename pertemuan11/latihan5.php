
<?php
$link = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$hasil = mysqli_query($link, "SELECT * FROM tbl_mhs");

if (!$hasil) {
    die("Query gagal: " . mysqli_error($link));
}

while ($data = mysqli_fetch_row($hasil)) {
    echo $data[0] . " ";
    echo htmlspecialchars($data[1]) . " ";
    echo htmlspecialchars($data[2]) . " ";
    echo $data[3] . "<br>";
}

mysqli_close($link);
?>
