                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="card container-fluid">
                    <div class="table-responsive mt-3"> 
                    <div class="row mb-3">
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
                                            <form action="<?= base_url('admin/refresh_dataabsensi') ?>" method="post" class="w-100">
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
                                <form action="<?= base_url('admin/dataabsensi') ?>" method="post" class="row g-3">
                                    <div class="col-md-4">
                                        <label for="start_date_admin" class="form-label">Dari Tanggal:</label>
                                        <input type="date" id="start_date_admin" name="start_date_admin" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="end_date_admin" class="form-label">Sampai Tanggal:</label>
                                        <input type="date" id="end_date_admin" name="end_date_admin" class="form-control">
                                    </div>
                                    <div class="col-md-4 d-flex align-items-end">
                                        <button type="submit" class="btn btn-secondary w-100 mt-3" name="filter">
                                            <i class="fas fa-calendar-week"></i> Filter
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <hr>
                        <table class="table table-bordered table-hover table-striped" id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                <?php $i = 1; ?>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Sekolah</th>
                                    <th>Tanggal</th>
                                    <th>Datang</th>
                                    <th>Pulang</th>
                                    <th>Keterangan</th>
                                    <th>Catatan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $aa = [];
                                foreach($value as $v){
                                  $aa[$v['id']] = $v['value'];
                                }
                                ?>
                                <?php foreach ($absensi as $absen): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $absen['name_user'] ?></td>
                                    <td><?= $absen['school'] ?></td>
                                    <td><?= date("d-m-Y", strtotime($absen['date_in'])); ?></td>
                                    <td><?= $absen['time'] ?></td>
                                    <td><?= $absen['time_out'] ?></td>
                                    <?php 
                                    $inf = $aa[$absen['information']];
                                    ?>
                                    <td><?= $inf; ?></td>
                                    <td><?= $absen['note']; ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Button Update -->
                                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                            data-target="#newUpdateDataAbsensiModal<?= $absen['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal Udate -->
                                              <div class="modal fade" id="newUpdateDataAbsensiModal<?= $absen['id']; ?>" tabindex="-1" aria-labelledby="newUpdateDataAbsensiModalLabel" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                  <div class="modal-content">
                                                    <div class="modal-header">
                                                      <h5 class="modal-title" id="newUpdateDataAbsensiModalLabel">Edit Absensi</h5>
                                                      <button type="button" class=" close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <form action="<?= base_url('admin/update_modal_dataabsensi'); ?>" method="post">
                                                      <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $absen['id']; ?>"> 
                                                        <div class="form-group" style="text-align: left;">
                                                          <label for="datee">Tanggal :</label>
                                                          <input type="date" name="datee" id="datee" class="form-control" value="<?= $absen['date_in']; ?>"></input>
                                                        </div>
                                                        <div class="form-group" style="text-align: left;">
                                                          <label for="timee">Datang :</label>
                                                          <input type="time" step="1" name="timee" id="timee" class="form-control" value="<?= $absen['time']; ?>"></input>
                                                          </select>
                                                        </div>
                                                        <div class="form-group" style="text-align: left;">
                                                          <label for="timee2">Pulang :</label>
                                                          <input type="time" step="1" name="timee2" id="timee2" class="form-control" value="<?= $absen['time']; ?>"></input>
                                                          </select>
                                                        </div>
                                                        <div class="form-group" style="text-align: left;">
                                                          <label for="information">Keaktifan :</label>
                                                          <select name="information" id="information" class="form-control">
                                                            <?php foreach ($value as $v) : ?>
                                                              <option value="<?= $v['id']; ?>" <?php if($absen['information'] == $v['id']) { echo 'selected'; } ?>>
                                                                <?= $v['value']; ?>
                                                              </option>
                                                            <?php endforeach; ?>
                                                          </select>
                                                        </div>
                                                        <div class="form-group" style="text-align: left;">
                                                          <label for="notee">Catatan :</label>
                                                          <input type="text" step="1" name="notee" id="notee" class="form-control" value="<?= $absen['note']; ?>"></input>
                                                          </select>
                                                        </div>
                                                      </div>
                                                      <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Ubah</button>
                                                      </div>
                                                    </form>
                                                  </div>
                                                </div>
                                              </div>

                                            <!-- Button Delete -->
                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#newDeleteDataAbsensiModal<?= $absen['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="newDeleteDataAbsensiModal<?= $absen['id']; ?>" tabindex="-1" aria-labelledby="newDeleteDataAbsensiModalLabel" role="dialog" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content bg-danger">
                                                          <div class="modal-header">
                                                              <h5 class="modal-title" id="newDeleteDataAbsensiModalLabel">Delete Absensi</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                          <form action="<?= base_url('admin/delete_modal_dataabsensi'); ?>" method="post">
                                                              <div class="modal-body">
                                                                  <input type="hidden" name="id" value="<?= $absen['id']; ?>"> <!-- Pastikan ini terisi dengan ID yang benar -->
                                                                  <div class="form-group"> <!-- Mengganti <da> dengan <div> -->
                                                                      <h4>Apakah Anda Yakin Ingin Menghapus Data?</h4>
                                                                  </div>
                                                              </div>
                                                              <div class="modal-footer">
                                                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                  <button type="submit" class="btn btn-primary">Delete</button>
                                                              </div>
                                                          </form>
                                                      </div>
                                                  </div>
                                              </div>

                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    </div>
                </div>
                <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->
                </div>
<!-- Modal -->
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
      <form action="<?= base_url('admin/print_dataabsensi'); ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="form-group">
                <label for="nama" class="form-label">Nama Siswa</label>
                <select name="nama" id="nama" class="form-control">
                    <option value="0">Pilih Siswa</option>
                    <?php  foreach($student as $s)  : ?>
                    <option value="<?= $s['id_user']; ?>"><?= $s['name_user']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="start_date" class="form-label">Dari Tanggal:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date" class="form-label">Sampai Tanggal:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="check" name="check">
                <label class="form-check-label" for="check">
                    Semua Absensi?
                </label>
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

