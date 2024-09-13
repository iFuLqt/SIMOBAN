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
                                    <th>Aksi</th>  
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($daily as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= $d['date_job']; ?></td>
                                    <td><?= $d['time']; ?></td>
                                    <td><?= $d['job']; ?></td>
                                    <td>
                                        <div class="d-flex">
                                            <!-- Button Update -->
                                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                            data-target="#newUpdateDailyActivitiesModal<?= $d['id']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="newUpdateDailyActivitiesModal<?= $d['id']; ?>" tabindex="-1" aria-labelledby="newUpdateDailyActivitiesModalLabel" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newUpdateDailyActivitiesModalLabel">Edit Pekerjaan</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('user/update_modal_DailyActivities'); ?>" method="post"">
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
                                            data-target="#newDeleteDailyActivitiesModal<?= $d['id']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="newDeleteDailyActivitiesModal<?= $d['id']; ?>" tabindex="-1" aria-labelledby="newDeleteDailyActivitiesModalLabel" role="dialog" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content bg-danger">
                                                          <div class="modal-header">
                                                              <h5 class="modal-title" id="newDeleteDailyActivitiesModalLabel">Delete Absensi</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                          <form action="<?= base_url('user/delete_modal_DailyActivities'); ?>" method="post">
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