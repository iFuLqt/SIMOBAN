                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                    <?= $this->session->flashdata('message'); ?>
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
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $aa = [
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
                                    <td><?= $absen['date_in'] ?></td>
                                    <td><?= $absen['time'] ?></td>
                                    <?php 
                                    $inf = $aa[$absen['information']];
                                    ?>
                                    <td><?= $inf; ?></td>
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
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                    </div>
                                                    <form action="<?= base_url('admin/update_modal_dataabsensi'); ?>" method="post">
                                                      <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?= $absen['id']; ?>"> <!-- Pastikan ini terisi dengan ID yang benar -->
                                                        <div class="form-group">
                                                          <select name="information" id="information" class="form-control ml-2" style="width: 15rem;">
                                                            <option value="">Pilih Keterangan</option>
                                                            <?php foreach ($value as $v) : ?>
                                                              <option value="<?= $v['value']; ?>">
                                                                <?= $v['value']; ?>
                                                              </option>
                                                            <?php endforeach; ?>
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
 <!-- Modal -->

