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
                                    <th>Masuk</th>
                                    <th>Keluar</th>
                                    <th>Keterangan</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $absen = [
                                  '1' => 'Hadir',
                                  '2' => 'Sakit',
                                  '3' => 'Izin'
                                ];
                                 ?>
                                <?php foreach ($absensi as $item): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $item['Nama_Siswa'] ?></td>
                                    <td><?= $item['Sekolah'] ?></td>
                                    <td><?= $item['Tanggal'] ?></td>
                                    <td><?= $item['Waktu'] ?></td>
                                    <td><?= $item['Keluar'] ?></td>
                                    <?php $inf = $absen[$item['Keterangan']]; ?>
                                    <td><?= $inf ?></td>
                                    <td><?= $item['Catatan']; ?></td>
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