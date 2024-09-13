                <!-- Begin Page Content -->
                <div class="scroll">
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h5 mb-3 text-gray-800"><?= $title; ?></h1>

                    <div class="row">
                        <div class="col-lg-8">
                            <?= form_open_multipart('user/edit'); ?>
                                <div class="form-group">
                                    <label for="email" class="col-sm-3 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="email" name="email"
                                        value="<?= $user['email_user']; ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" name="name"
                                        value="<?= $user['name_user']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nohp" class="col-sm-3 col-form-label">No. HP</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nohp" name="nohp"
                                        value="<?= $user['no_hp']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="school" class="col-sm-3 col-form-label">Sekolah</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="school" name="school"
                                        value="<?= $user['school']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="namapembimbing" class="col-sm-3 col-form-label">Nama Pembimbing (Sekolah)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="namapembimbing" name="namapembimbing"
                                        value="<?= $user['nama_pembimbing']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nohppembimbing" class="col-sm-3 col-form-label">No. HP Pembimbing (Sekolah)</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nohppembimbing" name="nohppembimbing"
                                        value="<?= $user['nohp_pembimbing']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="gedung" class="col-sm-3 col-form-label">Gedung</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="gedung" name="gedung"
                                        value="<?= $user['gedung']; ?>">
                                        <?= form_error('name','<small class="text-danger pl-3">','</small>');?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-3"> Foto </div>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-thumbnail">
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="image" name="image">
                                                    <label class="custom-file-label" for="costumFile">Choosen File</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary"> Edit </button>
                                    </div>
                                </div>


                            </form>
                        </div>
                    </div>
                    
                </div>
                <!-- /.container-fluid -->
                </div>
            </div>
            <!-- End of Main Content -->

