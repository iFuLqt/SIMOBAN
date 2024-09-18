<body onload="print()">
    <h2>Nama : <?= $user['name_user']; ?></h2>
    <h2>Sekolah : <?= $user['school']; ?></h2>
    <table>
        <thead>
            <tr style="text-align: center;">
                <th>#</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Pekerjaan</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 1; ?>
            <?php foreach ($print as $p) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $p['date_job']; ?></td>
                <td><?= $p['time']; ?></td>
                <td><?= $p['job']; ?></td>
            </tr>
            <?php $i++; ?>
            <?php endforeach; ?>    
        </tbody>
    </table>
</body>