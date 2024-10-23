              <!-- Begin Page Content -->
              <div class="scroll">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>
                    <?= $this->session->flashdata('message'); ?>
                    <div class="card container-fluid">
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered table-hover table-striped " id="datatable">
                            <thead>
                                <tr style="text-align: center;">
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Sekolah</th>
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
                                ?>
                                <?php $i = 1; ?>
                                <?php foreach ($users as $d): ?>
                                <tr style="text-align: center;">
                                    <th scope="row"><?= $i; ?></th>
                                    <td><?= $d['name_user']; ?></td>
                                    <td><?= $d['school']; ?></td>
                                    <?php 
                                    $pengecek = $keaktifan[$d['is_active']];
                                    ?>
                                    <td><?= $pengecek; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <!-- Button Update -->
                                            <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                            data-target="#newUpdateDataStudentModal<?= $d['id_user']; ?>">
                                            <i class="fas fa-user-plus"></i>
                                            </button>
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="newUpdateDataStudentModal<?= $d['id_user']; ?>" tabindex="-1" aria-labelledby="newUpdateDataStudentModalLabel" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="newUpdateDataStudentModalLabel">Tambah Murid</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">
                                                                &times;
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <form action="<?= base_url('teacher/modal_select_student'); ?>" method="post">
                                                        <div class="modal-body">
                                                            <div class="form-group" style="text-align: left;">
                                                                <input type="hidden" value="<?= $d['id_user']; ?>" name="id_siswa">
                                                                <p>Yakin Menambahkan Sebagai Murid?</p>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Yes</button>
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
