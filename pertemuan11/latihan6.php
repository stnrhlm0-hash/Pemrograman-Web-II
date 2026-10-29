
<?php
$link = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$hasil = mysqli_query($link, "SELECT * FROM tbl_mhs");

if (!$hasil) {
    die("Query gagal: " . mysqli_error($link));
}

while ($data = mysqli_fetch_array($hasil)) {
    echo htmlspecialchars($data['FirstName']) . " ";
    echo htmlspecialchars($data['LastName']) . " ";
    echo $data['Age'] . "<br>";
}

mysqli_close($link);
?>
