```php
<?php
include 'koneksi.php';

$pesan = "";

// Proses simpan data
if (isset($_POST['simpan'])) {
    $tgl_input = $_POST['tgl_input'];
    $kode = strtoupper(trim($_POST['kode']));
    $nama = trim($_POST['nama']);
    $jk = $_POST['jk'];
    $asal_sekolah = trim($_POST['asal_sekolah']);
    $pekerjaan_ortu = trim($_POST['pekerjaan_ortu']);
    $tempat_lahir = trim($_POST['tempat_lahir']);
    $tgl_lahir = $_POST['tgl_lahir'];

    $mat = (int) $_POST['mat'];
    $bing = (int) $_POST['bing'];
    $umum = (int) $_POST['umum'];

    $rata = ($mat + $bing + $umum) / 3;

    if ($rata >= 70) {
        $keterangan = "Lulus";
    } elseif ($rata >= 60) {
        $keterangan = "Cadangan";
    } else {
        $keterangan = "Tidak Lulus";
    }

    $kode_awal = substr($kode, 0, 1);

    if ($kode_awal == "A") {
        $tempat_tes = "Gedung A";
    } elseif ($kode_awal == "B") {
        $tempat_tes = "Gedung B";
    } elseif ($kode_awal == "V") {
        $tempat_tes = "Viktor";
    } else {
        $tempat_tes = "Tidak Diketahui";
    }

    if ($mat < 0 || $mat > 100 ||
        $bing < 0 || $bing > 100 ||
        $umum < 0 || $umum > 100) {
        $pesan = "Nilai harus berada di antara 0 sampai 100.";
    } else {
        $sql = "INSERT INTO pendaftar
            (tgl_input, kode, nama, jk, asal_sekolah,
             pekerjaan_ortu, tempat_lahir, tgl_lahir,
             mat, bing, umum, rata_rata, tempat_tes, keterangan)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "ssssssssiiidss",
            $tgl_input,
            $kode,
            $nama,
            $jk,
            $asal_sekolah,
            $pekerjaan_ortu,
            $tempat_lahir,
            $tgl_lahir,
            $mat,
            $bing,
            $umum,
            $rata,
            $tempat_tes,
            $keterangan
        );

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=berhasil");
            exit;
        } else {
            if (mysqli_stmt_errno($stmt) == 1062) {
                $pesan = "Kode pendaftaran sudah digunakan.";
            } else {
                $pesan = "Gagal menyimpan data pendaftar.";
            }
        }

        mysqli_stmt_close($stmt);
    }
}

// Pesan hasil penyimpanan
if (isset($_GET['status']) && $_GET['status'] == 'berhasil') {
    $pesan = "Data pendaftar berhasil disimpan!";
}

// Mengambil semua data pendaftar
$result = mysqli_query(
    $conn,
    "SELECT * FROM pendaftar ORDER BY id DESC"
);

// Menghitung rekap dari database
$rekap = mysqli_query(
    $conn,
    "SELECT
        COUNT(*) AS total,
        SUM(keterangan = 'Lulus') AS lulus,
        SUM(keterangan = 'Cadangan') AS cadangan,
        SUM(keterangan = 'Tidak Lulus') AS tidak_lulus
     FROM pendaftar"
);

$data_rekap = mysqli_fetch_assoc($rekap);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTS PHP - Pendaftaran Mahasiswa</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
            background: #f4f4f4;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        h2, h3 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 10px;
        }

        input[type=text],
        input[type=number],
        input[type=date] {
            width: 100%;
            box-sizing: border-box;
            padding: 9px;
            margin-top: 5px;
            margin-bottom: 10px;
        }

        .btn {
            background: blue;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        .btn:hover {
            background: darkblue;
        }

        .info {
            margin-top: 20px;
            padding: 15px;
            background: #eef;
            border-radius: 5px;
        }

        .pesan {
            padding: 12px;
            margin: 15px 0;
            background: #e0f2fe;
            border-radius: 5px;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 1000px;
        }

        th, td {
            border: 1px solid #777;
            padding: 9px;
            text-align: center;
        }

        th {
            background: #dbeafe;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .kosong {
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>FORM PENDAFTARAN MAHASISWA BARU</h2>

    <?php if ($pesan != ""): ?>
        <div class="pesan">
            <?= htmlspecialchars($pesan) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="index.php">

        <label>Tanggal Input</label>
        <input type="date" name="tgl_input" required>

        <label>Kode Pendaftaran</label>
        <input type="text" name="kode"
               placeholder="Contoh: A2" required>

        <label>Nama Pendaftar</label>
        <input type="text" name="nama" required>

        <label>Jenis Kelamin</label>
        <input type="radio" name="jk" value="Laki-Laki" required>
        Laki-Laki

        <input type="radio" name="jk" value="Perempuan">
        Perempuan

        <label>Asal Sekolah</label>
        <input type="text" name="asal_sekolah" required>

        <label>Pekerjaan Orang Tua</label>
        <input type="text" name="pekerjaan_ortu" required>

        <label>Tempat Lahir</label>
        <input type="text" name="tempat_lahir" required>

        <label>Tanggal Lahir</label>
        <input type="date" name="tgl_lahir" required>

        <label>Matematika</label>
        <input type="number" name="mat" min="0" max="100" required>

        <label>Bahasa Inggris</label>
        <input type="number" name="bing" min="0" max="100" required>

        <label>Umum</label>
        <input type="number" name="umum" min="0" max="100" required>

        <button type="submit" name="simpan" class="btn">
            SIMPAN
        </button>
    </form>

    <h3>TABEL DATA PENDAFTAR</h3>

    <div class="table-wrapper">
        <table>
            <tr>
                <th>No.</th>
                <th>Tanggal Input</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>JK</th>
                <th>Tempat, Tanggal Lahir</th>
                <th>Asal Sekolah</th>
                <th>Pekerjaan Ortu</th>
                <th>Tempat Tes</th>
                <th>Matematika</th>
                <th>B. Inggris</th>
                <th>Umum</th>
                <th>Rata-rata</th>
                <th>Keterangan</th>
            </tr>

            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['tgl_input']) ?></td>
                        <td><?= htmlspecialchars($row['kode']) ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['jk']) ?></td>
                        <td>
                            <?= htmlspecialchars($row['tempat_lahir']) ?>,
                            <?= htmlspecialchars($row['tgl_lahir']) ?>
                        </td>
                        <td><?= htmlspecialchars($row['asal_sekolah']) ?></td>
                        <td><?= htmlspecialchars($row['pekerjaan_ortu']) ?></td>
                        <td><?= htmlspecialchars($row['tempat_tes']) ?></td>
                        <td><?= $row['mat'] ?></td>
                        <td><?= $row['bing'] ?></td>
                        <td><?= $row['umum'] ?></td>
                        <td><?= number_format((float)$row['rata_rata'], 2) ?></td>
                        <td><?= htmlspecialchars($row['keterangan']) ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="14" class="kosong">
                        Belum ada data pendaftar.
                    </td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <div class="info">
        <h3>REKAP DATA PENDAFTAR</h3>
        <p>Jumlah Pendaftar:
            <b><?= $data_rekap['total'] ?? 0 ?></b>
        </p>
        <p>Jumlah Lulus:
            <b><?= $data_rekap['lulus'] ?? 0 ?></b>
        </p>
        <p>Jumlah Cadangan:
            <b><?= $data_rekap['cadangan'] ?? 0 ?></b>
        </p>
        <p>Jumlah Tidak Lulus:
            <b><?= $data_rekap['tidak_lulus'] ?? 0 ?></b>
        </p>
    </div>

    <div class="info">
        <h3>KETERANGAN</h3>

        <p><b>Kode Tempat Tes:</b></p>
        <ul>
            <li>A = Gedung A</li>
            <li>B = Gedung B</li>
            <li>V = Viktor</li>
        </ul>

        <p><b>Hasil Seleksi:</b></p>
        <ul>
            <li>Rata-rata >= 70 = Lulus</li>
            <li>Rata-rata 60 sampai kurang dari 70 = Cadangan</li>
            <li>Rata-rata kurang dari 60 = Tidak Lulus</li>
        </ul>
    </div>

</div>
</body>
</html>
```