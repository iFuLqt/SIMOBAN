              <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">
                    <div class="row">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <div class="card container-fluid">
                    <?php $this->session->flashdata('message'); ?>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Sekolah</th>
                                    <th>Magang (Jurusan)</th>
                                    <th>Keaktifan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $keaktifan = [
                                    '1' => 'Aktif',
                                    '0' => 'Nonaktif'
                                ];
                                $jj = [];
                                foreach($jurusan as $jur) {
                                    $jj[$jur['id']] = $jur['jurusan'];
                                }
                                ?>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= $d['school']; ?></td>
                                    <td><?= $jj[$d['id_jurusan']]; ?></td>
                                    <?php 
                                    $pengecek = $keaktifan[$d['is_active']];
                                    ?>
                                    <td><?= $pengecek; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Button detail -->
                                            <a href="<?= base_url('admin/detail_datastudent/' . $d['id_user']); ?>" type="button" class="btn btn-warning mr-1" >
                                                <i class="fas fa-list"></i>
                                            </a>
                                            <!-- Button Update -->
                                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                            data-target="#newUpdateDataStudentModal<?= $d['id_user']; ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="newUpdateDataStudentModal<?= $d['id_user']; ?>" tabindex="-1" aria-labelledby="newUpdateDataStudentModalLabel" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newUpdateDataStudentModalLabel">Edit Siswa</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('admin/update_modal_datastudent'); ?>" method="post"">
                                                        <div class="modal-body">
                                                            <div class="form-group" style="text-align: left;">
                                                                <input type="hidden" name="id" value="<?= $d['id_user']; ?>">
                                                                <label for="active">Keaktifan :</label>
                                                                <select name="active" id="active" class="form-control">
                                                                    <option value="1" <?php if($d['is_active'] == 1){ echo 'selected'; } ?>>
                                                                        Aktif
                                                                    </option>
                                                                    <option value="0" <?php if($d['is_active'] == 0) {echo 'selected'; } ?>>
                                                                        Nonaktif
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group" style="text-align: left;">
                                                                <label for="jurusan">Jurusan :</label>
                                                                <select name="jurusan" id="jurusan" class="form-control">
                                                                    <?php foreach ($jurusan as $jur) :?>
                                                                    <option value="<?= $jur['id']; ?>" <?php if($d['id_jurusan'] == $jur['id']) { echo 'selected';} ?>>
                                                                        <?= $jur['jurusan']; ?>
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
                                            data-target="#newDeleteDataStudentModal<?= $d['id_user']; ?>">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="newDeleteDataStudentModal<?= $d['id_user']; ?>" tabindex="-1" aria-labelledby="newDeleteDataStudentModalLabel" role="dialog" aria-hidden="true">
                                                  <div class="modal-dialog" role="document">
                                                      <div class="modal-content bg-danger">
                                                          <div class="modal-header">
                                                              <h5 class="modal-title" id="newDeleteDataStudentModalLabel">Delete Akun</h5>
                                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                  <span aria-hidden="true">&times;</span>
                                                              </button>
                                                          </div>
                                                          <form action="<?= base_url('admin/delete_modal_datastudent'); ?>" method="post">
                                                              <div class="modal-body">
                                                                  <input type="hidden" name="id" value="<?= $d['id_user']; ?>"> <!-- Pastikan ini terisi dengan ID yang benar -->
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
