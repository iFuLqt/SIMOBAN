                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg">
                            <?php if(validation_errors()) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= validation_errors(); ?>
                                </div>
                            <?php endif ?>
                            <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>
                            <?= $this->session->flashdata('message'); ?>


                            <a href="" class="btn btn-primary mb-3" data-toggle="modal"
                            data-target="#newSubMenuModal">Add New Submenu</a>

                                <table class="table table-bordered table-hover table-striped" id="datatable">
                                    <thead>
                                        <tr style="text-align: center;">
                                            <th scope="col">#</th>
                                            <th scope="col">title</th>
                                            <th scope="col">Menu</th>
                                            <th scope="col">Url</th>
                                            <th scope="col">Icon</th>
                                            <th scope="col">Active</th>
                                            <th scope="col">Action</th>
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
                                        <?php foreach ($subMenu as $sm) : ?>
                                        <tr style="text-align: center;">
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $sm['title']; ?></td>
                                            <td><?= $sm['menu']; ?></td>
                                            <td><?= $sm['url']; ?></td>
                                            <td><?= $sm['icon']; ?></td>
                                            <?php
                                            $aktif = $keaktifan[$sm['is_active']] 
                                            ?>
                                            <td><?= $aktif; ?></td>
                                            <td>
                                                <!-- Button Update -->
                                                <button type="button" class="btn btn-primary mr-1" data-toggle="modal"
                                                data-target="#newUpdateDataStudentModal<?= $sm['id']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <!-- Modal Update -->
                                                <div class="modal fade" id="newUpdateDataStudentModal<?= $sm['id']; ?>" tabindex="-1" aria-labelledby="newUpdateDataStudentModalLabel" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="newUpdateDataStudentModalLabel">Edit Keaktifan</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">
                                                                    &times;
                                                                </span>
                                                            </button>
                                                        </div>
                                                        <form action="<?= base_url('mentor/update_modal_datastudent'); ?>" method="post"">
                                                            <div class="modal-body">
                                                                <div class="form-group">
                                                                    <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                                                                    <select name="active" id="active" class="form-control ml-2" style="width: 15rem;">
                                                                        <option value="">Pilih Keaktifan</option>
                                                                        <option value="1">
                                                                            Aktif
                                                                        </option>
                                                                        <option value="0">
                                                                            Nonaktif
                                                                        </option>
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
                                                data-target="#newDeleteDataStudentModal<?= $sm['id']; ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                <!-- Modal Delete -->
                                                <div class="modal fade" id="newDeleteDataStudentModal<?= $sm['id']; ?>" tabindex="-1" aria-labelledby="newDeleteDataStudentModalLabel" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content bg-danger">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="newDeleteDataStudentModalLabel">Delete Akun</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="<?= base_url('mentor/delete_modal_datastudent'); ?>" method="post">
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="id" value="<?= $sm['id']; ?>"> <!-- Pastikan ini terisi dengan ID yang benar -->
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
                                            </td>
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

<!-- MODAL -->

<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" aria-labelledby="newSubMenuModalLabel" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">
                &times;
            </span>
        </button>
      </div>
      <form action="<?= base_url('menu/submenu'); ?>" method="post">
        <div class="modal-body">
            <div class="form-group">
                <input type="text" class="form-control" id="title" name="title" placeholder="Submenu title">
            </div>
            <div class="form-group">
                <select name="menu_id" id="menu_id" class="form-control">
                    <option value="">Select Menu</option>
                    <?php  foreach($menu as $m)  : ?>
                        <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="url" name="url" placeholder="Submenu Url">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="icon" name="icon" placeholder="Submenu icon">
            </div>
            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" value="1" name="is_active" id="is_active" checked>
                    <label for="is_active" class="form-check-label"> Active? </label>
                </div>
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