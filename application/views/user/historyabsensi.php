                <!-- Begin Page Content -->
                 <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid p-4 mb-3">
                        <div class="row mb-3">
                            <!-- Tambah Pekerjaan dan Refresh dalam satu baris -->
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="d-flex mb-2 mb-md-0">
                                            <a href="" class="btn btn-info w-100" data-toggle="modal" data-target="#newPrintHistoryAbsensiModal">
                                                <i class="fas fa-print"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex mb-2 mb-md-0">
                                            <form action="<?= base_url('user/refresh_historyabsensi') ?>" method="post" class="w-100">
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="fas fa-sync"></i> Refresh
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <!-- Form pencarian dengan tanggal yang responsif -->
                                <form action="<?= base_url('user/historyabsensi') ?>" method="post" class="row g-3">
                                    <!-- Input tanggal "Dari Tanggal" -->
                                    <div class="col-md-4">
                                        <label for="start_date" class="form-label">Dari Tanggal:</label>
                                        <input type="date" id="start_date" name="start_date" class="form-control">
                                    </div>
                                    <!-- Input tanggal "Sampai Tanggal" -->
                                    <div class="col-md-4">
                                        <label for="end_date" class="form-label">Sampai Tanggal:</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control">
                                    </div>
                                    <!-- Tombol Cari -->
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-secondary w-100 mt-3">
                                            <i class="fas fa-search"></i> Cari
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
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
                                    <td><?= $item['name_user'] ?></td>
                                    <td><?= $item['school'] ?></td>
                                    <td><?= $item['date_in'] ?></td>
                                    <td><?= $item['time'] ?></td>
                                    <td><?= $item['time_out'] ?></td>
                                    <?php $inf = $absen[$item['information']]; ?>
                                    <td><?= $inf; ?></td>
                                    <td><?= $item['note']; ?></td>
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
<!-- Modal Print -->
<div class="modal fade" id="newPrintHistoryAbsensiModal" tabindex="-1" aria-labelledby="newPrintHistoryAbsensiModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPrintHistoryAbsensiModalLabel">Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                &times;
            </span>
        </button>
      </div>
      <form action="<?= base_url('user/print_historyabsensi'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="start_date" class="form-label">Dari Tanggal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label">Sampai Tanggal:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <div class="form-group">
                <p>Tekan Saja Tombol Print Jika Ingin Mencetak Seluruh Data Absensi</p>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Print</button>
        </div>
      </form>
    </div>
  </div>
</div>