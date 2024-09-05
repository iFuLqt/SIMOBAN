                <!-- Begin Page Content -->
                 <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                    <div class="table-responsive mt-3"> 
                    <?php if (isset($absensi) && !empty($absensi)): ?>
                        <table class="table table-bordered table-hover table-striped" id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                <?php $i = 1; ?>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Sekolah</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $hari_indonesia = [
                                    'Sunday' => 'Minggu',
                                    'Monday' => 'Senin',
                                    'Tuesday' => 'Selasa',
                                    'Wednesday' => 'Rabu',
                                    'Thursday' => 'Kamis',
                                    'Friday' => 'Jumat',
                                    'Saturday' => 'Sabtu'
                                ];

                                $bulan_indonesia = [
                                    'January' => 'Januari',
                                    'February' => 'Februari',
                                    'March' => 'Maret',
                                    'April' => 'April',
                                    'May' => 'Mei',
                                    'June' => 'Juni',
                                    'July' => 'Juli',
                                    'August' => 'Agustus',
                                    'September' => 'September',
                                    'October' => 'Oktober',
                                    'November' => 'November',
                                    'December' => 'Desember'
                                ];
                                ?>
                                <?php foreach ($absensi as $item): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $item['Nama_Siswa'] ?></td>
                                    <td><?= $item['Sekolah'] ?></td>
                                    
                                    <?php
                                    // Mengambil hari dan bulan dari timestamp
                                    $hari_inggris = date('l', $item['Tanggal']);
                                    $bulan_inggris = date('F', $item['Tanggal']);
                                    
                                    // Mengubah ke dalam bahasa Indonesia
                                    $hari = $hari_indonesia[$hari_inggris];
                                    $bulan = $bulan_indonesia[$bulan_inggris];
                                    
                                    // Format tanggal dalam bahasa Indonesia
                                    $tanggal_lengkap = $hari . ', ' . date('d', $item['Tanggal']) . ' ' . $bulan . ' ' . date('Y', $item['Tanggal']);
                                    ?>

                                    <td><?= $tanggal_lengkap ?></td>
                                    <td><?= $item['Waktu'] ?></td>
                                    <td><?= $item['Keterangan'] ?></td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <center><p class="h5 mt-1 mb-3" style="text-size">Belum ada riwayat absensi.</p></center>
                    <?php endif; ?>
                    </div>
                    </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                </div>