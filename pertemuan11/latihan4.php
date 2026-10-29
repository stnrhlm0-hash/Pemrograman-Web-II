
<?php
$con = mysqli_connect("localhost", "root", "", "lat_dbase");

if (!$con) {
    die("Tidak dapat terhubung: " . mysqli_connect_error());
}

// Menyisipkan data Karina
$stmt = mysqli_prepare(
    $con,
    "INSERT INTO tbl_mhs (FirstName, LastName, Age)
     VALUES (?, ?, ?)"
);

$firstname = "Karina";
$lastname = "Suwandi";
$age = 29;

mysqli_stmt_bind_param(
    $stmt,
    "ssi",
    $firstname,
    $lastname,
    $age
);

if (mysqli_stmt_execute($stmt)) {
    echo "Data Karina berhasil ditambahkan<br>";
} else {
    echo "Gagal menambahkan data Karina<br>";
}

mysqli_stmt_close($stmt);

// Menyisipkan data Glenn
$stmt = mysqli_prepare(
    $con,
    "INSERT INTO tbl_mhs (FirstName, LastName, Age)
     VALUES (?, ?, ?)"
);

$firstname = "Glenn";
$lastname = "Gandari";
$age = 32;

mysqli_stmt_bind_param(
    $stmt,
    "ssi",
    $firstname,
    $lastname,
    $age
);

if (mysqli_stmt_execute($stmt)) {
    echo "Data Glenn berhasil ditambahkan";
} else {
    echo "Gagal menambahkan data Glenn";
}

mysqli_stmt_close($stmt);
mysqli_close($con);
?>
