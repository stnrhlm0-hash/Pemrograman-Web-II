
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Data Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Form Input Data Mahasiswa</h2>

    <form action="action-input-data.php" method="POST">

        <label>ID Mahasiswa / NIM</label>
        <input type="text" name="id_mahasiswa"
               maxlength="15" required>

        <label>Nama</label>
        <input type="text" name="nama"
               maxlength="100" required>

        <label>Jurusan</label>
        <select name="jurusan" required>
            <option value="">- Pilih Jurusan -</option>
            <option value="Teknik Komputer">Teknik Komputer</option>
            <option value="Teknik Informatika">Teknik Informatika</option>
            <option value="Teknik Mesin">Teknik Mesin</option>
            <option value="Teknik Elektro">Teknik Elektro</option>
            <option value="Komputer Akuntansi">Komputer Akuntansi</option>
        </select>

        <label>Alamat</label>
        <input type="text" name="alamat"
               maxlength="150" required>

        <label>No. Telepon</label>
        <input type="text" name="telepon"
               maxlength="15" required>

        <button type="submit" name="Submit" value="Submit">
            Submit
        </button>

        <button type="reset" class="cancel">
            Cancel
        </button>

    </form>
</div>

</body>
</html>
