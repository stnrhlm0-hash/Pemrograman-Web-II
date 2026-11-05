
<?php
include "koneksi.php";

if (isset($_POST['Submit'])) {

    $id_mahasiswa = trim($_POST['id_mahasiswa']);
    $nama = trim($_POST['nama']);
    $jurusan = $_POST['jurusan'];
    $alamat = trim($_POST['alamat']);
    $telepon = trim($_POST['telepon']);

    // Validasi data kosong
    if (
        empty($id_mahasiswa) ||
        empty($nama) ||
        empty($jurusan) ||
        empty($alamat) ||
        empty($telepon)
    ) {
        echo "<script>
            alert('Data Harap Dilengkapi!');
            window.location='index.php';
        </script>";
        exit;
    }

    // Cek NIM di database
    $cek = mysqli_prepare(
        $koneksi,
        "SELECT id_mahasiswa FROM mahasiswa
         WHERE id_mahasiswa = ?"
    );

    mysqli_stmt_bind_param($cek, "s", $id_mahasiswa);
    mysqli_stmt_execute($cek);
    mysqli_stmt_store_result($cek);

    if (mysqli_stmt_num_rows($cek) > 0) {
        echo "<script>
            alert('NIM sudah dipakai! Silahkan ganti NIM lain.');
            window.location='index.php';
        </script>";
        exit;
    }

    // Memasukkan data ke tabel mahasiswa
    $query = mysqli_prepare(
        $koneksi,
        "INSERT INTO mahasiswa
        (id_mahasiswa, nama, jurusan, alamat, telepon)
        VALUES (?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $query,
        "sssss",
        $id_mahasiswa,
        $nama,
        $jurusan,
        $alamat,
        $telepon
    );

    if (mysqli_stmt_execute($query)) {
        echo "<script>
            alert('Input Data Mahasiswa Berhasil!');
            window.location='index.php';
        </script>";
    } else {
        echo "Input Data Mahasiswa Gagal: "
             . mysqli_error($koneksi);
    }

    mysqli_stmt_close($cek);
    mysqli_stmt_close($query);
    mysqli_close($koneksi);
}
?>
