                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                    <?= $this->session->flashdata('message'); ?>
                    <div class="table-responsive mt-3">
                    <div class="row mb-3">
                            <div class="col-12">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="d-flex mb-2 mb-md-0">
                                            <a href="" class="btn btn-info w-100" data-toggle="modal" data-target="#newPrintDataActivitiesModal">
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
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Hari/Tanggal</th>
                                    <th>Masuk</th>
                                    <th>Pekerjaan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($daily as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= date("d-m-Y", strtotime($d['date_job'])); ?></td>
                                    <td><?= $d['time']; ?></td>
                                    <td><?= $d['job']; ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Button Update -->
                                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                            data-target="#newUpdateDataActivitiesModal<?= $d['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="newUpdateDataActivitiesModal<?= $d['id']; ?>" tabindex="-1" aria-labelledby="newUpdateDataActivitiesModalLabel" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newUpdateDataActivitiesModalLabel">Edit Pekerjaan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('admin/update_modal_DataActivities'); ?>" method="post"">
                                                        <div class="modal-body">
                                                            <div class="form-group">
                                                                <input type="hidden" name="id" value="<?= $d['id']; ?>">
                                                                <label for="time">Jam Pekerjaan</label>
                                                                <input type="text" class="form-control" id="time" name="time" value="<?= $d['time']; ?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="job">Pekerjaan</label>
                                                                <input type="text" class="form-control" id="job" name="job" value="<?= $d['job']; ?>">
                                                            </div>
                                                            <div class="form-group">
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
                                            data-target="#newDeleteDataActivitiesModal<?= $d['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="newDeleteDataActivitiesModal<?= $d['id']; ?>" tabindex="-1" aria-labelledby="newDeleteDataActivitiesModalLabel" role="dialog" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content bg-danger">
                                                          <div class="modal-header">
                                                              <h5 class="modal-title" id="newDeleteDataActivitiesModalLabel">Delete Data</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                          <form action="<?= base_url('admin/delete_modal_DataActivities'); ?>" method="post">
                                                              <div class="modal-body">
                                                                  <input type="hidden" name="id" value="<?= $d['id']; ?>"> <!-- Pastikan ini terisi dengan ID yang benar -->
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
                </div>
                <div class="modal fade" id="newPrintDataActivitiesModal" tabindex="-1" aria-labelledby="newPrintDataActivitiesModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newPrintDataActivitiesModalLabel">Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                &times;
            </span>
        </button>
      </div>
      <form action="<?= base_url('admin/print_dataactivities'); ?>" method="post" enctype="multipart/form-data">
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
                    Semua Kegiatan?
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
