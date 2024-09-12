                <!-- Begin Page Content -->
                 <div class="scroll">
                <div class="container-fluid">
                    
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                        <div class="row">
                            <div class="col">
                                <a href="" class="btn btn-primary mt-3 mr-1" data-toggle="modal"
                                    data-target="#newDailyActivitiesModal">Tambah Pekerjaan</a> 
                            </div>
                        </div>
                    <?php if (isset($daily) && !empty($daily)) : ?>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Hari/Tanggal</th>
                                    <th>Jam</th>
                                    <th>Pekerjaan</th>  
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
                                <?php $i = 1; ?>
                                <?php foreach ($daily as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <?php
                                    // Mengambil hari dan bulan dari timestamp
                                    $hari_inggris = date('l', $d['date_job']);
                                    $bulan_inggris = date('F', $d['date_job']);
                                    
                                    // Mengubah ke dalam bahasa Indonesia
                                    $hari = $hari_indonesia[$hari_inggris];
                                    $bulan = $bulan_indonesia[$bulan_inggris];
                                    
                                    // Format tanggal dalam bahasa Indonesia
                                    $tanggal_lengkap = $hari . ', ' . date('d', $d['date_job']) . ' ' . $bulan . ' ' . date('Y', $d['date_job']);
                                    ?>
                                    <td><?= $tanggal_lengkap; ?></td>
                                    <td><?= $d['time']; ?></td>
                                    <td><?= $d['job']; ?></td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <center><p class="h5 mt-1 mb-3" style="text-size">Belum ada riwayat Kegiatan.</p></center>
                    <?php endif; ?>
                    </div>
                    </div>
                </div>
                </div>
<!-- Modal -->
<div class="modal fade" id="newDailyActivitiesModal" tabindex="-1" aria-labelledby="newDailyActivitiesModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newDailyActivitiesModalLabel">Tambah Pekerjaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                &times;
            </span>
        </button>
      </div>
      <form action="<?= base_url('user/modal_dailyactivities'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="time">Jam Pekerjaan</label>
                <input type="text" class="form-control" id="time" name="time" placeholder="08:00-16:00">
            </div>
            <div class="form-group">
                <label for="job">Pekerjaan</label>
                <input type="text" class="form-control" id="job" name="job" placeholder="">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>