<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kop Surat Poliban</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .kop-surat {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            margin: 20px 0;
        }

        .kop-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            max-width: 900px;
            padding: 20px 0;
            border-bottom: 2px solid black;
        }

        .kop-header img {
            width: 150px; /* Atau nilai yang lebih besar sesuai kebutuhan */
            height: 150px;
        }

        .kop-header .text {
            flex: 2;
        }

        .kop-header h1 {
            margin: 0;
            font-size: 24px;
        }

        .kop-header h2 {
            margin: 0;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .kop-header p {
            margin: 5px 0;
            font-size: 20px;
        }

        .table-container {
            width: 100%;
            max-width: 900px;
            margin: 20px auto;
        }

        .table {
            width: 100%;
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
        }

        .student-info {
            text-align: center;
            margin: 20px 0;
        }

        .student-info h2 {
            margin: 5px 0;
        }
    </style>
</head>
<body onload="print()">

    <!-- Kop Surat -->
    <div class="kop-surat">
        <div class="kop-header">
            <img src="<?= base_url('assets/img/poliban.jpg'); ?>" alt="Logo Poliban" width="150px" height="150px">
            <div class="text">
                <h1>Politeknik Negeri Banjarmasin</h1>
                <h2>POLIBAN</h2>
                <p>Jl. Hasan Basri, Banjarmasin, Kalimantan Selatan</p>
                <p>Telp. (0511) 1234567 &nbsp; | &nbsp; Web: www.poliban.ac.id</p>
            </div>
        </div>
    </div>

    <!-- Informasi Siswa -->
    <div class="student-info">
        <h2>Nama: <?= $print[0]['name_user']; ?></h2>
        <h2>Sekolah: <?= $print[0]['school']; ?></h2>
        <h4 class="mt-5">Catatan Kegiatan Siswa</h4>
    </div>

    <!-- Tabel Data Absen -->
    <div class="table-container">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kegiatan</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($print as $p) : ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= date("d-m-Y", strtotime($p['date_in'])); ?></td>
                    <td><?= $p['time']; ?></td>
                    <td><?= $p['job']; ?></td>
                </tr>
                <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
