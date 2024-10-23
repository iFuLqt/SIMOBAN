                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="card container-fluid">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover table-striped" id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                <?php $i = 1; ?>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Sekolah</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Pulang</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                  $inform = [
                                    '1' => 'Hadir',
                                    '2' => 'Sakit',
                                    '3' => 'Izin'
                                  ];
                                 ?>
                                <?php foreach ($absensi as $absen): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $absen['name_user'] ?></td>
                                    <td><?= $absen['school'] ?></td>
                                    <td><?= date("d-m-Y", strtotime($absen['date_in'])); ?></td>
                                    <td><?= $absen['time'] ?></td>
                                    <td><?= $absen['time_out'] ?></td>
                                    <td><?= $inform[$absen['information']]; ?></td>
                                    <?php if($absen['note'] == 'Terlambat') : ?>
                                        <td style="color: red;"><?= $absen['note'] ?></td>
                                    <?php else : ?>
                                        <td><?= $absen['note']; ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                </div>

