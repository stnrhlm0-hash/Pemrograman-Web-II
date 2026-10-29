
<?php
$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Mengaktifkan database
mysqli_select_db($link, "lat_dbase");

// Membuat tabel
$sql = "CREATE TABLE IF NOT EXISTS tbl_mhs (
    mhsID INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (mhsID),
    FirstName VARCHAR(15),
    LastName VARCHAR(15),
    Age INT
)";

if (mysqli_query($link, $sql)) {
    echo "Tabel tbl_mhs berhasil dibuat atau sudah tersedia<br>";
} else {
    die("Gagal membuat tabel: " . mysqli_error($link));
}

// Input data mahasiswa
$sql = "INSERT INTO tbl_mhs (FirstName, LastName, Age)
        SELECT 'Anjar', 'Prabowo', 25
        WHERE NOT EXISTS (
            SELECT 1 FROM tbl_mhs
            WHERE FirstName = 'Anjar'
            AND LastName = 'Prabowo'
        )";

if (mysqli_query($link, $sql)) {
    echo "Data Anjar Prabowo berhasil diproses";
} else {
    echo "Gagal memasukkan data: " . mysqli_error($link);
}

mysqli_close($link);
?>
